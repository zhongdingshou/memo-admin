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

class Token extends BaseService
{
    //生成token
    public static function generateToken($char_len = 32){
        //32位随机字符串
        $randChars = getRandChar($char_len);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //salt 盐
        $salt = config('wechat.token_salt');
        return md5($randChars.$timestamp.$salt);
    }

    public static function getCurrentUid(){
        return self::getCurrentTokenVar('id');
    }

    public static function getSessionKey(){
        return self::getCurrentTokenVar('session_key');
    }

    public static function getOpenId(){
        return self::getCurrentTokenVar('open_id');
    }

    public static function getCurrentTokenVar($key=null){
        $token = self::getTokens();
        $vars = Cache::get($token);
        if(!$vars){
            return json_encode(['msg'=>'token无效']);
        } else{
            if(!is_array($vars)){
                $vars = json_decode($vars,true);
            }
            if(!$key){ //返回全部
                return $vars;
            }
            if(array_key_exists($key,$vars)){
                return $vars[$key];
            } else{
                return json_encode(['msg'=>'尝试获取的cache值'.$key.'不存在']);
            }
        }
    }

    public static function getTokens(){
        return Request::instance()->header('token');
    }
}