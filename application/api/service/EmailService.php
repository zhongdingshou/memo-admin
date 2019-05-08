<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 19:34
 */

namespace app\api\service;


class EmailService extends BaseService
{
    /**
     * 初始化邮箱服务
     * @param $toemail
     * @return \PHPMailer\PHPMailer
     * @throws \PHPMailer\Exception
     */
    public static function initStmp($toemail) {
        $mail = new \PHPMailer\PHPMailer();
        $from = config('smtp.nums');
        $mail->isSMTP();// 使用SMTP服务
        $mail->CharSet = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码
        $mail->Host = config('smtp.host');//"smtp.exmail.qq.com";// 发送方的SMTP服务器地址
        $mail->SMTPAuth = true;// 是否使用身份验证
        $mail->Username = $from;// 发送方的163邮箱用户名，就是你申请163的SMTP服务使用的163邮箱
        $mail->Password = config('smtp.password');// 发送方的邮箱密码，注意用163邮箱这里填写的是“客户端授权密码”而不是邮箱的登录密码！
        $mail->SMTPSecure = "ssl";// 使用ssl协议方式
        $mail->Port = config('smtp.port');//465;// 163邮箱的ssl协议方式端口号是465/994
        $mail->setFrom($from,config('smtp.name'));// 设置发件人信息，如邮件格式说明中的发件人，这里会显示为Mailer(xxxx@163.com），Mailer是当做名字显示
        $mail->addAddress($toemail,'Dear user');// 设置收件人信息，如邮件格式说明中的收件人，这里会显示为Liang(yyyy@163.com)
        return $mail;
    }

}