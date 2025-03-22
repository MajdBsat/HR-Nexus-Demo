<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Fix for array to string conversion in migrations
        $hasTableMethod = function ($table) {
            if (is_array($table)) {
                $table = $table[0];
            }

            $originalMethod = new \ReflectionMethod('Illuminate\Database\Schema\MySqlBuilder', 'hasTable');
            $originalMethod->setAccessible(true);
            return $originalMethod->invoke($this, $table);
        };

        // Apply the monkey patch using runkit extension if available
        if (extension_loaded('runkit') || extension_loaded('runkit7')) {
            if (function_exists('runkit_method_redefine')) {
                runkit_method_redefine(
                    'Illuminate\Database\Schema\MySqlBuilder',
                    'hasTable',
                    $hasTableMethod
                );
            }
        }
    }
}
