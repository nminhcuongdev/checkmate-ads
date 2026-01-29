<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            \App\Repositories\Customer\CustomerRepositoryInterface::class,
            \App\Repositories\Customer\CustomerRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Account\AccountRepositoryInterface::class,
            \App\Repositories\Account\AccountRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Report\ReportRepositoryInterface::class,
            \App\Repositories\Report\ReportRepository::class
        );
        $this->app->singleton(
            \App\Repositories\History\HistoryRepositoryInterface::class,
            \App\Repositories\History\HistoryRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Group\GroupRepositoryInterface::class,
            \App\Repositories\Group\GroupRepository::class
        );

        $this->app->singleton(
            \App\Repositories\NotPay\NotPayRepositoryInterface::class,
            \App\Repositories\NotPay\NotPayRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Admin\AdminRepositoryInterface::class,
            \App\Repositories\Admin\AdminRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Bank\BankRepositoryInterface::class,
            \App\Repositories\Bank\BankRepository::class
        );

        $this->app->singleton(
            \App\Repositories\BankReport\BankReportRepositoryInterface::class,
            \App\Repositories\BankReport\BankReportRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Currency\CurrencyRepositoryInterface::class,
            \App\Repositories\Currency\CurrencyRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Notification\NotificationRepositoryInterface::class,
            \App\Repositories\Notification\NotificationRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Paginator::useBootstrap();
    }
}
