<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 16:14
 */

namespace app\api\validate;


class EncryptedValidate extends BaseValidate
{
    protected $rule = [
        'answer' => 'require|isNotEmpty|array'
    ];

    protected $message = [
        'answer' => '请把答案填完整'
    ];
}