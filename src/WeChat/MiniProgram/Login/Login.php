<?php
namespace Abner\Omniplatform\WeChat\MiniProgram\Login;

use Abner\Omniplatform\Common\Http\HttpClientService;
use Abner\Omniplatform\Common\Url\WeChat\MiniProgram\WeChatMiniProgramURLs;

class Login implements AbstractLogin
{
    private $config;
    private $httpClient;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->httpClient = new HttpClientService();
    }

    public function login($code)
    {
        if (empty($code)) return ['code' => 0, 'msg' => 'code不能为空'];
        $params = [
            'appid' => $this->config['app_id'],
            'secret' => $this->config['app_secret'],
            'js_code' => $code,
            'grant_type' => 'authorization_code',
        ];
        $Url = WeChatMiniProgramURLs::JSCODE2SESSION_URL;
        $return = $this->httpClient->sendPostRequest($Url, $params);
        // print_r($return);die;
        if (!empty($return['openid'])) {
            return ['code' => 1, 'msg' => '获取成功', 'data' => $return];
        } else {
            $msg = '错误码：' . (isset($return['errcode']) ? $return['errcode'] : '未知错误') . '，错误信息：' . (!empty($return['errmsg']) ? $return['errmsg'] : '获取失败');
            return ['code' => 0, 'msg' => $msg, 'data' => !empty($return['data']) ? $return['data'] : []];
        }
    }
}