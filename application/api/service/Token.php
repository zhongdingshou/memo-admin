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
    /**
     * 生成token
     * @param int $char_len
     * @return string
     */
    public static function generateToken($char_len = 32){
        //32位随机字符串
        $randChars = getRandChar($char_len);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //salt 盐
        $salt = config('wechat.token_salt');
        return md5($randChars.$timestamp.$salt);
    }

    /**
     * 获取id
     * @return false|mixed|string
     */
    public static function getCurrentUid(){
        return self::getCurrentTokenVar('id');
    }

    /**
     * 获取session_key
     * @return false|mixed|string
     */
    public static function getSessionKey(){
        return self::getCurrentTokenVar('session_key');
    }

    /**
     * 获取open_id
     * @return false|mixed|string
     */
    public static function getOpenId(){
        return self::getCurrentTokenVar('open_id');
    }

    /**
     * 获取所有或者某个
     * @param null $key
     * @return false|mixed|string
     */
    public static function getCurrentTokenVar($key=null){
        $token = self::getTokens();
        $vars = Cache::get($token);
        if(!$vars){
            return json_encode(['status'=>0,'msg'=>'token无效']);
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
                return json_encode(['status'=>0,'msg'=>'尝试获取的cache值'.$key.'不存在']);
            }
        }
    }

    /**
     * 获取请求token
     * @return string
     */
    public static function getTokens(){
        return Request::instance()->header('token');
    }
}