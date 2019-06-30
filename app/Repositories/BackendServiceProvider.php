<?php

namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
        'App\Repositories\TemplateRepositoryInterface',
        'App\Repositories\TemplateRepository'
    );
    }
}