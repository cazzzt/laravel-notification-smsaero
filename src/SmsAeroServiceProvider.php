<?php

namespace Cazzzt\SmsAero;

use Cazzzt\SmsAero\Exceptions\InvalidConfiguration;
use Illuminate\Support\ServiceProvider;

class SmsAeroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->when(SmsAeroChannel::class)
            ->needs(SmsAeroClient::class)
            ->give(function () {
                $config = config('services.smsaero');
                if (is_null($config)) {
                    throw InvalidConfiguration::configurationNotSet();
                }

                return new SmsAeroClient(
                    $config['user'],
                    $config['secret'],
                    $config['sign'],
                    $config['digital']
                );
            });
    }
}
