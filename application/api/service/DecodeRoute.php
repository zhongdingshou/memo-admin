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
            case 'CBC模式AES解密':
                $data=self::addone($data);break;
            case '解密2':
                $data=self::addtwo($data);break;
            case '解密3':
                $data=self::addthree($data);break;
            case '解密4':
                $data=self::addfour($data);break;
            case '解密5':
                $data=self::addfive($data);break;
            case '解密6':
                $data=self::addsix($data);break;
            default: break;
        }
        return $data;
    }
}