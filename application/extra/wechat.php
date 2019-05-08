<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/6
 * Time: 23:31
 */

return [
    'token_salt' => 'memo',
    'token_expire_in' => 7200,
    'email_validate_time' => 300,//5分钟


    'app_id' => 'wxc25a68cc752714f5',
    'app_secret' => '521dcd180059cc7408e37fb85e84b77e',
    'login_url' => 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code',
];