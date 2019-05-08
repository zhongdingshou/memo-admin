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
     * 返回客户端时密码加壳
     * @param $data
     * @return mixed
     */
    public static function Shelling($data){
        return $data;
    }

    /**
     * 服务端获取密码时去壳
     * @param $data
     * @return mixed
     */
    public static function Decan($data){
        return $data;
    }
}