<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 23:32
 */

namespace app\api\service;


class DecodeRules extends BaseService
{
    /**
     * @param $data
     * @return string
     */
    public static function AES_CBC($data){
        $method = "AES-128-CBC";
        $password = config('encryptiontodecrypt.aes_cbc_key');
        $get_iv = (string)substr($data,0,16);
        $str = substr($data,16);
        $cipher = openssl_decrypt($str, $method,$password, $options=0, $iv=$get_iv);
        return $cipher;
    }

    /**
     * @param $data
     * @return bool|string
     */
    public static function Base_64_Decrypt($data){
        $e_data = base64_decode($data);
        return substr($e_data,16);
    }

    /**
     * @param $data
     * @return string
     */
    public static function RSA_Decrypt($data){
        $private_key = config('encryptiontodecrypt.private_key');
        $pi_key =  openssl_pkey_get_private($private_key);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
        $decrypted = "";
        openssl_private_decrypt(base64_decode($data),$decrypted,$pi_key);//私钥解密
        //openssl_public_decrypt(base64_decode($data),$decrypted,$pu_key);//私钥加密的内容通过公钥可用解密出来
        return $decrypted;
    }

    /**
     * @param $data
     * @return string
     */
    public static function DES_Decrypt($data){
        $key = config('encryptiontodecrypt.des_key');
        return openssl_decrypt($data, 'des-ecb', $key);
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function ThreeDes_Decrypt($data){
        $key = config('encryptiontodecrypt.3-des_key');
        $b_data = openssl_decrypt(base64_decode($data),'DES-EDE3',$key,OPENSSL_RAW_DATA|OPENSSL_NO_PADDING,'');
        if (strstr($b_data,"")) {
            $b_data = substr($b_data ,0,strpos($b_data,""));
        } else if (strstr($b_data,""))  {
            $b_data = substr($b_data ,0,strpos($b_data,""));
        } else if (strstr($b_data,""))  {
            $b_data = substr($b_data ,0,strpos($b_data,""));
        }else if (strstr($b_data,""))  {
            $b_data = substr($b_data ,0,strpos($b_data,""));
        }else if (strstr($b_data,""))  {
            $b_data = substr($b_data ,0,strpos($b_data,""));
        }else if (strstr($b_data,""))  {
            $b_data = substr($b_data ,0,strpos($b_data,""));
        }else if (strstr($b_data,""))  {
            $b_data = substr($b_data ,0,strpos($b_data,""));
        } else if (strstr($b_data,""))  {
            $b_data = substr($b_data ,0,strpos($b_data,""));
        }
        return $b_data;
    }
    public static function RC4_Decrypt($data){
        $data = base64_decode($data);
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
        return $cipher;
    }
}