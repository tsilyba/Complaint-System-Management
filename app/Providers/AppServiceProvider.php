<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Facades\ComplaintFacade;
use App\Repositories\SQLComplaintRepo;
use App\Services\NotificationService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Binding ComplaintFacade
        $this->app->bind(ComplaintFacade::class, function ($app) {
            return new ComplaintFacade(
                new SQLComplaintRepo(),      
                new NotificationService());
        });
    }

    
    
}
