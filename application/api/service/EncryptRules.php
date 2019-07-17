<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 23:28
 */

namespace app\api\service;


class EncryptRules extends BaseService
{

    public static function addone($data){
        $data.=1;
        return $data;
    }
    public static function addtwo($data){
        $data.=22;
        return $data;
    }
    public static function addthree($data){
        $data.=333;
        return $data;
    }
    public static function addfour($data){
        $data.=4444;
        return $data;
    }
    public static function addfive($data){
        $data.=55555;
        return $data;
    }
    public static function addsix($data){
        $data.=666666;
        return $data;
    }
}