<?php

/*
 * This file is part of the mingyoung/dingtalk.
 *
 * (c) 张铭阳 <mingyoungcheung@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Smartymoon\DingTalk\Api\Contact;

use Smartymoon\DingTalk\Api\BaseClient;

class Client extends BaseClient
{
    /**
     * 获取外部联系人标签列表
     *
     * @param int $offset
     * @param int $size
     *
     * @return mixed
     */
    public function labels($offset = 0, $size = 100)
    {
        return $this->post('topapi/extcontact/listlabelgroups', compact('offset', 'size'));
    }

    /**
     * 获取外部联系人列表
     *
     * @param int $offset
     * @param int $size
     *
     * @return mixed
     */
    public function list($offset = 0, $size = 100)
    {
        return $this->post('topapi/extcontact/list', compact('offset', 'size'));
    }

    /**
     * 获取企业外部联系人详情
     *
     * @param string $userId
     *
     * @return mixed
     */
    public function get($userId)
    {
        return $this->post('topapi/extcontact/get', ['user_id' => $userId]);
    }

    /**
     * 添加外部联系人
     *
     * @param array $contact
     *
     * @return mixed
     */
    public function create($contact)
    {
        return $this->post('topapi/extcontact/create', compact('contact'));
    }

    /**
     * 更新外部联系人
     *
     * @param string $userId
     * @param array  $contact
     *
     * @return mixed
     */
    public function update($userId, $contact)
    {
        $contact = ['user_id' => $userId] + $contact;

        return $this->post('topapi/extcontact/update', compact('contact'));
    }

    /**
     * 删除外部联系人
     *
     * @param string $userId
     *
     * @return mixed
     */
    public function delete($userId)
    {
        return $this->post('topapi/extcontact/delete', ['user_id' => $userId]);
    }

    /**
     * 获取通讯录权限范围
     *
     * @return mixed
     */
    public function scopes()
    {
        return $this->getData('auth/scopes');
    }
}
