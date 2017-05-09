<?php

namespace Goodwong\LaravelWechatWeb;

use Illuminate\Support\ServiceProvider;

class WechatWebServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->publishes([
            __DIR__.'/config/oauth.php' => config_path('wechat_web_oauth.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/oauth.php', 'wechat_web_oauth'
        );
    }
}

