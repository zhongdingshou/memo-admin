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
        'answer' => 'require|isNotEmpty|array',
        'problem' => 'require|isNotEmpty|array',
    ];

    protected $message = [
        'answer' => '请输入需要设置的答案',
        'problem' => '请输入需要设置的密保'
    ];
}