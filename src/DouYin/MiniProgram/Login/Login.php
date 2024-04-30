<?php
namespace Abner\Omniplatform\Douyin\MiniProgram\Login;

use Abner\Omniplatform\Common\Http\HttpClientService;
use Abner\Omniplatform\Common\Url\DouYin\MiniProgram\DouYinMiniProgramURLs;

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
        // $Url = DouYinMiniProgramURLs::JSCODE2SESSION_URL;
        $Url = DouYinMiniProgramURLs::JSCODE2SESSION_sandbox_URL;
        $return = $this->httpClient->sendPostRequest($Url, $params);
        if (isset($return['err_no']) && $return['err_no'] == 0) {
            return ['code' => 1, 'msg' => '获取成功', 'data' => $return['data']];
        } else {
            return ['code' => 0, 'msg' => !empty($return['err_tips']) ? $return['err_tips'] : '获取失败', 'data' => $return['data']];
        }
    }
}