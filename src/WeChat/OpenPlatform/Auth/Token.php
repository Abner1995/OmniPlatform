<?php
namespace Abner\Omniplatform\WeChat\OpenPlatform\Auth;

use Abner\Omniplatform\Common\Http\HttpClientService;
use Abner\Omniplatform\Common\Url\WeChat\OpenPlatform\WeChatOpenPlatformURLs;

class Token 
{
    private $config;
    private $httpClient;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->httpClient = new HttpClientService();
    }

    public function accessToken($code)
    {
        if (empty($code)) return ['code' => 0, 'msg' => 'code不能为空'];
        $params = [
            'appid' => $this->config['app_id'],
            'secret' => $this->config['app_secret'],
            'code' => $code,
            'grant_type' => 'authorization_code',
        ];
        $Url = WeChatOpenPlatformURLs::access_token_URL . '?' . http_build_query($params);
        $return = $this->httpClient->sendGetRequest($Url, []);
        if (!empty($return['access_token'])) {
            return ['code' => 1, 'msg' => '获取成功', 'data' => $return];
        } else {
            $msg = '错误码：' . (isset($return['errcode']) ? $return['errcode'] : '未知错误') . '，错误信息：' . (!empty($return['errmsg']) ? $return['errmsg'] : '获取失败');
            return ['code' => 0, 'msg' => $msg, 'data' => !empty($return['data']) ? $return['data'] : []];
        }
    }

    public function refreshToken($refresh_token)
    {
        if (empty($refresh_token)) return ['code' => 0, 'msg' => 'refresh_token不能为空'];
        $params = [
            'appid' => $this->config['app_id'],
            'secret' => $this->config['app_secret'],
            'refresh_token' => $refresh_token,
            'grant_type' => 'refresh_token',
        ];
        $Url = WeChatOpenPlatformURLs::refresh_token_URL . '?' . http_build_query($params);
        $return = $this->httpClient->sendGetRequest($Url, []);
        // print_r($return);die;
        if (!empty($return['access_token'])) {
            return ['code' => 1, 'msg' => '获取成功', 'data' => $return];
        } else {
            $msg = '错误码：' . (isset($return['errcode']) ? $return['errcode'] : '未知错误') . '，错误信息：' . (!empty($return['errmsg']) ? $return['errmsg'] : '获取失败');
            return ['code' => 0, 'msg' => $msg, 'data' => !empty($return['data']) ? $return['data'] : []];
        }
    }

    public function checkToken($access_token, $openid)
    {
        if (empty($access_token)) return ['code' => 0, 'msg' => 'access_token不能为空'];
        if (empty($openid)) return ['code' => 0, 'msg' => 'openid不能为空'];
        $params = [
            'access_token' => $access_token,
            'openid' => $openid,
        ];
        $Url = WeChatOpenPlatformURLs::check_token_URL . '?' . http_build_query($params);
        $return = $this->httpClient->sendGetRequest($Url, []);
        // print_r($return);die;
        if (!empty($return) && isset($return['errcode']) && $return['errcode'] == 0) {
            return ['code' => 1, 'msg' => '获取成功', 'data' => $return];
        } else {
            $msg = '错误码：' . (isset($return['errcode']) ? $return['errcode'] : '未知错误') . '，错误信息：' . (!empty($return['errmsg']) ? $return['errmsg'] : '获取失败');
            return ['code' => 0, 'msg' => $msg, 'data' => !empty($return['data']) ? $return['data'] : []];
        }
    }

    public function userinfo($access_token, $openid)
    {
        if (empty($access_token)) return ['code' => 0, 'msg' => 'access_token不能为空'];
        if (empty($openid)) return ['code' => 0, 'msg' => 'openid不能为空'];
        $params = [
            'access_token' => $access_token,
            'openid' => $openid,
        ];
        $Url = WeChatOpenPlatformURLs::userinfo_URL . '?' . http_build_query($params);
        $return = $this->httpClient->sendGetRequest($Url, []);
        // print_r($return);die;
        if (!empty($return['openid'])) {
            return ['code' => 1, 'msg' => '获取成功', 'data' => $return];
        } else {
            $msg = '错误码：' . (isset($return['errcode']) ? $return['errcode'] : '未知错误') . '，错误信息：' . (!empty($return['errmsg']) ? $return['errmsg'] : '获取失败');
            return ['code' => 0, 'msg' => $msg, 'data' => !empty($return['data']) ? $return['data'] : []];
        }
    }
}