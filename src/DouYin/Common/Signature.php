<?php
namespace Abner\Omniplatform\DouYin\Common;

class Signature
{
    /**
     * 生成签名
     * @param array $config
     * @param string $config.private_key_url 密钥url
     * @param string $method HTTP 请求方法 POST，GET，PUT 等。注意请使用大写。
     * @param string $url 获取请求的开放平台接口的绝对URL，并去除域名部分得到参与签名的URI。URI必须以斜杠字符“/”开头。如
     * PATH=https://open.douyin.com/api/trade/v2/query URI 则为 /api/trade/v2/query
     * @param string $body 请求报文主体
     * @param string $timestamp 请求时间戳
     * @param string $nonceStr 请求随机串
     * @return string
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-05-14 10:56:01
     */    
    public static function makeSign($config, $method, $url, $body, $timestamp, $nonceStr)
    {
        if (empty($config['private_key_url'])) return null;
        $text = $method . "\n" . $url . "\n" . $timestamp . "\n" . $nonceStr . "\n" . $body . "\n";
        $priKey = file_get_contents($config['private_key_url']);
        $privateKey = openssl_get_privatekey($priKey, '');
        openssl_sign($text, $sign, $privateKey, OPENSSL_ALGO_SHA256);
        return base64_encode($sign);
    }

    /**
     * 验签
     * @param array $config
     * @param string $config.public_key_url 公钥url
     * @param string $http_body HTTP 请求方法 POST，GET，PUT 等。注意请使用大写。
     * @param string $timestamp 请求时间戳
     * @param string $nonce_str 请求随机串
     * @param string $sign 签名
     * @return string
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-05-14 11:02:04
     */    
    public static function verify($config,$http_body, $timestamp, $nonce_str, $sign)
    {
        if (empty($config['public_key_url'])) return null;
        $data = $timestamp . "\n" . $nonce_str . "\n" . $http_body . "\n";
        $publicKey = file_get_contents($config['public_key_url']);
        if (!$publicKey) {
            return null;
        }
        $res = openssl_get_publickey($publicKey);
        $result = (bool)openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
        openssl_free_key($res);
        return $result;
    }

    public function sign(array $map, $salt)
    {
        $rList = array();
        foreach ($map as $k => $v) {
            if ($k == "other_settle_params" || $k == "app_id" || $k == "sign" || $k == "thirdparty_id") {
                continue;
            }
            $value = trim(strval($v));
            $len = strlen($value);
            if ($len > 1 && substr($value, 0, 1) == "\"" && substr($value, $len, $len - 1) == "\"") {
                $value = substr($value, 1, $len - 1);
            }
            $value = trim($value);
            if ($value == "" || $value == "null") {
                continue;
            }
            array_push($rList, $value);
        }
        array_push($rList, $salt);
        sort($rList, 2);
        return md5(implode('&', $rList));
    }
}