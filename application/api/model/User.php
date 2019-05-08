<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/6
 * Time: 23:08
 */

namespace app\api\model;


class User extends BaseModel
{
    public static function getByOpenId($openid){
        $user = self::where('open_id','=',$openid)->find();
        return $user;
    }

    public static function getById($id){
        return self::where("id",$id)->find();
    }
}