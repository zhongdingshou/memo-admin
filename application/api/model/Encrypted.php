<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 16:04
 */

namespace app\api\model;


class Encrypted extends BaseModel
{
    protected $hidden = ['user_id，answer'];
}