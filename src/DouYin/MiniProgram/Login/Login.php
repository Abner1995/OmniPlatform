<?php
namespace Abner\Omniplatform\DouYin\MiniProgram\Login;

use Abner\Omniplatform\Common\Http\HttpClientService;
use Abner\Omniplatform\Common\Url\DouYin\MiniProgram\DouYinMiniProgramURLs;

class Login
{
    private $config;
    private $httpClient;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->httpClient = new HttpClientService();
    }

    public function login($code, $anonymous_code = '')
    {
        if (empty($code)) return ['code' => 0, 'msg' => 'code不能为空'];
        $params = [
            'appid' => $this->config['app_id'],
            'secret' => $this->config['app_secret'],
            'code' => $code,
            'anonymous_code' => $anonymous_code,
        ];
        $Url = DouYinMiniProgramURLs::JSCODE2SESSION_URL;
        $return = $this->httpClient->sendPostRequest($Url, $params);
        if (isset($return['err_no']) && $return['err_no'] == 0) {
            return ['code' => 1, 'msg' => '获取成功', 'data' => $return['data']];
        } else {
            $msg = '错误码：' . (isset($return['err_no']) ? $return['err_no'] : '-1') . '，错误信息：' . (!empty($return['err_tips']) ? $return['err_tips'] : '获取失败');
            return ['code' => 0, 'msg' => $msg, 'data' => !empty($return['data']) ? $return['data'] : []];
        }
    }
}