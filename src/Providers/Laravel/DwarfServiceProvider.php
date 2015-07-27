<?php namespace Fv\Dwarf\Providers\Laravel;

use Illuminate\Support\ServiceProvider;
use Elasticsearch\ClientBuilder as Client;

class DwarfServiceProvider extends ServiceProvider
{
    /**
     * [register description]
     * @return [type] [description]
     */
    public function register()
    {
        $this->registerElasticsearchClient();
        $this->registerDwarfMiner();
    }

    /**
     * [provides description]
     * @return [type] [description]
     */
    public function provides()
    {
        return ['elasticsearch.client', 'fv.dwarf'];
    }

    /**
     * [registerElasticsearchClient description]
     * @return [type] [description]
     */
    protected function registerElasticsearchClient()
    {
        $this->app->bindShared('elasticsearch.client', function ($app) {
            $hosts = $app['config']->get('elasticsearch.hosts', ['http://127.0.0.1:9200']);

            return new Client::create()
                ->setHosts($hosts)
                ->build();
        });
    }

    /**
     * [registerDwarfMiner description]
     * @return [type] [description]
     */
    protected function registerDwarfMiner()
    {
        $this->app->bindShared('fv.dwarf', function ($app) {
            $miner = new Miner($app['elasticsearch.client']);
            $miner->setDocument(new Document);

            return $miner;
        });
    }
}
