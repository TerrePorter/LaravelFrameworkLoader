<?php

namespace Wpb\LaravelFrameworkLoader;

use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;

class Application extends \Illuminate\Foundation\Application {

    /**
     * The base path for the Laravel installation.
     *
     * @var string
     */
    protected $basePath;

    /**
     * The custom config path defined by the developer.
     *
     * @var string
     */
    protected $configPath;

    /**
     * The custom database path defined by the developer.
     *
     * @var string
     */
    protected $databasePath;

    /**
     * The custom language path defined by the developer.
     *
     * @var string
     */
    protected $langPath;

    /**
     * The custom public path defined by the developer.
     *
     * @var string
     */
    protected $publicPath;

    /**
     * The custom storage path defined by the developer.
     *
     * @var string
     */
    protected $storagePath;

    /**
     * Create a new Illuminate application instance.
     *
     * set paths for 'base', 'config', 'database', 'lang', 'public', 'storage'
     *
     * @param array|null $appPaths
     * @return void
     */
    public function __construct($appPaths = null) {
        $this->registerBaseBindings ();

        $this->registerBaseServiceProviders ();

        $this->registerCoreContainerAliases ();

        // set base and default paths
        if (isset ( $appPaths ['base'] )) {
            $this->setBasePath ( $appPaths ['base'] );
        }

        // overwrite path if set by developer in appPaths
        if (isset ( $appPaths ['config'] )) {
            $this->useConfigPath ( $appPaths ['config'] );
        }

        if (isset ( $appPaths ['database'] )) {
            $this->useDatabasePath ( $appPaths ['database'] );
        }

        if (isset ( $appPaths ['lang'] )) {
            $this->useLangPath ( $appPaths ['lang'] );
        }

        if (isset ( $appPaths ['public'] )) {
            $this->usePublicPath ( $appPaths ['public'] );
        }

        if (isset ( $appPaths ['storage'] )) {
            $this->useStoragePath ( $appPaths ['storage'] );
        }
    }

    /**
     * Set the base path for the application.
     *
     * @param string $basePath
     * @return $this
     */
    public function setBasePath($basePath) {
        $this->basePath = rtrim ( $basePath, '\/' );
        $this->bindPathsInContainer ();
        return $this;
    }

    /**
     * Bind all of the application paths in the container.
     *
     * @return void
     */
    protected function bindPathsInContainer()
    {
        $this->instance('path', $this->path());
        $this->instance('path.base', $this->basePath());
        $this->instance('path.lang', $this->langPath());
        $this->instance('path.config', $this->configPath());
        $this->instance('path.public', $this->publicPath());
        $this->instance('path.storage', $this->storagePath());
        $this->instance('path.database', $this->databasePath());
        $this->instance('path.resources', $this->resourcePath());
        $this->instance('path.bootstrap', $this->bootstrapPath());

    }

    /**
     * Get the path to the resources directory.
     *
     * @param  string  $path
     * @return string
     */
    public function resourcePath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'resources'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the path to the bootstrap directory.
     *
     * @param  string  $path Optionally, a path to append to the bootstrap path
     * @return string
     */
    public function bootstrapPath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'bootstrap'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the path to the application "app" directory.
     *
     * @param  string  $path
     * @return string
     */
    public function path($path = '')
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'app';
    }

    /**
     * Get the base path of the Laravel installation.
     *
     * @param  string  $path Optionally, a path to append to the base path
     * @return string
     */
    public function basePath($path = '')
    {
        return $this->basePath;
    }

    /**
     * Get the path to the application configuration files.
     *
     * @param  string  $path Optionally, a path to append to the config path
     * @return string
     */
    public function configPath($path = '')
    {
        return $this->configPath ?  : $this->basePath . DIRECTORY_SEPARATOR . 'config';
    }

    /**
     * Set the config directory.
     *
     * @param string $path
     * @return $this
     */
    public function useConfigPath($path) {
        $this->configPath = $path;
        $this->instance ( 'path.config', $path );
        return $this;
    }

    /**
     * Get the path to the database directory.
     *
     * @param  string  $path Optionally, a path to append to the database path
     * @return string
     */
    public function databasePath($path = '')
    {
        return ($this->databasePath ?: $this->basePath.DIRECTORY_SEPARATOR.'database').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Set the database directory.
     *
     * @param string $path
     * @return $this
     */
    public function useDatabasePath($path) {
        $this->databasePath = $path;
        $this->instance ( 'path.database', $path );
        return $this;
    }

    /**
     * Get the path to the language files.
     *
     * @return string
     */
    public function langPath() {
        return $this->langPath ?  : $this->basePath . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'lang';
    }

    /**
     * Set the lang directory.
     *
     * @param string $path
     * @return $this
     */
    public function useLangPath($path) {
        $this->langPath = $path;
        $this->instance ( 'path.lang', $path );
        return $this;
    }

    /**
     * Get the path to the public / web directory.
     *
     * @return string
     */
    public function publicPath() {
        return $this->publicPath ?  : $this->basePath . DIRECTORY_SEPARATOR . 'public';
    }

    /**
     * Set the public directory.
     *
     * @param string $path
     * @return $this
     */
    public function usePublicPath($path) {
        $this->publicPath = $path;
        $this->instance ( 'path.public', $path );
        return $this;
    }

    /**
     * Get the path to the storage directory.
     *
     * @return string
     */
    public function storagePath() {
        return $this->storagePath ?  : $this->basePath . DIRECTORY_SEPARATOR . 'storage';
    }

    /**
     * Set the storage directory.
     *
     * @param string $path
     * @return $this
     */
    public function useStoragePath($path) {
        $this->storagePath = $path;
        $this->instance ( 'path.storage', $path );
        return $this;
    }

    /**
     * Get or check the current application environment.
     *
     * @param  string|array  $environments
     * @return string|bool
     */
    public function environment(...$environments)
    {
        if (count($environments) > 0) {
            $patterns = is_array($environments[0]) ? $environments[0] : $environments;

            return Str::is($patterns, $this['env']);
        }

        return $this['env'];
    }
}
