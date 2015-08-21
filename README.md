# LaravelFrameworkLoader
Extension to Laravel 5 application to support custom paths

In bootstrap\app update the application to use the loader extension.

```php

// these are all optional, and are the defaults

$app = new Wpb\Laravel_Framework_Loader\Application (
    [
        'base' => realpath(__DIR__.'/../'),
        'config' => realpath(__DIR__.'/../config'),
        'database' => realpath(__DIR__.'/../database'),
        'lang' => realpath(__DIR__.'/../resources/lang'),
        'public' => realpath(__DIR__.'/../../public'),
        'storage' => realpath(__DIR__.'/../storage')
    ]
);

```