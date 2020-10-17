<?php
/**
 *  钉钉配置文件, 支持多应用
 */

return [

    /*
    |-----------------------------------------------------------
    | 公司 ID
    |-----------------------------------------------------------
    */
    'corp_id' => env('DING_CORP_ID'),

    /*
    |-----------------------------------------------------------
    | 是否开启 debug，开启后会记录 api 请求和返回数据
    |-----------------------------------------------------------
    */
    'debug' => env('DING_DEBUG', false),

    /*
    |-----------------------------------------------------------
    | 默认钉钉应用, 取下方 agents 里的值
    |-----------------------------------------------------------
    */
    'default' => env('DING_DEFAULT_AGENT', 'beauty'),


    /*
    |-----------------------------------------------------------
    | 多钉钉应用的配置
    |-----------------------------------------------------------
    */
    'agents' => [
        'beauty' => [
            'agent_id' => env('DING_DEFAULT_AGENT_ID', ''),
            'app_key' => env('DING_DEFAULT_AGENT_KEY', ''),
            'app_secret' => env('DING_DEFAULT_AGENT_SECRET', '')
        ],
    ],

    /*
    |-----------------------------------------------------------
    | 机器人
    |-----------------------------------------------------------
    */
    'robots' => [
        'robot_name' => [
           'token' => '',
            'secret' => ''
        ]
    ],

    /*
    |-----------------------------------------------------------
    | 事件回调
    |-----------------------------------------------------------
    | 此处的 `token` 和 `aes_key` 用于事件通知的加解密
    | 如果你用到事件回调功能，需要配置该两项
    */
    'token' => 'uhl3CZbtsmf93bFPanmMenhWwoqbSwPc',
    'aes_key' => 'qZEOmHU2qYYk6n6vqLfi3FAhcp9mGA2kgbfnsXDrGgN',

    'events' => [
        // 'user_add_org' => '',
        // 'user_modify_org' =>'',
        // 'user_leave_org' =>'',
        // 'org_admin_add' =>'',
        // 'org_admin_remove' =>'',
        // 'org_dept_create' =>'',
        // 'org_dept_modify' =>'',
        // 'org_dept_remove' =>'',
        // 'org_remove' =>'',
        // 'label_user_change' =>'',
        // 'label_conf_add' =>'',
        // 'label_conf_modify' =>'',
        // 'label_conf_del' =>'',
        // 'org_change' =>'',
        // 'chat_add_member' =>'',
        // 'chat_remove_member' =>'',
        // 'chat_quit' =>'',
        // 'chat_update_owner' => '',
        // 'chat_update_title' => '',
        // 'chat_disband' => '',
        // 'chat_disband_microap' => '',
        // 'check_in' => '',
        // 'bpms_task_change' => '',
        // 'bpms_instance_change' => ''
    ],
];