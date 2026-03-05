<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Module;
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
        View::composer('*', function ($view) {

            $modules = Module::whereNull('parent_module')
                ->where('status', 1)
                ->orderBy('priority')
                ->with([
                    'children' => function ($q) {
                        $q->where('status', 1)->orderBy('priority');
                    }
                ])
                ->get();

            $view->with('sidebarModules', $modules);
        });
        Paginator::useBootstrap();
    }
}
