<?php

namespace Smartymoon\DingTalk\Api\H5app;

use Smartymoon\DingTalk\Api\BaseClient;

class Client extends BaseClient
{
    /**
     * 获取 jsapi_ticket
     *
     * @return mixed
     */
    public function get()
    {
        // 和 appkey 相关, ticket 可在两小时内复用，所以要缓存, 重新获取后，返回新的
        return \Cache::remember($this->cacheName(), 7000, function() {
            return $this->getData('get_jsapi_ticket');
        });
    }

    /**
     * 获取 ticket
     *
     * @return string
     */
    public function getTicket()
    {
        \Log::info('ticket is: '. $this->get()['ticket']);
        return $this->get()['ticket'];
    }

    /**
     * 获取签名相关信息
     *
     * @param string $url
     * 
     * @return mixed
     */
    public function getSignature($url)
    {
        $nonceStr = $this->getNonceStr();
        $timeStamp = time();
        $plain = 'jsapi_ticket=' . $this->getTicket() . '&noncestr=' . $nonceStr . '&timestamp=' . $timeStamp . '&url=' . $url;
        $signature = sha1($plain);
        return [
            'agentId' => config("ding.agents." . $this->agent . ".agent_id"),
            'corpId' => config('ding.corp_id'),
            'timeStamp' => $timeStamp,
            'nonceStr' => $nonceStr,
            'signature' => $signature,
            'url' => $url
        ];
    }

    /**
     * 缓存 Key
     *
     * @return string
     */
    private function cacheName()
    {
        return 'jsapi_ticket_' . $this->agent;
    }

    /**
     * 生产 随机字符串
     *
     * @return string
     */
    protected function getNonceStr($length=16)
    {
        $strs = "QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
        return substr(str_shuffle($strs), mt_rand(0, strlen($strs)-11), $length);
    }
}
