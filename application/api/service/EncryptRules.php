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
        $data.=2;
        return $data;
    }
    public static function addthree($data){
        $data.=3;
        return $data;
    }
    public static function addfour($data){
        $data.=4;
        return $data;
    }
    public static function addfive($data){
        $data.=5;
        return $data;
    }
    public static function addsix($data){
        $data.=6;
        return $data;
    }
}