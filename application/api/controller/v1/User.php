<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/6
 * Time: 23:06
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use think\Loader;
use think\Cache;
use app\api\service\Token;
use app\api\service\UserToken;
use app\api\model\Encrypted as EncryptedModel;
use app\api\model\User as UserModel;
use app\api\model\Secret;
class User extends BaseController
{
    /**
     * 用户注册
     * @url /user/login
     * @http POST
     * @nums code
     */
    public function doWxLogin(){
        Loader::validate('TokenGet')->goCheck();
        $code = Loader::validate('TokenGet')->getDataByRule(input('post.'))['code'];
        if(!$this->alreadyLogin()){
            $ut = new UserToken($code);
            $token = $ut->get();
            return json_encode($token);
        } else {
            return json_encode(["status"=>2, 'msg'=>'登陆成功']);
        }
    }

    /**
     * 是否已经注册登陆
     * @return bool
     */
    protected function alreadyLogin(){
        $token = Token::getTokens();
        if ($token&&Cache::get($token)){//判断客户端有无保存token以及存不存在该缓存
            return true;
        }
        return false;
    }

    /**
     * 用户弃用小程序
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function quitApplet(){
        $this->isLogin();
        $user_id = Token::getCurrentUid();
        $user = UserModel::where('id','=',$user_id)->find();
        if ($user) {
            Secret::where('user_id','=',Token::getCurrentUid())->delete();
            UserModel::where('id','=',Token::getCurrentUid())->delete();
            EncryptedModel::where('user_id','=',Token::getCurrentUid())->delete();
            \cache(Token::getTokens(),null);
            return json_encode(['status'=>1,'msg'=>'弃用成功，欢迎下次使用']);
        } else {
            return json_encode(['status'=>0,'msg'=>'弃用失败，未找到']);
        }
    }
}