<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 19:22
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use think\Cache;
use think\Loader;
use app\api\service\Token;
use app\api\service\UserToken;
use app\api\model\User;
use app\api\service\SendEmail;
use app\api\service\ShellingOrDecan;
class Email extends BaseController
{
    /**
     * 发送邮箱验证码
     * @return bool|false|string
     * @throws \PHPMailer\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function newEmail(){
        $this->isLogin();
        Loader::validate('EmailValidate')->goCheck();
        $email = Loader::validate('EmailValidate')->getDataByRule(input('post.'));
        $is_go =  SendEmail::sendUserEmailCheck($email['email']);
        if ($is_go  === true) {
            $user_id = Token::getCurrentUid();
            if(!$user_id){
                return json_encode(['status'=>0,'msg'=>'用户未登录']);
            }
            $theUser = User::where('id','=',$user_id)->find();
            if ($theUser['email']) {
                if ($theUser['email']!=$email['email']) {
                    User::where('id','=',$user_id)->update(['email'=>null]);
                    if ($theUser['is_set']){
                        $is_set =  explode('.',$theUser['is_set']);
                        $new_set = '.';
                        for ($i=1;$i<count($is_set)-1;$i++){
                            if ($is_set[$i]!=4){
                                $new_set = $new_set.$is_set[$i].'.';
                            }
                        }
                        if ($new_set!='.') {
                            $data['is_set'] = $new_set;
                            User::where('id','=',$user_id)->update($data);
                        }
                        UserToken::update(User::where('id','=',$user_id)->find());
                    }
                }
            }
            return json_encode(['status'=>1,'msg'=>'验证码发送成功']);
        } else {
            return $is_go;
        }
    }

    /**
     * 获取邮箱
     */
    public function getEmail(){
        $this->isLogin();
        $userCache = Cache::get(Token::getTokens());
        if ($userCache) {
            $data = json_decode($userCache,true);
            return json_encode(['status'=>1,'msg'=>$data['email']]);
        }
        return json_encode(['status'=>0,'msg'=>'获取失败']);
    }

    /**
     * 邮箱验证码验证
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function checkEmail(){
        $this->isLogin();
        Loader::validate('CheckEmailValidate')->goCheck();
        $user_id = Token::getCurrentUid();
        $verify = Loader::validate('CheckEmailValidate')->getDataByRule(input('post.'))['verify'];
        $verify = ShellingOrDecan::Decan($verify);
        if ($email = Cache::get(UserToken::getTokens().$verify)){
            $is_do = User::where('id','=',$user_id)->update(['email'=>$email]);
            if ($is_do) {
                $theUser = User::where('id','=',$user_id)->find();
                if ($theUser['is_set']){
                    $is_set =  explode('.',$theUser['is_set']);
                    for ($i=1;$i<count($is_set)-1;$i++){
                        if ($is_set[$i]==4)
                            break;
                    }
                    if ($i==count($is_set)-1) {
                        $data['is_set'] = $theUser['is_set'].'4.';
                        User::where('id','=',$user_id)->update($data);
                    }
                } else {
                    $data['is_set'] = $theUser['is_set'].'.4.';
                    User::where('id','=',$user_id)->update($data);
                }
                UserToken::update(User::where('id','=',$user_id)->find());
                \cache(UserToken::getTokens().$verify,null);
                return json_encode(['status'=>1,'msg'=>'验证通过，邮箱设置成功']);
            } else {
                return json_encode(['status'=>2,'msg'=>'验证通过']);
            }
        } else {
            return json_encode(['status'=>0,'msg'=>'邮箱设置失败,验证码已过期']);
        }
    }


}