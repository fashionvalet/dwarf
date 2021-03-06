<?php namespace Fv\Dwarf\Providers\Laravel;

use Fv\Dwarf\Indexer;
use Fv\Dwarf\Document;
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
        $this->registerDwarfDocument();
        $this->registerDwarfIndexer();
    }

    /**
     * [provides description]
     * @return [type] [description]
     */
    public function provides()
    {
        return ['elasticsearch.client', 'fv.dwarf.document', 'fv.dwarf.indexer'];
    }

    /**
     * [registerElasticsearchClient description]
     * @return [type] [description]
     */
    protected function registerElasticsearchClient()
    {
        $this->app->bindShared('elasticsearch.client', function ($app) {
            $hosts = $app['config']->get('elasticsearch.hosts', ['http://127.0.0.1:9200']);

            return Client::create()
                ->setHosts($hosts)
                ->build();
        });
    }

    /**
     * [registerDwarfMiner description]
     * @return [type] [description]
     */
    protected function registerDwarfDocument()
    {
        $this->app->bindShared('fv.dwarf.document', function ($app) {
            return new Document($app['elasticsearch.client']);
        });
    }

    protected function registerDwarfIndexer()
    {
        $this->app->bindShared('fv.dwarf.indexer', function ($app) {
            return new Indexer($app['elasticsearch.client']);
        });
    }
}
