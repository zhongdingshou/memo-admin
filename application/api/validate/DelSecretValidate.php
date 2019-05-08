<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/8
 * Time: 0:11
 */

namespace app\api\validate;


class DelSecretValidate extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isNotEmpty'
    ];

    protected $message = [
        'id' => '请选择需要s删除的对象'
    ];
}