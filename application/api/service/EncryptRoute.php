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
            case 'CBC模式AES加密':
                $data=self::addone($data);break;
            case '加密2':
                $data=self::addtwo($data);break;
            case '加密3加密3加密3':
                $data=self::addthree($data);break;
            case '加密4':
                $data=self::addfour($data);break;
            case '加密5':
                $data=self::addfive($data);break;
            case '加密6':
                $data=self::addsix($data);break;
            default: break;
        }
        return $data;
    }
}