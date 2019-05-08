<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 23:32
 */

namespace app\api\service;


class DecodeRules extends BaseService
{
    public static function addone($data){
        $data=substr($data,0,strlen($data)-1);
        return $data;
    }
    public static function addtwo($data){
        $data=substr($data,0,strlen($data)-1);
        return $data;
    }
    public static function addthree($data){
        $data=substr($data,0,strlen($data)-1);
        return $data;
    }
    public static function addfour($data){
        $data=substr($data,0,strlen($data)-1);
        return $data;
    }
    public static function addfive($data){
        $data=substr($data,0,strlen($data)-1);
        return $data;
    }
    public static function addsix($data){
        $data=substr($data,0,strlen($data)-1);
        return $data;
    }
}