<?PHP

namespace KSQL\dialects\bq;

use Knight\Configuration;

use KSQL\Statement;
use KSQL\entity\Table;
use KSQL\dialects\constraint\Dialect;
use KSQL\operations\Select;
use KSQL\operations\select\Limit;

use KSQL\dialects\bq\database\BigQuery as Connection;

/* This class is used to create a connection to a BigQuery database */

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

    /**
     * This function creates a new instance of the Connection class
     * 
     * @param string constant The name of the constant to use.
     * 
     * @return A connection object.
     */

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

   /**
    * Returns the character with ASCII value 64
    * 
    * @return The character with the ASCII value of 64, which is the character '@'.
    */

    public static function BindCharacter() : string
    {
        return chr(64);
    }

    /**
     * This function returns the column names of the select statement in a format that can be used by
     * the JSON_QUERY function
     * 
     * @param Select select The Select object that we're converting to JSON.
     * 
     * @return The column name.
     */

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

    /**
     * This function returns the last inserted ID
     * 
     * @param Table table The table to insert into.
     * 
     * @return The last inserted ID.
     */

    public static function LastInsertID(Table $table) : string
    {
        throw new CustomException('developer/database/dialects/insert/last/id/unknown');
        return static::UNKNOWN;
    }

    /**
     * Returns the value of the specified element
     * 
     * @param string elaborate the name of the field to be used in the query.
     * 
     * @return The string 'ANY_VALUE(elaborate)'
     */

    public static function AnyValue(string $elaborate) : string
    {
        $any = 'ANY_VALUE' . chr(40) . $elaborate . chr(41);
        return $any;
    }

    /**
     * This function takes a string as an argument and returns a string
     * 
     * @param string filtered The string that is being filtered.
     * 
     * @return Nothing
     */

    public static function FileReplacer(string $filtered) :? string
    {
        return null;
    }

    /**
     * This function takes a Statement and a Limit object as parameters. 
     * It then checks to see if the Limit object has a value. If it does, 
     * it appends the value to the Statement. If it doesn't, it does nothing
     * 
     * @param Statement statement The statement object to append the limit to.
     * @param Limit limit The number of rows to return.
     * 
     * @return Nothing.
     */

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

    /**
     * This function is used to create a natural join
     * 
     * @param string table The table to join with.
     * 
     * @return The string 'unknown'
     */

    public static function NaturalJoin(string $table) : string
    {
        throw new CustomException('developer/database/dialects/join/natural/unknown');
        return static::UNKNOWN;
    }
}
