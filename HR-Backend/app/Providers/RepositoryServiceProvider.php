<?php

namespace App\Providers;

use App\Repositories\HrProjectTaskRepository;
use App\Repositories\Interfaces\HrProjectTaskRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            HrProjectTaskRepositoryInterface::class,
            HrProjectTaskRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
