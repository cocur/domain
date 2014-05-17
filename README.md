cocur/domain
============

> Check availability of domain names and get WHOIS information.


Features
--------

- Check availability of domains
- Retrieve WHOIS information of domains
- Command line tool and library
- Compatible with PHP >= 5.4 and [HHVM](http://hhvm.com)


Installation
------------

Dependending on how you want to use Domain there exist different installation methods.

### Composer

If you want to use the library as a dependency in your project you should use Composer to do so:

```shell
$ composer require cocur/domain:@dev
```

*Currently there exists no stable release of domain.*

### Download PHAR

If you only want to use the command line tool to retrieve WHOIS information you can download the PHAR.

```shell
$ wget TO_DO_FILL_IN_DOWNLOAD_URL
$ chmod +x whois.phar
$ mv whois.phar /usr/local/bin/cwhois
```

You can now retrieve WHOIS information using Cocur Domain by executing

```shell
$ cwhois
```


Usage
-----

### Command line WHOIS

You can use the included command line tool to retrieve WHOIS information about a domain:

```shell
$ php whois.phar cocur.co
```

### Library

The library contains two main classes: `Whois\Client` and `Availability\Client` They require information about WHOIS servers and patterns to match available domains stored in `data/tld.json`.

#### Whois

```php
use Cocur\Domain\Connection\ConnectionFactory;
use Cocur\Domain\Data\DataLoader;
use Cocur\Domain\Whois\Client;

$factory = new ConnectionFactory();
$dataLoader = new DataLoader();
$data = $dataLoader->load(__DIR__.'/data/tld.json');

$client = new Client($factory, $data);

echo $client->query($domainName);
```

#### Availability

To check the availability of a domain name the `Availability\Client` requires an instance of `Whois\Client`.

```php
use Cocur\Domain\Connection\ConnectionFactory;
use Cocur\Domain\Data\DataLoader;
use Cocur\Domain\Whois\Client as WhoisClient;
use Cocur\Domain\Availability\Client as AvailabilityClient;

$factory = new ConnectionFactory();
$dataLoader = new DataLoader();
$data = $dataLoader->load(__DIR__.'/data/tld.json');

$whoisClient = new WhoisClient($factory, $data);
$client = new AvailabilityClient($whoisClient, $data);

echo $client->isAvailable($domainName);
```


Changelog
---------

### Version 0.1 (*not yet released*)

- Initial release


Author
------

### [Florian Eckerstorfer](http://florian.ec) [![Support Florian](http://img.shields.io/gittip/florianeckerstorfer.svg)](https://www.gittip.com/FlorianEckerstorfer/)

- [Twitter](http://twitter.com/Florian_)
- [App.net](http://app.net/florian)


License
-------

The MIT license applies to `cocur/domain`. For the full copyright and license information, please view the LICENSE file distributed with this source code.
