<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 16:03
 */

namespace app\api\controller\v1;

use think\Loader;
use app\api\service\Token;
use app\api\service\UserToken;
use app\api\service\DecodeRoute;
use app\api\service\EncryptRoute;
use app\api\controller\BaseController;
use app\api\model\User;
use app\api\model\Secret;
use app\api\model\Encryption as EncryptionModel;
use app\api\service\ShellingOrDecan;
class Encryption extends BaseController
{
    /**
     * 获取所有加密种类
     * @return false|string
     */
    public function getEncryption(){
        $this->isLogin();
        $all = EncryptionModel::column('id,name');
        if ($all){
            return json_encode(['status'=>1,'msg'=>$all]);
        } else {
            return json_encode(['status'=>0,'msg'=>null]);
        }
    }

    /**
     * 加密套餐设置
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function newPackage(){
        $this->isLogin();
        Loader::validate('PackageValidate')->goCheck();
        $user_id = Token::getCurrentUid();
        $package = Loader::validate('PackageValidate')->getDataByRule(input('post.'));
        $theUser = User::where('id','=',$user_id)->find();
        if ($theUser['package']) {
            $EncryptionPackages = explode(',', $theUser['package']);//获取旧加密套餐
            $newpackage = explode(',', ShellingOrDecan::Decan($package['package']));//获取新加密套餐
            $secret = Secret::where('user_id','=',$user_id)->select();
            foreach ($secret as $s){
                $password = $s['password'];
                for ($k = count($EncryptionPackages) - 2; $k > 0 ; $k--) {
                    $name = EncryptionModel::where('id', '=', $EncryptionPackages[$k])->value('decrypt_name');
                    $temp = DecodeRoute::Route($name, $password);
                    if ($password != $temp) $password = $temp;
                    else break;
                }
                if ($k == 0) {
                    for ($j = 1; $j < count($newpackage) - 1; $j++) {
                        $name = EncryptionModel::where('id', '=', $newpackage[$j])->value('name');
                        $temp = EncryptRoute::Route($name, $password);
                        if ($password != $temp) $password = $temp;
                        else break;
                    }
                    if ($j == count($newpackage) - 1) {
                        Secret::where('id','=',$s['id'])->update(['password'=>$password]);
                    } else {
                        return json_encode(['status'=>0,'msg'=>'加密套餐设置失败，请检查']);
                    }
                } else {
                    return json_encode(['status'=>0,'msg'=>'加密套餐设置失败，请检查']);
                }
            }
        } else {
            if ($theUser['is_set']) {
                $data['is_set'] = $theUser['is_set'].'2.';
            } else {
                $data['is_set'] = $theUser['is_set'].'.2.';
            }
            User::where('id','=',$user_id)->update($data);
        }
        User::where('id','=',$user_id)->update(['package'=>ShellingOrDecan::Decan($package['package'])]);
        UserToken::update(User::where('id','=',$user_id)->find());
        return json_encode(['status'=>1,'msg'=>'加密套餐设置成功']);
    }

}