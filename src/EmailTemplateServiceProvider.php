<?php

namespace admin\emails;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class EmailTemplateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load routes, views, migrations from the package
        // $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'email');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->mergeConfigFrom(__DIR__.'/../config/email.php', 'email.constants');
        

        $this->publishes([  
            __DIR__ . '/../config/email.php' => config_path('constants/email.php'),
            __DIR__.'/../resources/views' => resource_path('views/admin/email'),
            __DIR__ . '/../src/Controllers' => app_path('Http/Controllers/Admin/EmailManager'),
            __DIR__ . '/../src/Models' => app_path('Models/Admin/Email'),
            __DIR__ . '/routes/web.php' => base_path('routes/admin/admin_email.php'),
        ], 'email');

        $this->registerAdminRoutes();

    }

    protected function registerAdminRoutes()
    {
        if (!Schema::hasTable('admins')) {
            return; // Avoid errors before migration
        }

        $slug = DB::table('admins')->latest()->value('website_slug') ?? 'admin';

        Route::middleware('web')
            ->prefix("{$slug}/admin") // dynamic prefix
            ->group(function () {
                $this->loadRoutesFrom(__DIR__.'/routes/web.php');
            });
    }

    public function register()
    {
        // You can bind classes or configs here
    }
}
