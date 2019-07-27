<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 23:28
 */

namespace app\api\service;


class EncryptRules extends BaseService
{
    /**
     * @param $data
     * @return string
     */
    public static function AES_CBC($data){
        $method = "AES-128-CBC";
        $password = config('encryptiontodecrypt.aes_cbc_key');
        list($t1, $t2) = explode(' ', microtime());
        $get_iv = (string)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000000);
        $str = openssl_encrypt($data, $method, $password, $options=0, $iv=$get_iv);
        return  $get_iv.$str;
    }

    /**
     * @param $data
     * @return string
     */
    public static function Base_64_Encode($data){
        list($t1, $t2) = explode(' ', microtime());
        return base64_encode((string)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000000).$data);
    }

    /**
     * @param $data
     * @return string
     */
    public static function RSA_Encode($data){
        $public_key = config('encryptiontodecrypt.public_key');
        $pu_key = openssl_pkey_get_public($public_key);//这个函数可用来判断公钥是否是可用的
        $encrypted = "";
        openssl_public_encrypt($data,$encrypted,$pu_key);//公钥加密
        //openssl_private_encrypt($data,$encrypted,$pi_key);//私钥加密
        return base64_encode($encrypted);
    }

    /**
     * @param $data
     * @return string
     */
    public static function DES_Encode($data){
        $key = config('encryptiontodecrypt.des_key');
        return openssl_encrypt($data, 'des-ecb', $key);
    }

    /**
     * @param $data
     * @return string
     */
    public static function ThreeDes_Encode($data){
        $key = config('encryptiontodecrypt.3-des_key');
        $pad = 8 - (strlen($data) % 8);
        $data = $data . str_repeat(chr($pad), $pad);
        if(strlen($data) % 8) {
            $data = str_pad($data, strlen($data) + 8 - strlen($data) % 8, "\0");
        }
        $e_data = openssl_encrypt($data ,'DES-EDE3',$key,OPENSSL_RAW_DATA|OPENSSL_NO_PADDING,'');
        return base64_encode($e_data);
    }

    public static function RC4_Encode($data){
        $pwd = config('encryptiontodecrypt.rc4_key');
        $cipher      = '';
        $key[]       = "";
        $box[]       = "";
        $pwd_length  = strlen($pwd);
        $data_length = strlen($data);
        for ($i = 0; $i < 256; $i++) {
            $key[$i] = ord($pwd[$i % $pwd_length]);
            $box[$i] = $i;
        }
        for ($j = $i = 0; $i < 256; $i++) {
            $j       = ($j + $box[$i] + $key[$i]) % 256;
            $tmp     = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $data_length; $i++) {
            $a       = ($a + 1) % 256;
            $j       = ($j + $box[$a]) % 256;
            $tmp     = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $k       = $box[(($box[$a] + $box[$j]) % 256)];
            $cipher .= chr(ord($data[$i]) ^ $k);
        }
        return base64_encode($cipher);
    }
}