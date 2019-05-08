<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/8
 * Time: 21:31
 */

namespace app\api\validate;


class SearchSecretValidate extends BaseValidate
{
    protected $rule = [
        'keywords' => 'require|isNotEmpty'
    ];

    protected $message = [
        'keywords' => '请输入搜索关键词'
    ];
}