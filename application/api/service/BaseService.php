<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 18:19
 */

namespace app\api\service;


class BaseService
{
//发送请求的function
    /**
     * @param $url
     * @param null $curlPost
     * @param null $asyn
     * @return bool|string
     */
    public static function curl($url,$curlPost=null,$asyn = null){
        $ch =curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        if($curlPost){
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$curlPost);
        }
        if($asyn){//是否异步
            curl_setopt($ch,CURLOPT_TIMEOUT,1);
        }
        else{
            curl_setopt($ch,CURLOPT_TIMEOUT,30);
        }
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}