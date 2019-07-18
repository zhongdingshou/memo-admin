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
    public static function AES_CBC($data){
        $method = "AES-128-CBC";
        $password = config('encryptiontodecrypt.aes_cbc_key');
        $e_data = substr($data, 16);
        $get_iv = substr($data, 0, 16);
        return openssl_decrypt($e_data, $method,$password, $options=0, $iv=$get_iv);
    }
    public static function addtwo($data){
        $data=substr($data,0,strlen($data)-2);
        return $data;
    }
    public static function addthree($data){
        $data=substr($data,0,strlen($data)-3);
        return $data;
    }
    public static function addfour($data){
        $data=substr($data,0,strlen($data)-4);
        return $data;
    }
    public static function addfive($data){
        $data=substr($data,0,strlen($data)-5);
        return $data;
    }
    public static function addsix($data){
        $data=substr($data,0,strlen($data)-6);
        return $data;
    }
}