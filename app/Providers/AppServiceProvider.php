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
        // $this->app->bind(AuthInterface::class, AuthService::class);

        //
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
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
        // Tambahkan Security Scheme ke OpenAPI sebelum dirender agar UI (Try It)
        // menampilkan field input untuk JWT bearer token.
        Scramble::afterOpenApiGenerated(function (OpenApi $openApi, OpenApiContext $context) {
            // Tambahkan skema HTTP Bearer (JWT) bernama 'BearerAuth'
            $openApi->secure(
                SecurityScheme::http('bearer', 'JWT')
                    ->as('BearerAuth')
                    ->setDescription('JWT Bearer token authentication')
                    ->default()
            );
        });
    }
}
