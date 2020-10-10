<?php


namespace Smartymoon\DingTalk;



use Illuminate\Support\ServiceProvider;
use Smartymoon\DingTalk\Api\ApiApplication;

/**
 * 1. 从 EasyDingTalk 中复制业务逻辑
 * 2. 利用 laravel 官方 HTTP 库, Container
 * 3. 实现钉钉 Log channel
 * 4. 实现多应用功能, 利用配置文件
 * 5. 实现钉钉通知功能
 *
 * 过程
 * 研究 EasyDingTalk 逻辑过程
 * 研究 Laravel Http 使用方法
 */
class DingTalkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config' => config_path()], 'ding-talk');
            // todo 在 users 表中加入 ding_userid 字段
            // $this->publishes([__DIR__.'/../database/migrations' => database_path('migrations')], 'ding-talk');
        }
    }
}

