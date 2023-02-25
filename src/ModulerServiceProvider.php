<?php

namespace Aldev\Moduler;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Aldev\Moduler\Console\Commands\CreateCommand;
use Aldev\Moduler\Console\Commands\ListCommand;

/**
 * The ModuleServiceProvider class.
 *
 * @package aldev/moduler
 * @author  Al Lestaire Acasio <allestaire.acasio@gmail.com>
 */
class ModulerServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     *
     * @return void
     */
    public function register()
    {
        // Load package's config
        $this->mergeConfigFrom($this->getPackageConfigPath(), 'moduler');

        // Register package's main service
        $this->app->singleton(Moduler::class, function ($app) {
            return new Moduler;
        });

        // Register package's command services
        $this->app->singleton(CreateCommand::class, function ($app) {
            return new CreateCommand;
        });

        // Register package's command services
        $this->app->singleton(ListCommand::class, function ($app) {
            return new ListCommand;
        });
    }

    /**
     * Bootstrap application services.
     *
     * @return void
     */
    public function boot()
    {
        // Bootstrap handle
        $this->bootConfig();
        $this->bootCommands();
        $this->bootRoutes();
        $this->bootTranslations();
        $this->bootViews();
    }

    /**
     * Get the services provided by the provider.
     *
     * This method is only really useful when this provider implements
     * the `DeferrableProvider` contract above.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Moduler::class,
            CreateCommand::class,
            ListCommand::class
        ];
    }

    /**
     * Get package's default config file path
     *
     * @return string
     */
    protected function getPackageConfigPath()
    {
        return __DIR__ . '/config/config.php';
    }

    /**
     * Publishing package's config
     *
     * @return void
     */
    protected function bootConfig()
    {
        $this->publishes([
            $this->getPackageConfigPath() => config_path('moduler.php')
        ], 'config');
    }

    /**
     * Handle package's commands
     *
     * @return void
     */
    protected function bootCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateCommand::class,
                ListCommand::class
            ]);
        }
    }

    /**
     * Loading package's routes
     *
     * @return void
     */
    protected function bootRoutes()
    {
        $packageRoutes = __DIR__ . '/routes/routes.php';

        $this->loadRoutesFrom($packageRoutes);
    }

    /**
     * Loading and publishing package's translations
     *
     * @return void
     */
    protected function bootTranslations()
    {
        $packageTranslationsPath = __DIR__ . '/resources/lang';

        $this->loadTranslationsFrom($packageTranslationsPath, 'moduler');
        $this->publishes([
            $packageTranslationsPath => resource_path('lang/vendor/moduler'),
        ], 'lang');
    }

    /**
     * Loading and publishing package's views
     *
     * @return void
     */
    protected function bootViews()
    {
        $packageViewsPath = __DIR__ . '/resources/views';

        $this->loadViewsFrom($packageViewsPath, 'moduler');
        $this->publishes([
            $packageViewsPath => resource_path('views/vendor/moduler'),
        ], 'views');
    }
}
