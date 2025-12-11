<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Schema::defaultStringLength(191);
        //thêm giỏ hàng 
        View::composer('*', function ($view) {
            $cart = session('cart', []); // Lấy giỏ hàng từ session
            $view->with('cart', $cart);
        });

    }
}
