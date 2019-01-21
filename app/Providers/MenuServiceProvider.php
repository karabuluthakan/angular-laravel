<?php

namespace App\Providers;

use App\Menu;
use App\MenuLink;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('backend.layouts.sidebar', function ($view)
        {
            $links = [];
            $_links = Menu::where('position', 'admin_leftsidebar_menu')
                ->where('menus.status', Menu::STATUS_ACTIVE)
                ->join('menu_links', 'menu_links.menu_id', '=', 'menus.id')
                ->where('menu_links.status', MenuLink::STATUS_ACTIVE)
                ->orderBy('menu_links.parent')
                ->orderBy('menu_links.sort')
                ->get();

            foreach ($_links as $link) {
                $links[$link->id] = $link;
                if ($link->parent)
                    $links[$link->parent]->has_child = true;

                if (Route::current() && Route::current()->getName() == $link->route) {
                    $links[$link->id]->is_active = true;
                    if ($link->parent)
                        $links[$link->parent]->is_child_active = true;
                }
            }

            unset($_links);
            $view->with('links', $links);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
