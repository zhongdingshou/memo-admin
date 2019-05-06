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