<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/8
 * Time: 0:28
 */

namespace app\api\service;


class ShellingOrDecan extends BaseService
{

    /**
     * 返回客户端时加密
     * @param $data
     * @return mixed
     */
    public static function Shelling($data,$get_iv){
        $method = "AES-128-CBC";
        $password = "0123456789ABCDEF";
        $res = openssl_encrypt($data, $method, $password, $options=0, $iv=$get_iv);
        return  base64_encode($get_iv.$res);
    }

    /**
     * 服务端获取时解密
     * @param $data
     * @return mixed
     */
    public static function Decan($data){
        $base64_decryption = base64_decode($data);
        $true_data = substr($base64_decryption, 16);
        $method = "AES-128-CBC";
        $password = "0123456789ABCDEF";
        $get_iv = substr($base64_decryption, 0, 16);
        return openssl_decrypt($true_data, $method,$password, $options=0, $iv=$get_iv);
    }
}