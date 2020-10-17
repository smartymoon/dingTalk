<?php


namespace Smartymoon\DingTalk\Robot;


class At
{
    public static function all()
    {
        return [
            'at' => [
                'isAtAll' => true
            ]
        ];
    }

    public static function phones($phones)
    {
        return [
            'at' => [
                'atMobiles' => $phones
            ]
        ];
    }
}