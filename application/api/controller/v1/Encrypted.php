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
use app\api\controller\BaseController;
use app\api\service\UserToken;
use app\api\model\Encrypted as EncryptedModel;
use app\api\model\User;
class Encrypted extends BaseController
{
    /**
     * 获取所有密保
     * @return false|string
     */
    public function getEncrypted(){
        $this->isLogin();
        $all = EncryptedModel::where('user_id','=',Token::getCurrentUid())->limit(3)->column('id,problem');
        if ($all){
            return json_encode(['status'=>1,'msg'=>$all]);
        } else {
            return json_encode(['status'=>0,'msg'=>null]);
        }
    }

    /**
     * 密保验证
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function checkEncrypted(){
        $this->isLogin();
        Loader::validate('EncryptedValidate')->goCheck();
        $answer = Loader::validate('EncryptedValidate')->getDataByRule(input('post.'))['answer'];
        $encrypted = EncryptedModel::where('user_id','=',Token::getCurrentUid())->limit(3)->order('id')->select();
        for ($i=0;$i<3;$i++){
            if ($answer[$i]!=$encrypted[$i]['answer']){
                return json_encode(['status'=>0,'msg'=>'密保验证失败，第'.++$i.'个答案错误，请检查','data'=>$encrypted]);
            }
        }
        return json_encode(['status'=>1,'msg'=>'密保验证成功']);
    }

    /**
     * 密保设置
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function newEncrypted(){
        $this->isLogin();
        Loader::validate('AddEncryptedValidate')->goCheck();
        $package = Loader::validate('AddEncryptedValidate')->getDataByRule(input('post.'));
        $user_id = Token::getCurrentUid();
        $oldEncrypted = EncryptedModel::where('user_id','=',$user_id)->select();
        if ($oldEncrypted) {
            EncryptedModel::where('user_id', '=', $user_id)->delete();
        }
        if(!$package['problem']||!$package['answer']){
            $theUser = User::where('id','=',$user_id)->find();
            if ($theUser['is_set']){
                $is_set =  explode('.',$theUser['is_set']);
                $new_set = '.';
                for ($i=1;$i<count($is_set)-1;$i++){
                    if ($is_set[$i]!=3){
                        $new_set = $new_set.$is_set[$i].'.';
                    }
                }
                if ($new_set!='.') {
                    $data['is_set'] = $new_set;
                    User::where('id','=',$user_id)->update($data);
                }
                UserToken::update(User::where('id','=',$user_id)->find());
            }
            return json_encode(['status'=>0,'msg'=>'密保设置失败']);
        }
        $data['user_id'] = $user_id;
        for ($j=0;$j<3;$j++){
            $data['problem'] = $package['problem'][$j];
            $data['answer'] = $package['answer'][$j];
            EncryptedModel::create($data);
        }
        if ($j==3){
            $theUser = User::where('id','=',$user_id)->find();
            if ($theUser['is_set']){
                $is_set =  explode('.',$theUser['is_set']);
                for ($i=1;$i<count($is_set)-1;$i++){
                    if ($is_set[$i]==3)
                        break;
                }
                if ($i==count($is_set)-1) {
                    $newdata['is_set'] = $theUser['is_set'].'3.';
                    User::where('id','=',$user_id)->update($newdata);
                }
            } else {
                $newdata['is_set'] = $theUser['is_set'].'.3.';
                User::where('id','=',$user_id)->update($newdata);
            }
            UserToken::update(User::where('id','=',$user_id)->find());
            return json_encode(['status'=>1,'msg'=>'密保设置成功']);
        }
        return json_encode(['status'=>0,'msg'=>'密保设置失败，请检查']);
    }
}