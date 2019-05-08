<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 22:33
 */

namespace app\api\validate;


class AddSecretValidate extends BaseValidate
{
    protected $rule = [
        'describe' => 'require|isNotEmpty',
        'account' => 'require|isNotEmpty',
        'password' => 'require|isNotEmpty'
    ];

    protected $message = [
        'describe' => '请输入描述',
        'account' => '请输入账号',
        'password' => '请输入密码'
    ];
}