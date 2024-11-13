<?php
namespace App\Providers;

use App\Services\Interfaces\SmsServiceInterface;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

class SmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SmsServiceInterface::class, function($app) {
            $driver = config('sms.default');
            $config = config("sms.drivers.{$driver}.config");
            $class = config("sms.drivers.{$driver}.class");

            if (!$config || !$class) {
                throw new InvalidArgumentException("SMS driver configuration is invalid");
            }

            // Verify all required config values are present
            if ($driver === 'infobip' && (!isset($config['api_key']) || !isset($config['api_url']))) {
                throw new InvalidArgumentException("Infobip configuration is missing required values");
            }

            return new $class(...array_values($config));
        });
    }
}