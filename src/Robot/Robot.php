<?php
namespace Smartymoon\DingTalk\Robot;

use Illuminate\Support\Facades\Http;

class Robot
{
    protected string $token;
    protected $secret;

    public function __construct($token, $secret)
    {
        $this->token = $token;
        $this->secret = $secret;
    }

    /**
     * 选择一个机器人的名字，从配置文件中来
     */
    public static function use(string $name)
    {
        // 从这里得到 token 和 secret
        $token = config('ding.robots.'.$name.'.token');
        $secret = config('ding.robots.'.$name.'.secret', null);
        return new self($token, $secret);
    }

    /**
     * 发起 http
     * @param $message
     */
    private function sent($message)
    {
        // dump($message);
        $url = 'https://oapi.dingtalk.com/robot/send?access_token='.$this->token;

        if ($this->secret) {
            $timestamp = time().'000';
            $url .= sprintf(
                '&sign=%s&timestamp=%s',
                urlencode(base64_encode(hash_hmac('sha256', $timestamp."\n".$this->secret, $this->secret, true))), $timestamp
            );
        }

        $resopnse = Http::post($url, $message);
        // dump($resopnse->json());
        return $resopnse;
    }

    public function text($content, array $at = null)
    {
        $message = [
            'msgtype' => 'text',
            'text' => [
                'content' => $content
            ]
        ];

        if ($at) {
            $message = $message + $at;
        }

        $this->sent($message);
    }


    public function markdown($title, $content, $at = null)
    {
        $message = [
            'msgtype' => 'markdown',
            'markdown' => [
                'title' => $title,
                'text'  => $content
            ]
        ];
        if ($at) {
            $message = $message + $at;
        }
        $this->sent($message);
    }

    public function actionCard($title, $text, $button_title, $button_url)
    {
        $message = [
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $title,
                'text' => $text,
                'singleTitle' => $button_title,
                'singleUrl'   => $button_url
            ]
        ];
        $this->sent($message);
    }


    /**
     * @param $title
     * @param $text
     * @param $urls ['title' => '', 'actionURL' => '']
     * @param bool $button_inline
     */
    public function multipleActionCard($title, $text, $urls, $button_inline = true)
    {
        $message = [
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $title,
                'text' => $text,
                'btns' => $urls,
                'btnOrientation' => $button_inline ? "1" : "0"
            ]
        ];
        $this->sent($message);
    }

    /**
     * @todo
     */
    public function FeedCard()
    {

    }

    /**
     * @todo
     */
    public function link()
    {

    }
}
