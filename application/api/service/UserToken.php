<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/6
 * Time: 23:15
 */

namespace app\api\service;
use app\api\model\User;
class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    /**
     * UserToken constructor.
     * @param $code
     */
    public function __construct($code){
        $this->code = $code;
        $this->wxAppID = config('wechat.app_id');
        $this->wxAppSecret = config('wechat.app_secret');
        $this->wxLoginUrl = sprintf(config('wechat.login_url'),$this->wxAppID,$this->wxAppSecret,$this->code);
    }

    /**
     * @return array|false|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function get(){
        $result = curl_get($this->wxLoginUrl);// common.php 全局function
        $wxResult = json_decode($result,true);
        if(empty($wxResult)){
            return json_encode(['status'=>0,'msg'=>'login时请求wx没有返回结果']);
        } else{
            if(array_key_exists("errcode",$wxResult)){
                $errcode = $wxResult['errcode'];
                $errmsg = $wxResult['errmsg'];
                return json_encode([
                    "status"=>0,
                    'msg' => $errmsg,
                    'errcode' => $errcode
                ]);
            } else{
                return  $this->grantToken($wxResult);
            }
        }
    }

    /**
     * 更新token对应的内容
     * @param $news
     * @return false|string
     */
    public static function update($news){
        $token = Token::getTokens();
        $token_datas = $news;
        $token_datas['ip'] = GetUserIp::getIP();
        $value = json_encode($token_datas);
        $expire_in = config('setting.token_expire_in');
        $request = cache($token,$value,$expire_in);//tp5 内置缓存
        if(!$request){
            return json_encode(["status"=>0,'msg'=>'服务器缓存异常']);
        }
        return json_encode(["status"=>1,'msg'=>'缓存设置成功']);
    }


    /**
     * 颁发自定义令牌
     * @param $wxResult
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function grantToken($wxResult){
        // 拿到openid
        $data['open_id'] = $wxResult['openid'];
        // 用户是否登陆过
        $data['session_key'] = $wxResult['session_key'];
        if ($user = User::getByOpenId($data['open_id'])){
            User::where('open_id','=',$data['open_id'])->update($data);
            $user = $user->toArray();
        } else {
            $data = User::create($data);
            $user = User::where('id','=',$data['id'])->find();
        }
        // 生成令牌，写缓存
        $cacheValue = $this->prepareCachedValue($user);
        $token = $this->saveToCache($cacheValue);
        // 返回到客户端
        return array("status"=>1,"token"=>$token,"is_set"=>$user['is_set']);
    }


    /**
     * 准备数据
     * @param $user
     * @return mixed
     */
    private function prepareCachedValue($user){
        $cacheValue = $user;
        $cacheValue['ip'] = GetUserIp::getIP();
        return $cacheValue;
    }

    /**
     * 写入缓存
     * @param $cacheValue
     * @return false|string
     */
    private function saveToCache($cacheValue){
        $key = self::generateToken();
        $value = json_encode($cacheValue);
        $expire_in = config('wechat.token_expire_in');
        $request = cache($key,$value,$expire_in);//tp5 内置缓存
        if(!$request){
            return json_encode(["status"=>0,'msg'=>'服务器缓存异常']);
        }
        return $key;
    }

    /**
     * 快速生成邮箱对应的token
     * @param $email
     * @return bool|false|string
     */
    public static function saveEmailToCache($email){
        $key = self::getTokens().mt_rand(100000,999999);
        $expire_in = config('wechat.email_validate_time');
        $request = cache($key,$email,$expire_in);//tp5 内置缓存
        if(!$request){
            return json_encode(["status"=>0,'msg'=>'服务器缓存异常']);
        }
        return substr($key,-6);
    }
}