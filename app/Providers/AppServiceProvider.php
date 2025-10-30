<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use App\Services\ItemService;
use App\Services\VendorService;
use App\Services\OrderService;
use App\Services\VendorItemService;
use App\Services\AuthService;

use App\Services\Contracts\ItemInterface;
use App\Services\Contracts\VendorInterface;
use App\Services\Contracts\OrderInterface;
use App\Services\Contracts\VendorItemInterface;
use App\Services\Contracts\AuthInterface;

use App\Services\Contracts\ReportInterface;
use App\Services\ReportService;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\OpenApiContext;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ItemInterface::class, ItemService::class);
        $this->app->singleton(VendorInterface::class, VendorService::class);
        $this->app->singleton(OrderInterface::class, OrderService::class);
        $this->app->singleton(VendorItemInterface::class, VendorItemService::class);
        $this->app->singleton(ReportInterface::class, ReportService::class);
        $this->app->singleton(AuthInterface::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Scramble::afterOpenApiGenerated(function (OpenApi $openApi, OpenApiContext $context) {
            $openApi->secure(
                SecurityScheme::http('bearer', 'JWT')
                    ->as('BearerAuth')
                    ->setDescription('JWT Bearer token authentication')
                    ->default()
            );
        });


    }
}
