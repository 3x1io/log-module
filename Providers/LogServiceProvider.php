<?php

namespace Modules\Log\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Base\Services\Components\Base\Lang;
use Modules\Base\Services\Core\VILT;

class LogServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Log';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'log';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfig();
        VILT::loadResources($this->moduleName);
        VILT::loadPages($this->moduleName);
        VILT::registerTranslation(Lang::make('logs.sidebar')->label(__('Logs')));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }
}
