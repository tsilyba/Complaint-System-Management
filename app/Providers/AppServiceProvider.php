<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Facades\ComplaintFacade;
use App\Repositories\SQLComplaintRepo;
use App\Services\NotificationService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the ComplaintFacade to the Service Container
        // This tells Laravel: "When someone asks for ComplaintFacade, create it like this:"
        $this->app->bind(ComplaintFacade::class, function ($app) {
            return new ComplaintFacade(
                new SQLComplaintRepo(),      
                new NotificationService());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
