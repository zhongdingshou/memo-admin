<?php
//动态配置路由
use think\Route;//动态需要引入这个



Route::get('api/:version/user/login','api/:version.User/doWxLogin');//做登陆