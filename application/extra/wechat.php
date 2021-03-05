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


    'app_id' => 'xxx', // 微信小程序 app_id
    'app_secret' => 'xxx', // // 微信小程序 app_secret
    'login_url' => 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code',
];
