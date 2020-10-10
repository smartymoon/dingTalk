<?php


namespace Smartymoon\DingTalk\Api;

/**
 * @package Smartymoon\DingTalk\Api
 * @property \Smartymoon\DingTalk\Api\Auth\SsoClient $sso
 * @property \Smartymoon\DingTalk\Api\Auth\OAuthClient $oauth
 * @property \Smartymoon\DingTalk\Api\Chat\Client $chat
 * @property \Smartymoon\DingTalk\Api\Role\Client $role
 * @property \Smartymoon\DingTalk\Api\User\Client $user
 * @property \Smartymoon\DingTalk\Api\Media\Client $media
 * @property \Smartymoon\DingTalk\Api\H5app\Client $h5app
 * @property \Smartymoon\DingTalk\Api\Health\Client $health
 * @property \Smartymoon\DingTalk\Api\Report\Client $report
 * @property \Smartymoon\DingTalk\Api\Checkin\Client $checkin
 * @property \Smartymoon\DingTalk\Api\Contact\Client $contact
 * @property \Smartymoon\DingTalk\Api\Process\Client $process
 * @property \Smartymoon\DingTalk\Api\Calendar\Client $calendar
 * @property \Smartymoon\DingTalk\Api\Callback\Client $callback
 * @property \Smartymoon\DingTalk\Api\Microapp\Client $microapp
 * @property \Smartymoon\DingTalk\Api\Schedule\Client $schedule
 * @property \Smartymoon\DingTalk\Api\Blackboard\Client $blackboard
 * @property \Smartymoon\DingTalk\Api\Attendance\Client $attendance
 * @property \Smartymoon\DingTalk\Api\Department\Client $department
 * @property \Smartymoon\DingTalk\Api\Conversation\Client $conversation
 * @property \Smartymoon\DingTalk\Api\Kernel\Http\Client $client
 * @property \Smartymoon\DingTalk\Api\Kernel\Server $server
 * @property \Smartymoon\DingTalk\Api\Kernel\Encryption\Encryptor $encryptor
 * @property \Smartymoon\DingTalk\Api\Kernel\AccessToken $access_token
 */
class DingApi
{
    private string $agent;

    private static array $instances = [];

    private array $modules = [
        'attendance' => Attendance\Client::class,
        'sso' => Auth\SsoClient::class,
        'oauth' => Auth\OAuthClient::class,
        'blackboard' => Blackboard\Client::class,
        'calendar' => Calendar\Client::class,
        'callback' => Callback\Client::class,
        'chat' => Chat\Client::class,
        'checkin' => Checkin\Client::class,
        'contact' => Contact\Client::class,
        'conversation' => Conversation\Client::class,
        'department' => Department\Client::class,
        'h5app' => H5app\Client::class,
        'health' => Health\Client::class,
        'media' => Media\Client::class,
        'microapp' => Microapp\Client::class,
        'process' => Process\Client::class,
        'report' => Report\Client::class,
        'role' => Role\Client::class,
        'schedule' => Schedule\Client::class,
        'user' => User\Client::class
    ];

    public function __construct($agent = null)
    {
        $this->agent = $agent ? $agent : config('ding.default');
    }

    /**
     * @param string $agent_name, ding.php 中配置的应用名
     * @return DingApi
     */
    public static function agent(string $agent_name)
    {
        if (in_array($agent_name, self::$instances)) {
            return self::$instances[$agent_name];
        } else {
            array_push(self::$instances, [
                $agent_name => new self($agent_name)
            ]);
            return new self($agent_name);
        }
    }

    /**
     * 每个模块是一个文件
     * @param string $name 模块名
     * @return mixed
     */
    public function __get(string $name)
    {
        return new $this->modules[$name]($this->agent);
    }
}