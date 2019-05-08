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
            case '1':$data=self::addone($data);break;
            case '2':$data=self::addtwo($data);break;
            case '3':$data=self::addthree($data);break;
            case '4':$data=self::addfour($data);break;
            case '5':$data=self::addfive($data);break;
            case '6':$data=self::addsix($data);break;
        }
        return $data;
    }
}