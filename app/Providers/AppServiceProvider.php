<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Suppress E_DEPRECATED notices from vendor packages (PHP 8.5 compat)
        set_error_handler(function (int $errno, string $errstr, string $errfile, int $errline) {
            if ($errno === E_DEPRECATED && str_contains($errfile, DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR)) {
                return true;
            }
            return false;
        }, E_DEPRECATED);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Gate::define('admin', function (User $user) {
            return $user->is_admin;
        });
        Gate::define('user', function (User $user) {
            return $user->is_admin === 0;
        });
    }
}
