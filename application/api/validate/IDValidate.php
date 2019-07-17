<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 15:44
 */

namespace app\api\validate;


class IDValidate extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isNotEmpty',
        'page'=>'number'
    ];

    protected $message = [
        'id' => '请选择需要查看的对象'
    ];
}