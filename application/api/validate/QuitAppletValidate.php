<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 22:06
 */

namespace app\api\validate;


class QuitAppletValidate extends BaseValidate
{
    protected $rule = [
        'command' => 'require|isNotEmpty|length:4',
        'answer' => 'require|isNotEmpty|array'
    ];

    protected $message = [
        'command' => '请输入口令',
        'answer' => '请把答案填完整'
    ];
}