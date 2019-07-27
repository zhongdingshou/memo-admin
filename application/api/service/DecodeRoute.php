<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 23:33
 */

namespace app\api\service;


class DecodeRoute extends DecodeRules
{
    /**
     * 解密路由
     * @param $name
     * @param $data
     * @return bool|string
     */
    public static function Route($name,$data){
        switch ($name){
            case 'AES解密':
                $data=self::AES_CBC($data);break;
            case 'Base64解密':
                $data=self::Base_64_Decrypt($data);break;
            case 'RSA解密':
                $data=self::RSA_Decrypt($data);break;
            case 'DES解密':
                $data=self::DES_Decrypt($data);break;
            case '3-DES解密':
                $data=self::ThreeDes_Decrypt($data);break;
            case 'RC4解密':
                $data=self::RC4_Decrypt($data);break;
            default: break;
        }
        return $data;
    }
}