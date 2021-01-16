<?php


namespace Smartymoon\DingTalk\Notification;
use Log;


use Illuminate\Notifications\Notification;

class DingDingChannel
{
    // $notifiable 是要通知的人 $user->notify() 中的 $user
    public function send($notifiable,  Notification $notification)
    {
        $message = $notification->toDingDing($notifiable);
        if (!$notifiable->dingding_user_id) {
            Log::channel('no_ding_userid')->info($notifiable->name . $notifiable->phone. '没有 userid');
            return;
        }
        $message->toUser($notifiable->dingding_user_id);

        if (app()->environment('production')) {
            $message->getApp()->conversation->sendCorporationMessage($message->getArgument());
        } else {
            dump('钉钉通知');
            dump($message->getArgument());
        }
    }
}