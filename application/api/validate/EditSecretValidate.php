<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 23:56
 */

namespace app\api\validate;


class EditSecretValidate extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isNotEmpty',
        'describe' => 'require|isNotEmpty',
        'account' => 'require|isNotEmpty',
        'password' => 'require|isNotEmpty'
    ];

    protected $message = [
        'id' => '请选择需要修改的对象',
        'describe' => '请输入描述',
        'account' => '请输入账号',
        'password' => '请输入密码'
    ];
}