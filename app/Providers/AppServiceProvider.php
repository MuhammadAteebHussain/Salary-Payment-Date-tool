<?php

namespace App\Providers;

use App\Contracts\FileInterface;
use App\Contracts\GeneralResponseServiceInterface;
use App\Contracts\SalaryDateInterface;
use App\Services\General\CSVFileService;
use App\Services\General\GeneralResponseService;
use App\Services\General\SalaryDateService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SalaryDateInterface::class, SalaryDateService::class);
        $this->app->bind(FileInterface::class, CSVFileService::class);
        $this->app->bind(GeneralResponseServiceInterface::class, GeneralResponseService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
