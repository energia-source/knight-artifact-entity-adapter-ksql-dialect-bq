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

#### ***Class KSQL\dialects\bq\database\BigQuery usable methods***

##### `public function __construct(Dialect $dialect, string ...$array)`

This function is used to create a new instance of the BigQueryClient class

 * **Parameters:** `Dialect` — The name of the dialect.

##### `public function execute(Statement $statement)`

This function executes a prepared statement

 * **Parameters:** `Statement` — The statement to execute.

     <p>
 * **Returns:** The result of the query.

## Built With

* [PHP](https://www.php.net/) - PHP

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details