<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 19:03
 */

namespace app\api\validate;


class AddEncryptedValidate extends BaseValidate
{
    protected $rule = [
        'encrypted' => 'require|isNotEmpty|array'
    ];

    protected $message = [
        'encrypted' => '请输入需要设置的密保'
    ];
}