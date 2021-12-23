<?php

namespace App\Providers;

use App\Models\Option;
use Illuminate\Support\ServiceProvider;

class SingletonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        //Repositories
        $this->app->alias(\App\Repositories\OptionRepository::class, 'Option');
        $this->app->singleton(\App\Repositories\OptionRepository::class, function($app){
            return new \App\Repositories\OptionRepository($app->make(Option::class));
        });

        //
        $this->app->alias(\App\Presenters\Html\HtmlPresenter::class, 'Html');
        $this->app->singleton(\App\Presenters\Html\HtmlPresenter::class, function($app){
            return new \App\Presenters\Html\HtmlPresenter;
        });
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
