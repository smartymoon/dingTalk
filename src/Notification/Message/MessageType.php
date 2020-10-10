<?php


namespace Smartymoon\DingTalk\Notification\Message;


/**
 * 钉钉消息格式，https://ding-doc.dingtalk.com/doc#/serverapi2/ye8tup
 * Class Message
 * @package App\DingDing
 */
class MessageType
{
    static public array $types = [
        'text',
        'image',
        'voice',
        'file',
        'link',
        'oa',
        'markdown',
        'action_card'
    ];

    public static function singleActionCard($out_title, $inside_title, $content, $url, $url_title = '查看详情')
    {
        return [
            'msgtype' => "action_card",
            'action_card' => [
                "title" => $out_title,
                "markdown" => ($inside_title ? ('### '. $inside_title . "  \n  ") : '') . $content,
                "single_title" => $url_title,
                'single_url' => $url
            ]
        ];
    }

    /**
     * @param $out_title
     * @param $inside_title
     * @param $content
     * @param $urls ['title', 'action_url]
     * @return array
     */
    public static function inlineMultipleActionCard($out_title, $inside_title, $content, $urls)
    {
        return self::multipleActionCard($out_title,$inside_title, $content, $urls, "1");
    }

    /**
     * @param $out_title
     * @param $inside_title
     * @param $content
     * @param $urls ['title', 'action_url]
     * @return array
     */
    public static function verticalMultipleActionCard($out_title, $inside_title, $content, $urls)
    {
        return self::multipleActionCard($out_title, $inside_title, $content, $urls, "0");
    }


    /**
     * @param $out_title
     * @param $inside_title
     * @param $content
     * @param $urls ['title', 'action_url]
     * @param string $orientation 方向 1 为横向， 0 为纵向
     * @return array
     */
    private static function multipleActionCard($out_title, $inside_title, $content, $urls, string $orientation)
    {
        return [
            'msgtype' => "action_card",
            'action_card' => [
                "title" => $out_title,
                "markdown" => ($inside_title ? ('### '.$inside_title. "  \n  " ) : ''). $content,
                "btn_orientation" => $orientation,
                "btn_json_list" => $urls
            ]
        ];
    }

    public static function markdown(string $title, string $content)
    {
        return [
            'msgtype' => "markdown",
            'markdown' => [
                "title" => $title,
                "text" => $content,
            ]
        ];
    }
}