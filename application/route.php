<?php
//动态配置路由
use think\Route;//动态需要引入这个



Route::post('api/:version/user/login','api/:version.User/doWxLogin');//做登陆
Route::post('api/:version/user/quitApplet','api/:version.User/quitApplet');//弃用小程序

Route::get('api/:version/secret/getSecret','api/:version.Secret/getSecret');//获取列表
Route::post('api/:version/secret/getDetail','api/:version.Secret/getDetail');//获取详情
Route::post('api/:version/secret/creatSecret','api/:version.Secret/creatSecret');//创建备忘录
Route::post('api/:version/secret/editSecret','api/:version.Secret/editSecret');//编辑备忘录
Route::post('api/:version/secret/delSecret','api/:version.Secret/delSecret');//删除备忘录
Route::post('api/:version/secret/searchSecret','api/:version.Secret/searchSecret');//搜索备忘录

Route::post('api/:version/command/checkCommand','api/:version.Command/checkCommand');//口令验证
Route::post('api/:version/command/newCommand','api/:version.Command/newCommand');//口令设置
Route::get('api/:version/command/getCommand','api/:version.Command/getCommand');//查看口令

Route::get('api/:version/encrypted/getEncrypted','api/:version.Encrypted/getEncrypted');//获取密保列表
Route::post('api/:version/encrypted/checkEncrypted','api/:version.Encrypted/checkEncrypted');//密保验证
Route::post('api/:version/encrypted/newEncrypted','api/:version.Encrypted/newEncrypted');//密保设置

Route::get('api/:version/encryption/getEncryption','api/:version.Encryption/getEncryption');//获取加密列表
Route::post('api/:version/encryption/newPackage','api/:version.Encryption/newPackage');//设置加密套餐

Route::post('api/:version/email/newEmail','api/:version.Email/newEmail');//设置邮箱
Route::post('api/:version/email/checkEmail','api/:version.Email/checkEmail');//设置邮箱



