<?php namespace Mochaka\Sphinxql;

use Illuminate\Support\ServiceProvider;

class SphinxqlServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('sphinxql.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'shpinxql');

        $this->app->singleton('sphinxql', function ($app) {
            $host       = $app['config']->get('sphinxql')['host'];
            $port       = $app['config']->get('sphinxql')['port'];
            $connection = new \Foolz\SphinxQL\Connection();
            $connection->setConnectionParams($host, $port);

            return new Sphinxql(new \Foolz\SphinxQL\SphinxQL($connection));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('sphinxql');
    }

}
