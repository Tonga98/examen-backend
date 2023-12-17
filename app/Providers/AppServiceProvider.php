<?php

namespace App\Providers;

use App\Models\Pokemon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

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
        Validator::extend('format_and_exists', function ($attribute, $value, $parameters, $validator) {
            foreach ($value as $v) {
                if (!array_key_exists('id', $v) || !array_key_exists('orden', $v)) {
                    return false;
                }
                if (!Pokemon::where('id', $v['id'])->exists()) {
                    return false;
                }
            }
            return true;
        });
    }
}
