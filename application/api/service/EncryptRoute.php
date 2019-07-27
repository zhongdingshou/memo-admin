<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 23:29
 */

namespace app\api\service;


class EncryptRoute extends EncryptRules
{

    /**
     * 加密路由
     * @param $name
     * @param $data
     * @return string
     */
    public static function Route($name,$data){
        switch ($name){
            case 'AES加密':
                $data=self::AES_CBC($data);break;
            case 'Base64加密':
                $data=self::Base_64_Encode($data);break;
            case 'RSA加密':
                $data=self::RSA_Encode($data);break;
            case 'DES加密':
                $data=self::DES_Encode($data);break;
            case '3-DES加密':
                $data=self::ThreeDes_Encode($data);break;
            case 'RC4加密':
                $data=self::RC4_Encode($data);break;
            default: break;
        }
        return $data;
    }
}