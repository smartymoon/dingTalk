<?php


namespace Smartymoon\DingTalk\Notification\Message;


use EasyDingTalk\Application;
use Smartymoon\DingTalk\Api\DingApi;

/**
 * 有三个功能
 * 1. 设置发送应用
 * 2. 设置消息格式（单独用一个类设置）
 * 3. 设置接收人
 * Class CorpConversationMessage
 * @package App\DingDing
 */
class CorpConversationMessage
{

    protected $app;
    protected $agent_name = 'report';

    protected $argument = [
        'agent_id' => null,
        'msg' => null
    ];

    /**
     * @return Application
     */
    public function getApp()
    {
        return $this->app;
    }

    public function getArgument()
    {
        return $this->argument;
    }

    public function setAgent($agent_name)
    {
        $this->agent_name = $agent_name;
        $this->app = DingApi::agent($agent_name);
        $this->argument['agent_id'] = config("ding.agents.${agent_name}.agent_id");

        return $this;
    }

    public function toDepart($dept_ids)
    {
        unset($this->argument['userid_list']);
        $this->argument['dept_id_list'] = $dept_ids;
        unset($this->argument['to_all_user']);
        return $this;
    }

    public function toUser($userids)
    {
        $this->argument['userid_list'] = $userids;
        unset($this->argument['dept_id_list']);
        unset($this->argument['to_all_user']);
        return $this;
    }

    public function toAll()
    {
        unset($this->argument['userid_list']);
        unset($this->argument['dept_id_list']);
        $this->argument['to_all_user'] = true;
        return $this;
    }

    public function setMessage($message)
    {
        $this->argument['msg'] = $message;
        return $this;
    }
}