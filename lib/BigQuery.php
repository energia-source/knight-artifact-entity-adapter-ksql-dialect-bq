<?PHP

namespace extensions;

use Knight\Configuration;

use KSQL\Statement;
use KSQL\entity\Table;
use KSQL\dialects\constraint\Dialect;
use KSQL\operations\Select;
use KSQL\operations\select\Limit;

use KSQL\dialects\bq\database\BigQuery as Connection;

final class BigQuery extends Dialect
{
    use Configuration;

    const CONFIGURATION_LOCATION = 0x445C3;
    const CONFIGURATION_TYPE = 0x445C0;
    const CONFIGURATION_PROJECT_ID = 0x445C1;
    const CONFIGURATION_PRIVATE_KEY_ID = 0x445D4;
    const CONFIGURATION_PRIVATE_KEY = 0x445DE;
    const CONFIGURATION_CLIENT_EMAIL = 0x44642;
    const CONFIGURATION_CLIENT_ID = 0x4464C;
    const CONFIGURATION_AUTH_URI = 0x44612;
    const CONFIGURATION_TOKEN_URI = 0x44A5E;
    const CONFIGURATION_AUTH_PROVIDER_X509_CERT_URL = 0x446D8;
    const CONFIGURATION_CLIENT_X509_CERT_URL = 0x44EAA;

    public static function Connection(string $constant = 'DEFAULT') : Connection
    {
        $dialect = static::name();

        $keyfile_localtion = static::getConfiguration(static::CONFIGURATION_LOCATION, true, $dialect, $constant);
        $keyfile_type = static::getConfiguration(static::CONFIGURATION_TYPE, true, $dialect, $constant);
        $keyfile_project_id = static::getConfiguration(static::CONFIGURATION_PROJECT_ID, true, $dialect, $constant);
        $keyfile_private_key_id = static::getConfiguration(static::CONFIGURATION_PRIVATE_KEY_ID, true, $dialect, $constant);
        $keyfile_private_key = static::getConfiguration(static::CONFIGURATION_PRIVATE_KEY, true, $dialect, $constant);
        $keyfile_client_email = static::getConfiguration(static::CONFIGURATION_CLIENT_EMAIL, true, $dialect, $constant);
        $keyfile_client_id = static::getConfiguration(static::CONFIGURATION_CLIENT_ID, true, $dialect, $constant);
        $keyfile_token_uri = static::getConfiguration(static::CONFIGURATION_TOKEN_URI, true, $dialect, $constant);
        $keyfile_auth_uri = static::getConfiguration(static::CONFIGURATION_AUTH_URI, true, $dialect, $constant);
        $keyfile_auth_provider_x509_cert_url = static::getConfiguration(static::CONFIGURATION_AUTH_PROVIDER_X509_CERT_URL, true, $dialect, $constant);
        $keyfile_client_x509_cert_url = static::getConfiguration(static::CONFIGURATION_CLIENT_X509_CERT_URL, true, $dialect, $constant);

        $connection_dialect = static::instance();
        $connection = new Connection($connection_dialect,
            $keyfile_localtion,
            $keyfile_type,
            $keyfile_project_id,
            $keyfile_private_key_id,
            $keyfile_private_key,
            $keyfile_client_email,
            $keyfile_client_id,
            $keyfile_token_uri,
            $keyfile_auth_uri,
            $keyfile_auth_provider_x509_cert_url,
            $keyfile_client_x509_cert_url
        );

        return $connection;
    }

    public static function BindCharacter() : string
    {
        return chr(64);
    }

    public static function ToJSON(Select $select) : string
    {
        $column = $select->getTable();
        $column = $select->getAllColumns($column, true);
        $column = array_keys($column);

        $column_injection = $select->getInjection()->getColumns();
        $column_injection = array_keys($column_injection);
        $column = array_merge($column, $column_injection);
        $column = array_unique($column, SORT_STRING);
        $column = preg_filter('/^.*$/', chr(96) . '$0' . chr(96) . chr(32) . 'AS' . chr(32) . chr(96) . '$0' . chr(96), $column);
        $column = implode(chr(44) . chr(32), $column);
        $column = 'STRUCT' . chr(40) . $column . chr(41);

        if (1 !== $select->getLimit()->get())
            $column = 'ARRAY_AGG' . chr(40) . $column . chr(41);

        return $column;
    }

    public static function LastInsertID(Table $table) : string
    {
        throw new CustomException('developer/database/dialects/insert/last/id/unknown');
        return static::UNKNOWN;
    }

    public static function AnyValue(string $elaborate) : string
    {
        $any = 'ANY_VALUE' . chr(40) . $elaborate . chr(41);
        return $any;
    }

    public static function FileReplacer(string $filtered) :? string
    {
        return null;
    }

    public static function Limit(Statement $statement, Limit $limit) : void
    {
        $value = $limit->get();
        if (null === $value) return;

        $statement->append('LIMIT');
        $statement->append($value);

        $offest = $limit->getOffset();
        if (null !== $offest) {
            $statement->append('OFFSET');
            $statement->append($offest);
        }
    }

    public static function NaturalJoin(string $table) : string
    {
        throw new CustomException('developer/database/dialects/join/natural/unknown');
        return static::UNKNOWN;
    }
}