<?php

namespace App\Providers;

use Livewire\Livewire;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         Schema::defaultStringLength(191);
    Livewire::setUpdateRoute(function ($handle) {
      return Route::post('/etudiants/public/livewire/update', $handle);
    });

    }
}
