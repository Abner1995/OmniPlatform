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

    /**
     * 签名
     * @param array $map
     * @param string $salt
     * @return string
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-05-15 13:56:07
     */    
    public static function sign(array $map, $salt)
    {
        $rList = [];
        foreach ($map as $k => $v) {
            if ($k == "other_settle_params" || $k == "app_id" || $k == "sign" || $k == "thirdparty_id")
            continue;

            $value = trim(strval($v));
            if (is_array($v)) {
                $value = self::arrayToStr($v);
            }

            $len = strlen($value);
            if ($len > 1 && substr($value, 0, 1) == "\"" && substr($value, $len - 1) == "\"")
                $value = substr($value, 1, $len - 1);
            $value = trim($value);
            if ($value == "" || $value == "null")
                continue;
            $rList[] = $value;
        }
        $rList[] = $salt;
        sort($rList, SORT_STRING);
        return md5(implode('&', $rList));
    }

    /**
     * 将数组转换为字符串表示形式。
     * @param array $map 要转换的数组或关联数组。
     * @return string 返回表示数组的字符串。对于关联数组，将按照键名排序，并以“map[键名:值 空格]”的格式表示；
     * 对于普通数组，则以“[值 空格]”的格式表示其元素。
     */
    public static function arrayToStr($map)
    {
        $isMap = self::isArrMap($map);
        $result = "";
        if ($isMap) {
            $result = "map[";
        }
        $keyArr = array_keys($map);
        if ($isMap) {
            sort($keyArr);
        }
        $paramsArr = array();
        foreach ($keyArr as  $k) {
            $v = $map[$k];
            if ($isMap) {
                if (is_array($v)) {
                    $paramsArr[] = sprintf("%s:%s", $k, self::arrayToStr($v));
                } else {
                    $paramsArr[] = sprintf("%s:%s", $k, trim(strval($v)));
                }
            } else {
                if (is_array($v)) {
                    $paramsArr[] = self::arrayToStr($v);
                } else {
                    $paramsArr[] = trim(strval($v));
                }
            }
        }
        $result = sprintf("%s%s", $result, join(" ", $paramsArr));
        if (!$isMap) {
            $result = sprintf("[%s]", $result);
        } else {
            $result = sprintf("%s]", $result);
        }
        return $result;
    }

    /**
     * 检查给定的数组是否为键为字符串的关联数组。
     * @param array $map 要检查的数组。
     * @return bool 如果数组中的至少一个键是字符串，则返回true；否则返回false。
     */
    public static function isArrMap($map)
    {
        foreach ($map as $k => $v) {
            if (is_string($k)) {
                return true;
            }
        }
        return false;
    }
}