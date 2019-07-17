<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 15:52
 */

namespace app\api\validate;


class CommandValidate extends BaseValidate
{
    protected $rule = [
        'command' => 'require|isNotEmpty'
    ];

    protected $message = [
        'command' => '请输入口令'
    ];
}