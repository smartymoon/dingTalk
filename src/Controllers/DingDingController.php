<?php
namespace Smartymoon\DingTalk\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Smartymoon\DingTalk\Api\DingApi;
use Smartymoon\DingTalk\Helpers\Encryptor;

class DingDingController extends \App\Http\Controllers\Controller
{
    private $encryptor;

    public function __construct()
    {
       $this->encryptor = new Encryptor(config('ding.corp_id'), config('ding.token'), config('ding.aes_key'));
    }

    // 一组 api 鉴权参数，用于帮前端调用高级的 api
    public function jsapiSignature(Request $request)
    {
        $params = DingApi::agent()
            ->h5app->getSignature($request->input('url'));
        return $params;
    }

    /**
     * 注册事件发生，钉钉向我们的服务器发送通知，给它个面子，返回个 success
     * @param Request $request
     * @return string
     */
    public function serve(Request $request)
    {
        /**
         * 业务定义在配置文件中
         * 处理回调事件，这里是具体业务
         */
        $payload = $this->getPayload($request);
        \Log::channel('ding')->info('有钉钉回调事件来了', $payload);
        $eventType = $payload['EventType'];
        if (isset(config('ding.events')[$eventType])) {
            $events = config('ding.events');
            $app = new $events[$eventType];
            $app->handle($payload);
        }


        /*
        $this->app['logger']->debug('Request received: ', [
            'method' => $this->app['request']->getMethod(),
            'uri' => $this->app['request']->getUri(),
            'content' => $this->app['request']->getContent(),
        ]);
        */

        return $this->encryptor->encrypt('success');

    }

    /**
     * Get request payload.
     *
     * @return array
     */
    private function getPayload(Request $request)
    {
        $result = $this->encryptor->decrypt(
            $request->input('encrypt'),
            $request->input('signature'),
            $request->input('nonce'),
            $request->input('timestamp')
        );

        return json_decode($result, true);
    }
}
