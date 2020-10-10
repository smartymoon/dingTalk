<?php

/*
 * This file is part of the mingyoung/dingtalk.
 *
 * (c) 张铭阳 <mingyoungcheung@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Smartymoon\DingTalk\Api\User;

use Smartymoon\DingTalk\Api\BaseClient;

class Client extends BaseClient
{
    /**
     * 获取用户详情
     *
     * @param string $userid
     * @param string|null $lang
     *
     * @return mixed
     */
    public function get($userid, $lang = null)
    {
        return $this->getData('user/get', compact('userid', 'lang'));
    }

    /**
     * 获取部门用户 Userid 列表
     *
     * @param int $departmentId
     *
     * @return mixed
     */
    public function getUserIds($departmentId)
    {
        return $this->getData('user/getDeptMember', ['deptId' => $departmentId]);
    }

    /**
     * 获取部门用户
     *
     * @param int $departmentId
     * @param int $offset
     * @param int $size
     * @param string $order
     * @param string $lang
     *
     * @return mixed
     */
    public function getUsers($departmentId, $offset, $size, $order = null, $lang = null)
    {
        return $this->getData('user/simplelist', [
            'department_id' => $departmentId, 'offset' => $offset, 'size' => $size, 'order' => $order, 'lang' => $lang,
        ]);
    }

    /**
     * 获取部门用户详情
     *
     * @param int $departmentId
     * @param int $offset
     * @param int $size
     * @param string $order
     * @param string $lang
     *
     * @return mixed
     */
    public function getDetailedUsers($departmentId, $offset, $size, $order = null, $lang = null)
    {
        return $this->getData('user/listbypage', [
            'department_id' => $departmentId, 'offset' => $offset, 'size' => $size, 'order' => $order, 'lang' => $lang,
        ]);
    }

    /**
     * 获取管理员列表
     *
     * @return mixed
     */
    public function administrators()
    {
        return $this->getData('user/get_admin');
    }

    /**
     * 获取管理员通讯录权限范围
     *
     * @param string $userid
     *
     * @return mixed
     */
    public function administratorScope($userid)
    {
        return $this->getData('topapi/user/get_admin_scope', compact('userid'));
    }

    /**
     * 根据 Unionid 获取 Userid
     *
     * @param string $unionid
     *
     * @return mixed
     */
    public function getUseridByUnionid($unionid)
    {
        return $this->getData('user/getUseridByUnionid', compact('unionid'));
    }

    /**
     * 创建用户
     *
     * @param array $params
     *
     * @return mixed
     */
    public function create(array $params)
    {
        return $this->post('user/create', $params);
    }

    /**
     * 更新用户
     *
     * @param string $userid
     * @param array $params
     *
     * @return mixed
     */
    public function update($userid, array $params)
    {
        return $this->post('user/update', compact('userid') + $params);
    }

    /**
     * 删除用户
     *
     * @param $userid
     *
     * @return mixed
     */
    public function delete($userid)
    {
        return $this->getData('user/delete', compact('userid'));
    }

    /**
     * 企业内部应用免登获取用户 Userid
     *
     * @param string $code
     *
     * @return mixed
     */
    public function getUserByCode($code)
    {
        return $this->getData('user/getuserinfo', compact('code'));
    }

    /**
     * 批量增加员工角色
     *
     * @param array|string $userIds
     * @param array|string $roleIds
     *
     * @return mixed
     */
    public function addRoles($userIds, $roleIds)
    {
        $userIds = is_array($userIds) ? implode(',', $userIds) : $userIds;
        $roleIds = is_array($roleIds) ? implode(',', $roleIds) : $roleIds;

        return $this->post('topapi/role/addrolesforemps', compact('userIds', 'roleIds'));
    }

    /**
     * 批量删除员工角色
     *
     * @param array|string $userIds
     * @param array|string $roleIds
     *
     * @return mixed
     */
    public function removeRoles($userIds, $roleIds)
    {
        $userIds = is_array($userIds) ? implode(',', $userIds) : $userIds;
        $roleIds = is_array($roleIds) ? implode(',', $roleIds) : $roleIds;

        return $this->post('topapi/role/removerolesforemps', compact('userIds', 'roleIds'));
    }

    /**
     * 获取企业员工人数
     *
     * @param int $onlyActive
     *
     * @return mixed
     */
    public function getCount($onlyActive = 0)
    {
        return $this->getData('user/get_org_user_count', compact('onlyActive'));
    }

    /**
     * 获取企业已激活的员工人数
     *
     * @return mixed
     */
    public function getActivatedCount()
    {
        return $this->getCount(1);
    }

    /**
     * 根据员工手机号获取 Userid
     *
     * @param string $mobile
     *
     * @return mixed
     */
    public function getUserIdByPhone($mobile = '')
    {
        return $this->getData('user/get_by_mobile', compact('mobile'));
    }

    /**
     * 未登录钉钉的员工列表
     *
     * @param string $query_date
     * @param int $offset
     * @param int $size
     *
     * @return mixed
     */
    public function getInactiveUsers($query_date, $offset, $size)
    {
        return $this->post('topapi/inactive/user/get', [
            'query_date' => $query_date, 'offset' => $offset, 'size' => $size
        ]);
    }
}
