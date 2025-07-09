<?php

namespace admin\emails;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class EmailTemplateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load routes, views, migrations from the package  
        $this->loadViewsFrom([
            base_path('Modules/Emails/resources/views'), // Published module views first
            resource_path('views/admin/email'), // Published views second
            __DIR__ . '/../resources/views'      // Package views as fallback
        ], 'email');
        
        // Also register module views with a specific namespace for explicit usage
        if (is_dir(base_path('Modules/Emails/resources/views'))) {
            $this->loadViewsFrom(base_path('Modules/Emails/resources/views'), 'emails-module');
        }
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // Also load migrations from published module if they exist
        if (is_dir(base_path('Modules/Emails/database/migrations'))) {
            $this->loadMigrationsFrom(base_path('Modules/Emails/database/migrations'));
        }

        // Only publish automatically during package installation, not on every request
        // Use 'php artisan emails:publish' command for manual publishing
        // $this->publishWithNamespaceTransformation();
        
        // Standard publishing for non-PHP files
        $this->publishes([
            __DIR__ . '/../database/migrations' => base_path('Modules/Emails/database/migrations'),
            __DIR__ . '/../resources/views' => base_path('Modules/Emails/resources/views/'),
        ], 'email');
       
        $this->registerAdminRoutes();

    }

    protected function registerAdminRoutes()
    {
        if (!Schema::hasTable('admins')) {
            return; // Avoid errors before migration
        }

        $admin = DB::table('admins')
            ->orderBy('created_at', 'asc')
            ->first();
            
        $slug = $admin->website_slug ?? 'admin';

        Route::middleware('web')
            ->prefix("{$slug}/admin") // dynamic prefix
            ->group(function () {
                $this->loadRoutesFrom(__DIR__.'/routes/web.php');
            });
    }

    public function register()
    {
        // Register the publish command
        if ($this->app->runningInConsole()) {
            $this->commands([
                \admin\emails\Console\Commands\PublishEmailsModuleCommand::class,
                \admin\emails\Console\Commands\CheckModuleStatusCommand::class,
                \admin\emails\Console\Commands\DebugEmailsCommand::class,
                \admin\emails\Console\Commands\TestViewResolutionCommand::class,
            ]);
        }
    }

    /**
     * Publish files with namespace transformation
     */
    protected function publishWithNamespaceTransformation()
    {
        // Define the files that need namespace transformation
        $filesWithNamespaces = [
            // Controllers
            __DIR__ . '/../src/Controllers/EmailManagerController.php' => base_path('Modules/Emails/app/Http/Controllers/Admin/EmailManagerController.php'),
            
            // Models
            __DIR__ . '/../src/Models/Email.php' => base_path('Modules/Emails/app/Models/Email.php'),
            
            // Requests
            __DIR__ . '/../src/Requests/EmailCreateRequest.php' => base_path('Modules/Emails/app/Http/Requests/EmailCreateRequest.php'),
            __DIR__ . '/../src/Requests/EmailUpdateRequest.php' => base_path('Modules/Emails/app/Http/Requests/EmailUpdateRequest.php'),
            
            // Routes
            __DIR__ . '/routes/web.php' => base_path('Modules/Emails/routes/web.php'),
        ];

        foreach ($filesWithNamespaces as $source => $destination) {
            if (File::exists($source)) {
                // Create destination directory if it doesn't exist
                File::ensureDirectoryExists(dirname($destination));
                
                // Read the source file
                $content = File::get($source);
                
                // Transform namespaces based on file type
                $content = $this->transformNamespaces($content, $source);
                
                // Write the transformed content to destination
                File::put($destination, $content);
            }
        }
    }

    /**
     * Transform namespaces in PHP files
     */
    protected function transformNamespaces($content, $sourceFile)
    {
        // Define namespace mappings
        $namespaceTransforms = [
            // Main namespace transformations
            'namespace admin\\emails\\Controllers;' => 'namespace Modules\\Emails\\app\\Http\\Controllers\\Admin;',
            'namespace admin\\emails\\Models;' => 'namespace Modules\\Emails\\app\\Models;',
            'namespace admin\\emails\\Requests;' => 'namespace Modules\\Emails\\app\\Http\\Requests;',
            
            // Use statements transformations
            'use admin\\emails\\Controllers\\' => 'use Modules\\Emails\\app\\Http\\Controllers\\Admin\\',
            'use admin\\emails\\Models\\' => 'use Modules\\Emails\\app\\Models\\',
            'use admin\\emails\\Requests\\' => 'use Modules\\Emails\\app\\Http\\Requests\\',
            
            // Class references in routes
            'admin\\emails\\Controllers\\EmailManagerController' => 'Modules\\Emails\\app\\Http\\Controllers\\Admin\\EmailManagerController',
        ];

        // Apply transformations
        foreach ($namespaceTransforms as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }

        // Handle specific file types
        if (str_contains($sourceFile, 'Controllers')) {
            $content = $this->transformControllerNamespaces($content);
        } elseif (str_contains($sourceFile, 'Models')) {
            $content = $this->transformModelNamespaces($content);
        } elseif (str_contains($sourceFile, 'Requests')) {
            $content = $this->transformRequestNamespaces($content);
        } elseif (str_contains($sourceFile, 'routes')) {
            $content = $this->transformRouteNamespaces($content);
        }

        return $content;
    }

    /**
     * Transform controller-specific namespaces
     */
    protected function transformControllerNamespaces($content)
    {
        // Update use statements for models and requests
        $content = str_replace(
            'use admin\\emails\\Models\\Email;',
            'use Modules\\Emails\\app\\Models\\Email;',
            $content
        );
        
        $content = str_replace(
            'use admin\\emails\\Requests\\EmailCreateRequest;',
            'use Modules\\Emails\\app\\Http\\Requests\\EmailCreateRequest;',
            $content
        );
        
        $content = str_replace(
            'use admin\\emails\\Requests\\EmailUpdateRequest;',
            'use Modules\\Emails\\app\\Http\\Requests\\EmailUpdateRequest;',
            $content
        );

        return $content;
    }

    /**
     * Transform model-specific namespaces
     */
    protected function transformModelNamespaces($content)
    {
        // Any model-specific transformations
        return $content;
    }

    /**
     * Transform request-specific namespaces
     */
    protected function transformRequestNamespaces($content)
    {
        // Any request-specific transformations
        return $content;
    }

    /**
     * Transform route-specific namespaces
     */
    protected function transformRouteNamespaces($content)
    {
        // Update controller references in routes
        $content = str_replace(
            'admin\\emails\\Controllers\\EmailManagerController',
            'Modules\\Emails\\app\\Http\\Controllers\\Admin\\EmailManagerController',
            $content
        );

        return $content;
    }
}
