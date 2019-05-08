<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 15:07
 */

namespace app\api\controller\v1;

use think\Loader;
use app\api\controller\BaseController;
use app\api\service\Token;
use app\api\model\Secret as SecretModel;
use app\api\model\User;
use app\api\model\Encryption;
use app\api\service\EncryptRoute;
use app\api\service\DecodeRoute;
use app\api\service\ShellingOrDecan;
class Secret extends BaseController
{

    /**
     * 获取备忘录列表
     * @return false|string
     */
    public function getSecret(){
        $this->isLogin();
        return json_encode(SecretModel::where('user_id','=',Token::getCurrentUid())->column('id,describe'));
    }

    /**
     * 获取单个备忘录详情
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getDetail(){
        $this->isLogin();
        $user_id = Token::getCurrentUid();
        Loader::validate('IDValidate')->goCheck();
        $id = Loader::validate('IDValidate')->getDataByRule(input('post.'))['id'];
        $theSecret = SecretModel::where('id','=',$id)->where('user_id','=',$user_id)->find();
        $package = User::where('id','=',Token::getCurrentUid())->value('package');
        if ($package) {
            $EncryptionPackages = explode(',', $package);//获取加密套餐
            $password = $theSecret['password'];
            for ($k = 1; $k < count($EncryptionPackages) - 1; $k++) {
                $name = Encryption::where('id', '=', $EncryptionPackages[$k])->value('decrypt_name');
                $password = DecodeRoute::Route($name, $password);
            }
            $theSecret['password'] = ShellingOrDecan::Shelling($password);
            return json_encode($theSecret);
        }
        return json_encode(['msg'=>'查看该账号密码备忘录失败，未设置加密套餐，请设置']);
    }

    /**
     * 创建账号密码备忘录
     * @return false|string
     */
    public function creatSecret(){
        $this->isLogin();
        $user_id = Token::getCurrentUid();
        Loader::validate('AddSecretValidate')->goCheck();
        $secret = Loader::validate('AddSecretValidate')->getDataByRule(input('post.'));
        $package = User::where('id','=',Token::getCurrentUid())->value('package');
        if ($package){
            $EncryptionPackages =  explode(',',$package);//获取加密套餐
            $password = ShellingOrDecan::Decan($secret['password']);
            for ($k=1;$k<count($EncryptionPackages)-1;$k++){
                $name = Encryption::where('id','=',$EncryptionPackages[$k])->value('name');
                $password = EncryptRoute::Route($name,$password);
            }
            SecretModel::create([
                'user_id'=>$user_id,
                'describe'=>$secret['describe'],
                'account'=>$secret['account'],
                'password'=>$password
            ]);
            return json_encode(['msg'=>'该账号密码备忘录创建成功']);
        } else {
            return json_encode(['msg'=>'该账号密码备忘录创建失败，未设置加密套餐，请设置']);
        }
    }


    public function editSecret(){
        $this->isLogin();
        $user_id = Token::getCurrentUid();
        Loader::validate('EditSecretValidate')->goCheck();
        $secret = Loader::validate('EditSecretValidate')->getDataByRule(input('post.'));
        if (SecretModel::where('id','=',$secret['id'])->where('user_id','=',$user_id)->find()){
            $data['describe'] = $secret['describe'];
            $data['account'] = $secret['account'];
            $password = ShellingOrDecan::Decan($secret['password']);
            $package = User::where('id','=',$user_id)->value('package');
            if ($package){
                $EncryptionPackages =  explode(',',$package);//获取加密套餐
                for ($k=1;$k<count($EncryptionPackages)-1;$k++){
                    $name = Encryption::where('id','=',$EncryptionPackages[$k])->value('name');
                    $password = EncryptRoute::Route($name,$password);
                }
                $data['password'] = $password;
                $is_do = SecretModel::where('id','=',$secret['id'])->update($data);
                if ($is_do)
                    return json_encode(['msg'=>'该账号密码备忘录更新成功']);
                return json_encode(['msg'=>'该账号密码备忘录更新失败或者信息未改变，请检查']);
            } else {
                return json_encode(['msg'=>'该账号密码备忘录更新失败，未设置加密套餐，请设置']);
            }
        } else {
            return json_encode(['msg'=>'该账号密码备忘录不存在']);
        }
    }

    public function delSecret(){
        $this->isLogin();
        $user_id = Token::getCurrentUid();
        Loader::validate('DelSecretValidate')->goCheck();
        $secret_id = Loader::validate('DelSecretValidate')->getDataByRule(input('post.'))['id'];
        if (SecretModel::where('id','=',$secret_id)->where('user_id','=',$user_id)->find()){
            $is_do = SecretModel::where('id','=',$secret_id)->delete();
            if ($is_do)return json_encode(['msg'=>'该账号密码备忘录删除成功']);
            return json_encode(['msg'=>'该账号密码备忘录删除失败，请检查']);
        } else {
            return json_encode(['msg'=>'该账号密码备忘录不存在']);
        }
    }
}