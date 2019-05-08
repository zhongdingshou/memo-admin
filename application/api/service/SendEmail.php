<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 19:32
 */

namespace app\api\service;
use PHPMailer\SendEmail as SendEmailq;

class SendEmail extends EmailService
{
    /**
     * 发送验证邮箱操作
     * @param $to_email
     * @return bool|false|string
     * @throws \PHPMailer\Exception
     */
    public static function sendUserEmailCheck($to_email){
        $CheckNumber = UserToken::saveEmailToCache($to_email);
        $mail = EmailService::initStmp($to_email);
        $mail->Subject = "个人账号密码备忘录小程序邮箱验证码";// 邮件标题
        $mail->Body = "你好，个人账号密码备忘录小程序用户正绑定该邮箱，验证码为：".$CheckNumber."，请及时将验证码在小程序中输入进去，验证码有效期为5分钟。 (若非本人本人操作，无视该信息即可)";// 邮件正文
        if(!$mail->send()){// 发送邮件失败
            return json_encode(['msg' => "发送邀请邮件失败，可重新发送"]);
        }
        return true;
    }
}