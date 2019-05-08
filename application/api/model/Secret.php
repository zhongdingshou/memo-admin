<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 15:07
 */

namespace app\api\model;


class Secret extends BaseModel
{
    protected $hidden = ['user_id'];
}