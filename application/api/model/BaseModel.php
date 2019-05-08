<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 11:58
 */

namespace app\api\model;
use think\Model;
use traits\model\SoftDelete;
use think\Db;

//通用和字段无关的function放这里

class BaseModel extends Model
{
    //读取器(AOP 切面思想)
    protected function prefixImgUrl($value,$data){
        if($data['from'] == 1)
            return config('setting.img_prefix').$value;
        return $value;
    }

}