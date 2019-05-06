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
use app\api\model\User as UserModel;
use app\api\service\Token as TokenService;
use app\api\service\UserToken;

class User extends BaseController
{
    /**
     * 用户注册
     * @url /user/login
     * @http GET
     * @nums code
     */
    public function doWxLogin($code = ''){
        Loader::validate('TokenGet')->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        throw new SuccessMessage([
            'msg'=>$token
        ]);
    }
}