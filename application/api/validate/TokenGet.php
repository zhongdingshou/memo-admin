<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 11:55
 */

namespace app\api\validate;


class TokenGet extends BaseValidate //继承
{
    protected $rule = [
        'code' => 'require|isNotEmpty'
    ];

    protected $message = [
        'code' => '请传入code'
    ];

}
?>