<?php
namespace Abner\Omniplatform\DouYin\MiniProgram\Auth;

use Abner\Omniplatform\DouYin\Common\Response;
use Abner\Omniplatform\Common\Http\ContentType;
use Abner\Omniplatform\Common\Http\HttpClientService;
use Abner\Omniplatform\Common\Url\DouYin\MiniProgram\DouYinMiniProgramURLs;

class UserToken
{
    private $config;
    private $httpClient;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->httpClient = new HttpClientService();
    }

    public function getToken($code, $grant_type = 'authorization_code')
    {
        if (empty($code)) return ['code' => 0, 'msg' => 'code不能为空'];
        $params = [
            'client_key' => $this->config['app_id'],
            'client_secret' => $this->config['app_secret'],
            'code' => $code,
            'grant_type' => $grant_type,
        ];
        $Url = DouYinMiniProgramURLs::user_access_token_URL;
        return $this->sendRequest($Url, $params, ContentType::application_urlencoded, true);
    }

    public function refreshToken($refresh_token, $grant_type = 'refresh_token')
    {
        if (empty($code)) return ['code' => 0, 'msg' => 'code不能为空'];
        $params = [
            'client_key' => $this->config['app_id'],
            'refresh_token' => $refresh_token,
            'grant_type' => $grant_type,
        ];
        $Url = DouYinMiniProgramURLs::user_refresh_token_URL;
        return $this->sendRequest($Url, $params, ContentType::application_urlencoded, false);
    }

    public function renewRefreshToken($refresh_token)
    {
        if (empty($code)) return ['code' => 0, 'msg' => 'code不能为空'];
        $params = [
            'client_key' => $this->config['app_id'],
            'refresh_token' => $refresh_token,
        ];
        $Url = DouYinMiniProgramURLs::user_renew_refresh_token_URL;
        return $this->sendRequest($Url, $params, ContentType::application_urlencoded, false);
    }

    private function sendRequest($Url, $params = [], $ContentType = ContentType::application_urlencoded, $IsAddUrlParams = true)
    {
        if (!empty($ContentType)) {
            $this->httpClient->setContentType(ContentType::application_urlencoded);
        }
        $this->httpClient->setIsAddUrlParams($IsAddUrlParams);
        $return = $this->httpClient->sendRequestWithCustomContentType($Url, $params);
        return Response::result($return);
    }
}