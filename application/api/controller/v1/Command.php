<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 15:50
 */

namespace app\api\controller\v1;
use app\api\service\Token;
use app\api\service\UserToken;
use think\Loader;
use app\api\controller\BaseController;
use app\api\model\User;
use app\api\service\ShellingOrDecan;
class Command extends BaseController
{
    /**
     * 口令验证
     * @return false|string
     */
    public function checkCommand(){
        $this->isLogin();
        Loader::validate('CommandValidate')->goCheck();
        $command = Loader::validate('CommandValidate')->getDataByRule(input('post.'))['command'];
        if (ShellingOrDecan::Decan($command)===Token::getCurrentTokenVar('command'))
            return json_encode(['msg'=>'口令验证成功']);
        return json_encode(['msg'=>'口令验证失败，请检查']);
    }

    /**
     * 口令设置
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function newCommand(){
        $this->isLogin();
        Loader::validate('CommandValidate')->goCheck();
        $user_id = Token::getCurrentUid();
        $command = Loader::validate('CommandValidate')->getDataByRule(input('post.'))['command'];
        $is_do = User::where('id','=',$user_id)->update(['command'=>ShellingOrDecan::Decan($command)]);
        if ($is_do) {
            $theUser = User::where('id','=',$user_id)->find();
            if ($theUser['is_set']){
                $is_set =  explode('.',$theUser['is_set']);
                for ($i=1;$i<count($is_set)-1;$i++){
                    if ($is_set[$i]==1)
                        break;
                }
                if ($i==count($is_set)-1) {
                    $data['is_set'] = $theUser['is_set'].'1.';
                    User::where('id','=',$user_id)->update($data);
                }
            } else {
                $data['is_set'] = $theUser['is_set'].'.1.';
                User::where('id','=',$user_id)->update($data);
            }
            UserToken::update(User::where('id','=',$user_id)->find());
            return json_encode(['msg'=>'口令设置成功']);
        } else {
            return json_encode(['msg'=>'口令设置失败或者内容没变化，请检查']);
        }
    }

}