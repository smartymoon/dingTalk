<?php

/*
 * This file is part of the mingyoung/dingtalk.
 *
 * (c) 张铭阳 <mingyoungcheung@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Smartymoon\DingTalk\Api;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Smartymoon\DingTalk\Log\DingLog;

class BaseClient
{
    private string $agent;
    private string $base_uri = 'https://oapi.dingtalk.com/';
    /**
     * @var mixed
     */
    private $access_token;

    /**
     * BaseClient constructor.
     * @param string $agent
     */
    public function __construct(string $agent)
    {
        $this->agent = $agent;
        $this->access_token = AccessToken::get($agent);
    }

    public function post($uri, $data = [])
    {
        $response =  Http::retry(2, 100)
            ->post(
                $this->base_uri . $uri . '?access_token='. $this->access_token,
                $data
            )->json();
        return $this->checkFail($response, $uri, $data);
    }

    /**
     * 有些模块中有 get 方法，因此这里取 getData 以防止冲突
     * @param $uri
     * @param array $query
     * @return mixed
     */
    public function getData($uri, $query = [])
    {
        $response = Http::retry(2, 100)
            ->get($this->base_uri . $uri, [
                'access_token' => $this->access_token
            ] + $query)->json();
        return $this->checkFail($response, $uri, $query);
    }

    private function checkFail($response, $uri, $data)
    {
        // todo 处理 access_token 异常问题
        if (!app()->environment('production') || config('ding.debug')) {
            DingLog::recordApi($uri, $data, $response);
        }

        if ($response['errcode'] == '0') {
            AccessToken::refresh($this->agent, $this->access_token);
        } else {
            DingLog::recordApiFail($uri, $data, $response);
        }

        return $response;
    }
}
