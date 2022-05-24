# Documentation knight-artifact-entity-adapter-ksql-dialect-bq

Knight PHP library to use [BigQuery](https://cloud.google.com/bigquery/) dialect into [KSQL](https://github.com/energia-source/knight-artifact-entity-adapter-ksql/) Library.

**NOTE:** This repository is part of [Knight](https://github.com/energia-source/knight). Any
support requests, bug reports, or development contributions should be directed to
that project.

## Structure

library:
- [KSQL\dialects\bq\database](https://github.com/energia-source/knight-artifact-entity-adapter-ksql-dialect-bq/tree/main/lib/database)
- [KSQL\dialects\bq](https://github.com/energia-source/knight-artifact-entity-adapter-ksql-dialect-bq/tree/main/lib)

<br>

#### ***Class KSQL\dialects\bq\BigQuery usable methods***

##### `public static function Connection(string $constant = 'DEFAULT') : Connection`

This function creates a new instance of the Connection class

 * **Parameters:** `string` — The name of the constant to use.

     <p>
 * **Returns:** `` — connection object.

##### `public static function BindCharacter() : string`

Returns the character with ASCII value 64

 * **Returns:** The character with the ASCII value of 64, which is the character '@'.

##### `public static function ToJSON(Select $select) : string`

This function returns the column names of the select statement in a format that can be used by the JSON_QUERY function

 * **Parameters:** `Select` — The Select object that we're converting to JSON.

     <p>
 * **Returns:** The column name.

##### `public static function LastInsertID(Table $table) : string`

This function returns the last inserted ID

 * **Parameters:** `Table` — The table to insert into.

     <p>
 * **Returns:** The last inserted ID.

##### `public static function AnyValue(string $elaborate) : string`

Returns the value of the specified element

 * **Parameters:** `string` — the name of the field to be used in the query.

     <p>
 * **Returns:** The string 'ANY_VALUE(elaborate)'

##### `public static function FileReplacer(string $filtered) :? string`

This function takes a string as an argument and returns a string

 * **Parameters:** `string` — The string that is being filtered.

     <p>
 * **Returns:** `othin` — 

##### `public static function Limit(Statement $statement, Limit $limit) : void`

This function takes a Statement and a Limit object as parameters. It then checks to see if the Limit object has a value. If it does, it appends the value to the Statement. If it doesn't, it does nothing

 * **Parameters:**
   * `Statement` — The statement object to append the limit to.
   * `Limit` — The number of rows to return.

     <p>
 * **Returns:** `othing` — 

##### `public static function NaturalJoin(string $table) : string`

This function is used to create a natural join

 * **Parameters:** `string` — The table to join with.

     <p>
 * **Returns:** The string 'unknown'

## Built With

* [PHP](https://www.php.net/) - PHP

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
