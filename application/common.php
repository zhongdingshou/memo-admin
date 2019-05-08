<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//获取随机字符串
function getRandChar($n){
    $str = null;
    $strPol = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghiljklmnopqrstuvwxyz1234567890';
    //$max = strlen($strPol)-1;
    for($i=0;$i<$n;$i++){
        $str .= $strPol[rand(0,60)];
    }
    return $str;
}
//发送请求的function
function curl_get($url,&$httpCode = 0){
    $ch =curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

    //不做证书校验，再linux下要换true
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch,CURLOPT_TIMEOUT,10);
    $file_contents = curl_exec($ch);
    $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $file_contents;
}