[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sonrac/laravel-wamp/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sonrac/laravel-wamp/?branch=master)
[![StyleCI](https://styleci.io/repos/105322873/shield?branch=master&style=flat)](https://styleci.io/repos/105322873)
[![Code Coverage](https://scrutinizer-ci.com/g/sonrac/laravel-wamp/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/sonrac/laravel-wamp/?branch=master)
[![Build Status](https://travis-ci.org/sonrac/laravel-wamp.svg?branch=master)](https://travis-ci.org/sonrac/laravel-wamp)
[![codecov](https://codecov.io/gh/sonrac/laravel-wamp/branch/master/graph/badge.svg)](https://codecov.io/gh/sonrac/laravel-wamp)
![VersionEYE](https://www.versioneye.com/user/projects/59f10c5b15f0d71da6a7a832/badge.svg?style=flat-square)
[![License](https://poser.pugx.org/sonrac/wamp-server/license.svg)](https://github.com/sonrac/laravel-wamp/blob/master/LICENSE)
[![Total Downloads](https://poser.pugx.org/sonrac/wamp-server/d/total)](https://packagist.org/packages/sonrac/wamp-server)
[![Monthly Downloads](https://poser.pugx.org/sonrac/wamp-server/d/monthly)](https://packagist.org/packages/sonrac/wamp-server)
[![Daily Downloads](https://poser.pugx.org/sonrac/wamp-server/d/daily)](https://packagist.org/packages/sonrac/wamp-server)
[![composer.lock](https://poser.pugx.org/sonrac/wamp-server/composerlock)](https://packagist.org/packages/sonrac/wamp-server)
[![Build Status](https://travis-ci.org/sonrac/laravel-wamp.svg?branch=master)](https://travis-ci.org/sonrac/laravel-wamp)
[![Dependency Status](https://www.versioneye.com/user/projects/59f10c5b15f0d71da6a7a832/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/59f10c5b15f0d71da6a7a832)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/779eb389-8271-4690-8457-89fe4f379783/big.png)](https://insight.sensiolabs.com/projects/779eb389-8271-4690-8457-89fe4f379783)

[![pipeline status](https://git.conci.info/conci/service/lib/wamp-server/badges/master/pipeline.svg)](https://git.conci.info/conci/service/lib/wamp-server/commits/master)
[![coverage report](https://git.conci.info/conci/service/lib/wamp-server/badges/master/coverage.svg)](https://git.conci.info/conci/service/lib/wamp-server/commits/master)


# Wamp server for lumen/laravel

In demelopment state yet

## Install 
```bash
composer require sonrac/wamp-server
```

or add to your composer.json in section autoload

```
"sonrac/wamp-server": "0.1.*"
```

Register service provider:
```
\sonrac\WAMP\WAMPServiceProvider
```

Add console commands to you `Kernel.php`:
```
'\sonrac\WAMP\Commands\RunServer',
'\sonrac\WAMP\Commands\RegisterRoutes',
```

## Add subscriber:

```php
app()->wampRouter->addSubscriber('com2.hello', function ($clientSession, $client) {
    return 123;
});
```

## Add procedure: 
```php
app()->wampRouter->addRoute('com1.hello', function ($clientSession, $client) {
    return 123;
})
```

## Start server:

Usage help for get options help

```bash
php artisan wamp:run-server
```

This command let start server with registering predefined routes with client

## Register routes:

Usage help for get options help

```bash
php artisan register-routes
```

## Run tests

Test running for laravel & lumen both from script `run-tests.sh`

Run command:

```bash
sh run-tests.sh
```
