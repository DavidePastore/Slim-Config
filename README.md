# Slim Framework Config

[![Latest version][ico-version]][link-packagist]
[![Build Status][ico-github-actions]][link-github-actions]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]
[![PSR2 Conformance][ico-styleci]][link-styleci]


A file configuration loader that supports PHP, INI, XML, JSON, and YML files for the Slim Framework. It internally uses [hassankhan/config][hassankhan-config].

## Install

Via Composer

``` bash
$ composer require davidepastore/slim-config
```

Requires Slim 3.0.0 or newer.

## Usage

In most cases you want to register `DavidePastore\Slim\Config` for a single route, however,
as it is middleware, you can also register it for all routes.


### Register per route

```php
$app = new \Slim\App();

// Fetch DI Container
$container = $app->getContainer();

// Register provider
$container['config'] = function () {
  //Create the configuration
  return new \DavidePastore\Slim\Config\Config('config.json');
};

$app->get('/api/myEndPoint',function ($req, $res, $args) {
    //Here you have your configuration
    $config = $this->config->getConfig();
    $secret = $config->get('security.secret');
})->add($container->get('config'));

$app->run();
```


### Register for all routes

```php
$app = new \Slim\App();

// Fetch DI Container
$container = $app->getContainer();

// Register provider
$container['config'] = function () {
  //Create the configuration
  return new \DavidePastore\Slim\Config\Config('config.json');
};

// Register middleware for all routes
// If you are implementing per-route checks you must not add this
$app->add($container->get('config'));

$app->get('/foo', function ($req, $res, $args) {
  //Here you have your configuration
  $config = $this->config->getConfig();
  $secret = $config->get('security.secret');
});

$app->post('/bar', function ($req, $res, $args) {
  //Here you have your configuration
  $config = $this->config->getConfig();
  $ttl = $config->get('app.timeout', 3000);
});

$app->run();
```

## Where are the benefits?

The configuration is loaded from the filesystem only when the given route is called in the _per route_ usage. In the other case (_all routes_) the config should be general and used in the whole routes, because it's read in every request.

## Just the tip of the iceberg!

You can read the [hassankhan/config][hassankhan-config] documentation [here][hassankhan-config] for more info.

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Davide Pastore](https://github.com/davidepastore)


[hassankhan-config]: https://github.com/hassankhan/config
[ico-version]: https://img.shields.io/packagist/v/DavidePastore/Slim-Config.svg?style=flat-square
[ico-github-actions]: https://github.com/DavidePastore/Slim-Config/workflows/Continuous%20Integration/badge.svg?branch=master
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/DavidePastore/Slim-Config.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/davidepastore/Slim-Config.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/davidepastore/slim-config.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/53088130/shield

[link-packagist]: https://packagist.org/packages/davidepastore/slim-config
[link-github-actions]: https://github.com/DavidePastore/Slim-Config/actions?query=workflow%3A%22Continuous+Integration%22
[link-scrutinizer]: https://scrutinizer-ci.com/g/DavidePastore/Slim-Config/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/DavidePastore/Slim-Config
[link-downloads]: https://packagist.org/packages/davidepastore/slim-config
[link-styleci]: https://styleci.io/repos/53088130/
