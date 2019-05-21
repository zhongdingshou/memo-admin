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
use app\api\controller\BaseController;
use app\api\model\User;
use app\api\model\Encryption as EncryptionModel;
class Encryption extends BaseController
{
    /**
     * 获取所有加密种类
     * @return false|string
     */
    public function getEncryption(){
        $this->isLogin();
        return json_encode(['status'=>1,'data'=>EncryptionModel::column('id,name')]);
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
        $is_do = User::where('id','=',$user_id)->update($package);
        if ($is_do) {
            $theUser = User::where('id','=',$user_id)->find();
            if ($theUser['is_set']){
                $is_set =  explode('.',$theUser['is_set']);
                for ($i=1;$i<count($is_set)-1;$i++){
                    if ($is_set[$i]==2)
                        break;
                }
                if ($i==count($is_set)-1) {
                    $data['is_set'] = $theUser['is_set'].'2.';
                    User::where('id','=',$user_id)->update($data);
                }
            } else {
                $data['is_set'] = $theUser['is_set'].'.2.';
                User::where('id','=',$user_id)->update($data);
            }
            UserToken::update(User::where('id','=',$user_id)->find());
            return json_encode(['status'=>1,'msg'=>'加密套餐设置成功']);
        } else{
            return json_encode(['status'=>0,'msg'=>'加密套餐设置失败或者内容没变化，请检查']);
        }
    }

}