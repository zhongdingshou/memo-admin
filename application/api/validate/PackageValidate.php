<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 18:11
 */

namespace app\api\validate;


class PackageValidate extends BaseValidate
{
    protected $rule = [
        'package' => 'require|isNotEmpty'
    ];

    protected $message = [
        'package' => '请选择加密套餐'
    ];
}