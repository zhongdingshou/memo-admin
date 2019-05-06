<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/6
 * Time: 23:15
 */

namespace app\api\service;
use think\Request;
use think\Cache;

class Token
{
    //生成token
    public static function generateToken($char_len = 32){
        //32位随机字符串
        $randChars = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //salt 盐
        $salt = config('secure.token_salt');
        return md5($randChars.$timestamp.$salt);
    }

    public static function getCurrentUid(){
        $uid = self::getCurrentTokenVar('id');
        return $uid;
    }

    public static function getSessionKey(){
        return self::getCurrentTokenVar('session_key');
    }

    public static function getOpenId(){
        return self::getCurrentTokenVar('openid');
    }

    public static function getCurrentTokenVar($key=null){
        $token = self::getTokens();
        $vars = Cache::get($token);
        if(!$vars){
            throw new TokenException();
        }
        else{
            if(!is_array($vars)){
                $vars = json_decode($vars,true);
            }
            if(!$key){ //返回全部
                return $vars;
            }
            if(array_key_exists($key,$vars)){
                return $vars[$key];
            }
            else{
                throw new Exception("尝试获取的cache值$key 不存在");
            }
        }
    }

    public static function getTokens(){
        return Request::instance()->header('token');
    }
}