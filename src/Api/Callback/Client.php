<?php

/*
 * This file is part of the mingyoung/dingtalk.
 *
 * (c) 张铭阳 <mingyoungcheung@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Smartymoon\DingTalk\Api\Callback;

use Smartymoon\DingTalk\Api\BaseClient;

class Client extends BaseClient
{
    /**
     * 注册业务事件回调接口
     *
     * @param array $params
     *
     * @return mixed
     */
    public function register()
    {
        $params['token'] = config('ding.token');
        $params['aes_key'] = config('ding.aes_key');
        $params['url'] = config('app.url').'dingding/event/callback';
        $params['call_back_tag'] = array_keys(config('ding.events'));

        return $this->post('call_back/register_call_back', $params);
    }

    /**
     * 查询事件回调接口
     *
     * @return mixed
     */
    public function list()
    {
        return $this->getData('call_back/get_call_back');
    }

    /**
     * 更新事件回调接口
     *
     * @return mixed
     */
    public function update()
    {
        $params['token'] = config('ding.token');
        $params['aes_key'] = config('ding.aes_key');
        $params['url'] = config('app.url').'dingding/event/callback';
        $params['call_back_tag'] = array_keys(config('ding.events'));

        return $this->post('call_back/update_call_back', $params);
    }

    /**
     * 删除事件回调接口
     *
     * @return mixed
     */
    public function delete()
    {
        return $this->getData('call_back/delete_call_back');
    }

    /**
     * 获取回调失败结果
     *
     * @return mixed
     */
    public function failed()
    {
        return $this->getData('call_back/get_call_back_failed_result');
    }
}
