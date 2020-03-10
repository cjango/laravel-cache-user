<?php

namespace Jason\CacheUser;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{

    /**
     * Notes: 加载时部署
     * @Author: <C.Jason>
     * @Date: 2020/2/26 6:05 下午
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/config.php' => config_path('cache-user.php')]);
        }

        Auth::provider('cache', function ($app, $config) {
            $config['model']::observe(UserObserver::class);

            return new CacheUserProvider(
                $app['hash'],
                $config['model'],
                config('cache-user.cache_ttl', 3600)
            );
        });
    }

    /**
     * Notes: 注册服务提供者
     * @Author: <C.Jason>
     * @Date: 2020/2/26 6:06 下午
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'cache-user');
    }

}
