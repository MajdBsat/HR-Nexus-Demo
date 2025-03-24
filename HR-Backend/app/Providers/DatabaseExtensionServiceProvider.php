<?php

namespace App\Providers;

use App\Extensions\MySqlBuilderFix;
use Illuminate\Database\Connection;
use Illuminate\Support\ServiceProvider;

class DatabaseExtensionServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Extend the MySqlBuilder with our fixed version
        Connection::resolverFor('mysql', function ($connection, $database, $prefix, $config) {
            return new \Illuminate\Database\MySqlConnection($connection, $database, $prefix, $config);
        });

        $this->app->resolving('db.connection.mysql', function ($connection) {
            $connection->setSchemaGrammar($connection->getSchemaGrammar());
            $connection->setSchemaBuilder(new MySqlBuilderFix($connection));
            return $connection;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
