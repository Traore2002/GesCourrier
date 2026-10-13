<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // 👈 AJOUTER CETTE LIGNE

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // AJOUTER CETTE LIGNE POUR CORRIGER L'ERREUR DE LONGUEUR DE CLÉ
        Schema::defaultStringLength(191);
    }
}