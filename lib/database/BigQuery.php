<?PHP

namespace extensions\database;

use KSQL\Factory;
use KSQL\Statement;
use KSQL\dialects\constraint\Dialect;
use KSQL\connection\Common as Connection;

use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\Core\Exception\BadRequestException;

final class BigQuery extends Connection
{
    const LOCATION = 'location';
    const SERVICE_ACCOUNT = 'keyFile';

    public function __construct(Dialect $dialect, string ...$array)
    {
        parent::__construct($dialect, ...$array);

        $bq_hash = $this->getHash();
        $bq = Factory::searchConnectionFromHash($bq_hash);

        if (null === $bq) $bq = new BigQueryClient([
            static::LOCATION => $array[0],
            static::SERVICE_ACCOUNT => array(
                'type' => $array[1],
                'project_id' => $array[2],
                'private_key_id' => $array[3],
                'private_key' => $array[4],
                'client_email' => $array[5],
                'client_id' => $array[6],
                'auth_uri' => $array[7],
                'token_uri' => $array[8],
                'auth_provider_x509_cert_url' => $array[9],
                'client_x509_cert_url' => $array[10]
            ),
        ]);

        $this->setInstance($bq);
    }

    public function execute(Statement $statement)
    {
        try {
            $instance = $this->getInstance();
            if (null === $instance)
                throw new CustomException('developer/database/statement/connection/instance');

            $sintax = $statement->get();
            $sintax_bind = $statement->getBind();
            $sintax_bind_dialect = $this->getDialect();
            $sintax_bind_dialect_separator = $sintax_bind_dialect::BindCharacter();
            $sintax_bind = array_filter($sintax_bind, function (string $key) use ($sintax_bind_dialect_separator, $sintax) {
                $regex = '/' . chr(40) . $sintax_bind_dialect_separator . $key . chr(41) . chr(92) . chr(98) . '/';
                return preg_match($regex, $sintax);
            }, ARRAY_FILTER_USE_KEY);

            $job = $instance->query($sintax)->parameters($sintax_bind);
            $job_result = $instance->runQuery($job);

            return $job_result;
        } catch (BadRequestException $exception) {
        }

        return null;
    }
}