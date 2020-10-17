<?php


namespace Smartymoon\DingTalk\Contracts;


interface EventContract
{
    /**
     * 收到钉钉通知后，触发这个方法,
     * 钉钉通知的数据形如：
     * {
     *  "EventType": "user_add_org", 这个是关键
     *  "TimeStamp": 43535463645,
     *  "UserId": ["efefef" , "111111"],
     *  "CorpId": "corpid"
     *  }
     * @param $payload 解密后的钉钉返回的数据
     * @return mixed
     */
    public function handle($payload);
}