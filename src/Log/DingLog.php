<?php


namespace Smartymoon\DingTalk\Log;


use Log;

/**
 *  1. 记录 Ding 相关的日志
 *  2. 重要日志通过 hook 通知到钉钉群中
 */
class DingLog
{
    static public function recordApi($uri, $data, $response)
    {
        Log::channel(
            config('logging.channels.ding') ? 'ding' : 'default'
        )->info('钉钉 API 上下文', compact('uri', 'data', 'response'));
    }

    static public function recordApiFail($uri, $data, $response)
    {
        Log::channel(
            config('logging.channels.ding') ? 'ding' : 'default'
        )->warning('钉钉 API 返回错误 ', compact('uri', 'data', 'response'));
    }

    // 发送到群
    static public function sentGroup()
    {

    }

}