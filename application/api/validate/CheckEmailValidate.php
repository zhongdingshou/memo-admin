<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 21:52
 */

namespace app\api\validate;


class CheckEmailValidate extends BaseValidate
{
    protected $rule = [
        'verify' => 'require|isNotEmpty|number'
    ];

    protected $message = [
        'verify' => '请输入验证码'
    ];
}