<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 19:25
 */

namespace app\api\validate;


class EmailValidate extends BaseValidate
{
    protected $rule = [
        'email' => 'require|isNotEmpty|email'
    ];

    protected $message = [
        'email' => '请输入有效的邮箱地址'
    ];
}