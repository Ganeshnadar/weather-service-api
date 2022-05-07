<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Contracts\CityRepository;
use App\Repositories\Eloquent\EloquentCityRepository;
use App\Models\City;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(CityRepository::class, function () {
            return new EloquentCityRepository(new City());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        return [
            CityRepository::class,
        ];
    }
}
