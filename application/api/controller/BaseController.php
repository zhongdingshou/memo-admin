<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/6
 * Time: 23:04
 */

namespace app\api\controller;


use think\Controller;
use think\Cache;
use app\api\service\Token;
use app\api\service\GetUserIp;
class BaseController extends Controller
{
    protected function _initialize()
    {
        parent::_initialize();
        $token = Token::getTokens();//获取客户端token
        if ($token&&Cache::get($token)){//判断客户端有无保存token和缓存中存不存在该账号
            $now_id = $cache_ip =  '';//初始化
            $tip = Token::getCurrentTokenVar('ip');
            $gip = GetUserIp::getIp();
            if ($tip!='unknown')//判断缓存ip合不合法
                $cache_ip =  explode('.',$tip,4);//获取缓存ip
            if ($gip!='unknown')//判断请求ip合不合法
                $now_id =  explode('.',$gip,4);//获取请求ip
            unset($tip);//释放
            unset($gip);//释放
            if ($cache_ip&&$now_id) {//都合法
                for ($b=0;$b<4;$b++){
                    if ($cache_ip[$b]!==$now_id[$b]) {//比较ip，如果缓存ip和请求ip不相等
                        \cache($token,null);
                        return json_encode(['msg'=>'IP不同，请重新登陆']);
                    }
                }
            } else {//有不合法的
                \cache($token,null);
                return json_encode(['msg'=>'非法IP，请重新登陆']);
            }
        }
    }

    public function isLogin(){
        if (!Token::getTokens()) return json_encode(['msg'=>'未登录，无法操作，请登陆']);
    }
}