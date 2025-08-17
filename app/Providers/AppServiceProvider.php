<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;

use Illuminate\Support\ServiceProvider;
use App\Services\AlipayPlus\Signer;
use App\Services\AlipayPlus\Client as AlipayClient;
use App\Services\AlipayPlus\PaymentService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Signer::class, function ($app) {
            $cfg = $app['config']['alipayplus'];
            return new Signer(
                (string) $cfg['client_id'],
                (string) $cfg['private_key'],
                (string) $cfg['alipay_public_key'],
                (int) $cfg['key_version']
            );
        });

        $this->app->singleton(AlipayClient::class, function ($app) {
            $cfg = $app['config']['alipayplus'];
            return new AlipayClient(
                $app->make(Signer::class),
                (string) $cfg['host'],
                (string) $cfg['client_id']
            );
        });

        $this->app->singleton(PaymentService::class, function ($app) {
            return new PaymentService(
                $app->make(AlipayClient::class),
                $app['config']['alipayplus']
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
        //
        Schema::defaultStringLength(191);

    }
}
