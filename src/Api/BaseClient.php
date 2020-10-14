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
use Smartymoon\DingTalk\Exceptions\AccessTokenException;
use Smartymoon\DingTalk\Exceptions\DingApiException;
use Smartymoon\DingTalk\Exceptions\HttpException;

class BaseClient
{
    private string $agent;
    private string $base_uri = 'https://oapi.dingtalk.com/';
    private int $fail_times = 0;
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
        $result =  $this->checkFail($response, $uri, $data);

        if ($result === false) {
            throw new DingApiException();
        }

        if ($result === true) {
            return $response;
        }

        if ($result === 'try_again') {
            return $this->post($uri, $data);
        }
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
        $result =  $this->checkFail($response, $uri, $query);

        if ($result === true) {
            return $response;
        }

        if ($result === 'try_again') {
            return $this->getData($uri, $query);
        }
    }

    private function checkFail($response, $uri, $data)
    {
        if (!app()->environment('production') || config('ding.debug')) {
            DingLog::recordApi($uri, $data + ['access_token' => $this->access_token], $response);
        }

        if ($response['errcode'] == 0) {
            AccessToken::refresh($this->agent, $this->access_token);
            return true;
        } elseif ($response['errcode'] == 88){
            $this->fail_times++;
            if ($this->fail_times > 2) {
                throw new AccessTokenException('access_token 异常: '. $this->access_token);
            }
            $this->access_token = AccessToken::setNewToken($this->agent);
            return 'try_again';
        } elseif (isset($response['errcode'])) {
            DingLog::recordApiFail($uri, $data, $response);
            throw new DingApiException($response['errmsg'] ,$response['errcode']);
        } else {
            throw new HttpException();
        }
    }
}
