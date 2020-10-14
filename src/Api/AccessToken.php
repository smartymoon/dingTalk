<?php


namespace Smartymoon\DingTalk\Api;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * 所有 API 都依赖 AccessToken , 有如下特点
 * 1. 有效期两小时，一旦访问自动续期
 * 2. 一个应用一个 access_token
 *
 * 开发要点
 * 1. 避免重复请求
 * 2. 当确认 access_token 可用时，设置缓存的有效期
 * 3. 当发现 access_token 无效时，马上销毁
 *
 * Class AccessToken
 * @package Smartymoon\DingTalk\Api
 */
class AccessToken
{
    /**
     * 利用缓存
     * 名字： ding_access_token_{agent}
     * 内容： string token
     * @param $agent
     */
    public static function get(string $agent)
    {
        return Cache::remember(config('app.env').'ding_access_token_'.$agent, 6200, function() use ($agent) {
            return Http::get('https://oapi.dingtalk.com/gettoken', [
                'appkey' => config("ding.agents.${agent}.app_key"),
                'appsecret' => config("ding.agents.${agent}.app_secret")
            ])->json('access_token');
        });
    }

    /**
     * 发现成功, 设置缓存为新的时间
     * @param string $agent
     * @param string $token
     */
    public static function refresh(string $agent, string $token)
    {
        Cache::put(config('app.env').'ding_access_token_'.$agent, $token, 6200);
    }

    public static function setNewToken(string $agent): string
    {
        $token = Http::get('https://oapi.dingtalk.com/gettoken', [
                'appkey' => config("ding.agents.${agent}.app_key"),
                'appsecret' => config("ding.agents.${agent}.app_secret")
            ])->json('access_token');
        return Cache::put(config('app.env').'ding_access_token_'.$agent, $token, 6200);
    }
}
