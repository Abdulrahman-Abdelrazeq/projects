<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Http\Resources\ListShopResource;

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
        
        if(request('x') == 2) dd(bcrypt(123456)); // auth()->loginUsingId(2);
        
        Paginator::useBootstrap();
        
        ListShopResource::withoutWrapping();
    
    }
}