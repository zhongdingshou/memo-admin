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

    public static function AES_CBC($data){
        $method = "AES-128-CBC";
        $password = config('encryptiontodecrypt.aes_cbc_key');
        list($usec, $sec) = explode(" ", microtime());
        $get_iv = "a".(string)((float)$usec + (float)$sec);
        $e_data = openssl_encrypt($data, $method, $password, $options=0, $iv=$get_iv);
        return   $get_iv.$e_data;
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