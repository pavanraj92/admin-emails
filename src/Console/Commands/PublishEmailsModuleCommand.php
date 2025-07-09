<?php

namespace admin\emails\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PublishEmailsModuleCommand extends Command
{
    protected $signature = 'emails:publish {--force : Force overwrite existing files}';
    protected $description = 'Publish Emails module files with proper namespace transformation';

    public function handle()
    {
        $this->info('Publishing Emails module files...');

        // Check if module directory exists
        $moduleDir = base_path('Modules/Emails');
        if (!File::exists($moduleDir)) {
            File::makeDirectory($moduleDir, 0755, true);
        }

        // Publish with namespace transformation
        $this->publishWithNamespaceTransformation();
        
        // Publish other files
        $this->call('vendor:publish', [
            '--tag' => 'email',
            '--force' => $this->option('force')
        ]);

        // Update composer autoload
        $this->updateComposerAutoload();

        $this->info('Emails module published successfully!');
        $this->info('Please run: composer dump-autoload');
    }

    protected function publishWithNamespaceTransformation()
    {
        $basePath = dirname(dirname(__DIR__)); // Go up to packages/admin/emails/src
        
        $filesWithNamespaces = [
            // Controllers
            $basePath . '/Controllers/EmailManagerController.php' => base_path('Modules/Emails/app/Http/Controllers/Admin/EmailManagerController.php'),
            
            // Models
            $basePath . '/Models/Email.php' => base_path('Modules/Emails/app/Models/Email.php'),
            
            // Requests
            $basePath . '/Requests/EmailCreateRequest.php' => base_path('Modules/Emails/app/Http/Requests/EmailCreateRequest.php'),
            $basePath . '/Requests/EmailUpdateRequest.php' => base_path('Modules/Emails/app/Http/Requests/EmailUpdateRequest.php'),
            
            // Routes
            $basePath . '/routes/web.php' => base_path('Modules/Emails/routes/web.php'),
        ];

        foreach ($filesWithNamespaces as $source => $destination) {
            if (File::exists($source)) {
                File::ensureDirectoryExists(dirname($destination));
                
                $content = File::get($source);
                $content = $this->transformNamespaces($content, $source);
                
                File::put($destination, $content);
                $this->info("Published: " . basename($destination));
            } else {
                $this->warn("Source file not found: " . $source);
            }
        }
    }

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
            $content = str_replace('use admin\\emails\\Models\\Email;', 'use Modules\\Emails\\app\\Models\\Email;', $content);
            $content = str_replace('use admin\\emails\\Requests\\EmailCreateRequest;', 'use Modules\\Emails\\app\\Http\\Requests\\EmailCreateRequest;', $content);
            $content = str_replace('use admin\\emails\\Requests\\EmailUpdateRequest;', 'use Modules\\Emails\\app\\Http\\Requests\\EmailUpdateRequest;', $content);
        }

        return $content;
    }

    protected function updateComposerAutoload()
    {
        $composerFile = base_path('composer.json');
        $composer = json_decode(File::get($composerFile), true);

        // Add module namespace to autoload
        if (!isset($composer['autoload']['psr-4']['Modules\\Emails\\'])) {
            $composer['autoload']['psr-4']['Modules\\Emails\\'] = 'Modules/Emails/app/';
            
            File::put($composerFile, json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            $this->info('Updated composer.json autoload');
        }
    }
}
