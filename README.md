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
Update composer.json file.

Add to require section
```
"require": {
	"wpb/laravel_framework_loader": "1.*@dev",
}
```

Add git to repositories section
```
"scripts": { ... },
"repositories": [ 
	{
		"name": "wpb/laravel_framework_loader",
		"type": "git",
		"url": "https://github.com/TerrePorter/LaravelFrameworkLoader.git"
	}
],
```
