<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Archive;
use App\Models\Department;
use App\Models\StorageLocation;
use App\Models\User;
use App\Observers\ArchiveObserver;
use App\Observers\DepartmentObserver;
use App\Observers\StorageLocationObserver;
use App\Observers\UserObserver;
use App\Listeners\LogSuccessfulLogin;
use App\Listeners\LogSuccessfulLogout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Pagination\Paginator;

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
        Archive::observe(ArchiveObserver::class);
        User::observe(UserObserver::class);
        Department::observe(DepartmentObserver::class);
        StorageLocation::observe(StorageLocationObserver::class);

        Event::listen(Login::class, LogSuccessfulLogin::class);
        Event::listen(Logout::class, LogSuccessfulLogout::class);

        Paginator::useBootstrapFive();
    }
}
