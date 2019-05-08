<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 18:18
 */

namespace app\api\service;
use think\Request;

class GetUserIp extends BaseService
{
    /**
     * @return mixed
     */
    public static function getIP(){
        $realIp = '';
        $unknown = 'unknown';
        if (isset($_SERVER)){
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)){
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach($arr as $ip){
                    $ip = trim($ip);
                    if ($ip != 'unknown'){
                        $realIp = $ip;
                        break;
                    }
                }
            }else if(isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']) && strcasecmp($_SERVER['HTTP_CLIENT_IP'], $unknown)){
                $realIp = $_SERVER['HTTP_CLIENT_IP'];
            }else if(isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)){
                $realIp = $_SERVER['REMOTE_ADDR'];
            }else{
                $realIp = $unknown;
            }
        }else{
            if(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), $unknown)){
                $realIp = getenv("HTTP_X_FORWARDED_FOR");
            }else if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), $unknown)){
                $realIp = getenv("HTTP_CLIENT_IP");
            }else if(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), $unknown)){
                $realIp = getenv("REMOTE_ADDR");
            }else{
                $realIp = $unknown;
            }
        }
        $realIp = preg_match("/[\d\.]{7,15}/", $realIp, $matches) ? $matches[0] : $unknown;
        return $realIp;
    }
}