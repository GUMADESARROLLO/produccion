<?php

namespace App\Providers;

use Laravel\Passport\Passport;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Admin\Menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        /*View::composer("layouts.menu", function ($view) {
            $menus = Menu::getMenu(true);
            
            $view->with('menus', $menus);
        });
        View::share('layouts');*/


        View::composer("layouts.menu", function ($view) {
            $menus = Menu::getMenu(true);
            $view->with('menusComposer', $menus);
        });
        View::share('layouts');

        Passport::routes(); 
    }
}
