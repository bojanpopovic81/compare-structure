<?php

namespace BpLab\CompareStructure\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use BpLab\CompareStructure\Contracts\SampleInterface;
use BpLab\CompareStructure\Facades\CompareStructureFacade;
//use BpLab\CompareStructure\CompareStructure;

/**
 * Class CompareStructureServiceProvider
 *
 */
class CompareStructureServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the package.
     */
    public function boot()
    {
        /*
        |--------------------------------------------------------------------------
        | Publish the Config file from the Package to the App directory
        |--------------------------------------------------------------------------
        */
        $this->configPublisher();

	    if ($this->app->runningInConsole()) {
		    $this->commands([
			    FooCommand::class,
		    ]);
	    }

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        /*
        |--------------------------------------------------------------------------
        | Implementation Bindings
        |--------------------------------------------------------------------------
        */
        $this->implementationBindings();

        /*
        |--------------------------------------------------------------------------
        | Facade Bindings
        |--------------------------------------------------------------------------
        */
        $this->facadeBindings();

        /*
        |--------------------------------------------------------------------------
        | Registering Service Providers
        |--------------------------------------------------------------------------
        */
        $this->serviceProviders();
    }

    /**
     * Implementation Bindings
     */
    private function implementationBindings()
    {
        $this->app->bind(
            SampleInterface::class
            //Sample::class
        );
    }

    /**
     * Publish the Config file from the Package to the App directory
     */
    private function configPublisher()
    {
        // When users execute Laravel's vendor:publish command, the config file will be copied to the specified location
        $this->publishes([
            __DIR__ . '/Config/compare-structure.php' => $this->app->basePath() . '/config/compare-structure.php',
        ]);
    }

    /**
     * Facades Binding
     */
    private function facadeBindings()
    {
        // Register 'nextpack.say' instance container
        $this->app['compare.structure'] = $this->app->share(function ($app) {
            return $app->make(CompareStructureFacade::class);
        });

        // Register 'Sample' Alias, So users don't have to add the Alias to the 'app/config/app.php'
	    /*
        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('CompareStructure', CompareStructure::class);
        });
	    */
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Registering Other Custom Service Providers (if you have)
     */
    private function serviceProviders()
    {
        // $this->app->register('...\...\...');
    }

}
