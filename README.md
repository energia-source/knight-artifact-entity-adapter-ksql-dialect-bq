# Documentation knight-artifact-entity-adapter-ksql-dialect-bq

Knight PHP library to use [BigQuery](https://cloud.google.com/bigquery/) dialect into [KSQL](https://github.com/energia-source/knight-artifact-entity-adapter-ksql/) Library.

**NOTE:** This repository is part of [Knight](https://github.com/energia-source/knight). Any
support requests, bug reports, or development contributions should be directed to
that project.

## Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh

$ composer require knight/artifact-entity-adapter-ksql-dialect-bq

```

## Configuration

Configuration is grouped into configuration namespace by the framework [Knight](https://github.com/energia-source/knight).
The configuration files are stored in the configurations folder and file named BigQuery.php.

So the basic setup looks something like this:

```

<?PHP

namespace configurations;

use Knight\Lock;

use extensions\BigQuery as Define;

final class BigQuery
{
	use Lock;

	const CHARON = [
		// location of the server
		Define::CONFIGURATION_LOCATION => 'europe-west6',
		// account type
		Define::CONFIGURATION_TYPE => 'service_account',
		// project id in GCP
		Define::CONFIGURATION_PROJECT_ID => 'energia-cloud-project',
		// id of the private key
		Define::CONFIGURATION_PRIVATE_KEY_ID => 'bb634afae02a4456718531ae0323661f',
		// private key for API
		Define::CONFIGURATION_PRIVATE_KEY => "-----BEGIN RSA PRIVATE KEY-----\nMIICXAIBAAKBgQCqGKukO1De7zhZj6+H0qtjTkVxwTCpvKe4eCZ0FPqri0cb2JZfXJ/DgYSF6vUp\nwmJG8wVQZKjeGcjDOL5UlsuusFncCzWBQ7RKNUSesmQRMSGkVb1/3j+skZ6UtW+5u09lHNsj6tQ5\n1s1SPrCBkedbNf0Tp0GbMJDyR4e9T04ZZwIDAQABAoGAFijko56+qGyN8M0RVyaRAXz++xTqHBLh\n3tx4VgMtrQ+WEgCjhoTwo23KMBAuJGSYnRmoBZM3lMfTKevIkAidPExvYCdm5dYq3XToLkkLv5L2\npIIVOFMDG+KESnAFV7l2c+cnzRMW0+b6f8mR1CJzZuxVLL6Q02fvLi55/mbSYxECQQDeAw6fiIQX\nGukBI4eMZZt4nscy2o12KyYner3VpoeE+Np2q+Z3pvAMd/aNzQ/W9WaI+NRfcxUJrmfPwIGm63il\nAkEAxCL5HQb2bQr4ByorcMWm/hEP2MZzROV73yF41hPsRC9m66KrheO9HPTJuo3/9s5p+sqGxOlF\nL0NDt4SkosjgGwJAFklyR1uZ/wPJjj611cdBcztlPdqoxssQGnh85BzCj/u3WqBpE2vjvyyvyI5k\nX6zk7S0ljKtt2jny2+00VsBerQJBAJGC1Mg5Oydo5NwD6BiROrPxGo2bpTbu/fhrT8ebHkTz2epl\nU9VQQSQzY1oZMVX8i1m5WUTLPz2yLJIBQVdXqhMCQBGoiuSoSjafUhV7i1cEGpb88h5NBYZzWXGZ\n37sJ5QsW+sJyoNde3xH8vdXhzU7eT82D6X/scw9RZz+/6rCJ4p0=\n-----END RSA PRIVATE KEY-----\n",
		// the service account email associated with the client
		Define::CONFIGURATION_CLIENT_EMAIL => 'account@energia-cloud-project.iam.gserviceaccount.com',
		// client ID
		Define::CONFIGURATION_CLIENT_ID => '107906518850433760437',
		// the authorization server endpoint URI
		Define::CONFIGURATION_AUTH_URI => 'https://accounts.google.com/o/oauth2/auth',
		// URI of the token
		Define::CONFIGURATION_TOKEN_URI => 'https://oauth2.googleapis.com/token',
		// the URL of the public x509 certificate, used to verify the signature on JWTs signed by the authentication provider
		Define::CONFIGURATION_AUTH_PROVIDER_X509_CERT_URL => 'https://www.googleapis.com/oauth2/v1/certs',
		// the URL of the public x509 certificate, used to verify JWTs signed by the client
		Define::CONFIGURATION_CLIENT_X509_CERT_URL => 'https://www.googleapis.com/robot/v1/metadata/x509/account%40energia-cloud-project.iam.gserviceaccount.com'
	];
}

```

## Structure

library:
- [KSQL\dialects\bq\database](https://github.com/energia-source/knight-artifact-entity-adapter-ksql-dialect-bq/tree/main/lib/database)
- [KSQL\dialects\bq](https://github.com/energia-source/knight-artifact-entity-adapter-ksql-dialect-bq/tree/main/lib)

## Usage

```

...

$timed = time() - 86400;

$table = new Table();
$table_collection = sprintf(Table::NAME, $query_serial, $query_device);
$table->setCollectionName($table_collection);
$table_timestamp = $table->getField('timestamp');
$table_timestamp_name = $table_timestamp->getName();
$table_query_connection = Factory::connect(BigQuery::class, 'CHARON');
$table_query = KSQL::start($table_query_connection, $table);
$table_query_connection_dialect = $table_query_connection->getDialect();
$table->getInjection()->addColumn($table_query_connection_dialect,
	$table_timestamp_name, '#name# > $0',
	$timed);

...

```

## Built With

* [PHP](https://www.php.net/) - PHP

## Contributing

Please read [CONTRIBUTING.md](https://github.com/energia-source/knight-artifact-entity-adapter-ksql-dialect-bq/blob/main/CONTRIBUTING.md) for details on our code of conduct, and the process for submitting us pull requests.

## Versioning

We use [SemVer](https://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/energia-source/knight-artifact-entity-adapter-ksql-dialect-bq/tags). 

## Authors

* **Paolo Fabris** - *Initial work* - [energia-europa.com](https://www.energia-europa.com/)
* **Gabriele Luigi Masero** - *Developer* - [energia-europa.com](https://www.energia-europa.com/)

See also the list of [contributors](https://github.com/energia-source/knight-artifact-entity-adapter-ksql-dialect-bq/blob/main/CONTRIBUTORS.md) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details