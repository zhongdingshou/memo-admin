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
        $is_do = User::where('id','=',$user_id)->update(['package'=>ShellingOrDecan::Decan($package['package'])]);
        if ($is_do) {
            $theUser = User::where('id','=',$user_id)->find();
            if ($theUser['is_set']){
                $is_set =  explode('.',$theUser['is_set']);
                for ($i=1;$i<count($is_set)-1;$i++){
                    if ($is_set[$i]==2){
                        break;
                    }
                }
                if ($i==count($is_set)-1) {
                    $data['is_set'] = $theUser['is_set'].'2.';
                    User::where('id','=',$user_id)->update($data);
                }
            } else {
                $data['is_set'] = $theUser['is_set'].'.2.';
                User::where('id','=',$user_id)->update($data);
            }

            $EncryptionPackages = explode(',', Token::getCurrentTokenVar('package'));//获取旧加密套餐
            $newpackage = explode(',', ShellingOrDecan::Decan($package['package']));//获取新加密套餐
            if ($EncryptionPackages){
                $secret = Secret::where('user_id','=',$user_id)->select();
                if ($secret){
                    foreach ($secret as $s){
                        $password = $s['password'];
                        for ($k = count($EncryptionPackages) - 1; $k > 0 ; $k--) {
                            $name = EncryptionModel::where('id', '=', $EncryptionPackages[$k])->value('decrypt_name');
                            $password = DecodeRoute::Route($name, $password);
                        }
                        for ($j = 1; $j < count($newpackage) - 1; $j++) {
                            $name = EncryptionModel::where('id', '=', $newpackage[$j])->value('name');
                            $password = EncryptRoute::Route($name, $password);
                        }
                        Secret::where('id','=',$s['id'])->update(['password'=>$password]);
                    }
                }
            }
            UserToken::update(User::where('id','=',$user_id)->find());
            return json_encode(['status'=>1,'msg'=>'加密套餐设置成功']);
        } else{
            return json_encode(['status'=>0,'msg'=>'加密套餐设置失败或者内容没变化，请检查']);
        }
    }

}