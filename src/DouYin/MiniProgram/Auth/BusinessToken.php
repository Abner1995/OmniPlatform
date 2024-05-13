<?php
namespace Abner\Omniplatform\DouYin\MiniProgram\Auth;

use Abner\Omniplatform\DouYin\Common\Response;
use Abner\Omniplatform\Common\Http\HttpClientService;
use Abner\Omniplatform\Common\Url\DouYin\MiniProgram\DouYinMiniProgramURLs;

class BusinessToken
{
    private $config;
    private $httpClient;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->httpClient = new HttpClientService();
    }

    public function getToken($open_id, $scope = '')
    {
        if (empty($open_id)) return ['code' => 0, 'msg' => 'code不能为空'];
        $params = [
            'client_key' => $this->config['app_id'],
            'client_secret' => $this->config['app_secret'],
            'open_id' => $open_id,
            'scope' => $scope,
        ];
        $Url = DouYinMiniProgramURLs::business_access_token_URL;
        return $this->sendRequest($Url, $params);
    }

    public function refreshToken($refresh_token)
    {
        if (empty($code)) return ['code' => 0, 'msg' => 'code不能为空'];
        $params = [
            'client_key' => $this->config['app_id'],
            'client_secret' => $this->config['app_secret'],
            'refresh_token' => $refresh_token,
        ];
        $Url = DouYinMiniProgramURLs::business_refresh_token_URL;
        return $this->sendRequest($Url, $params);
    }

    public function businessScopes($accesstoken)
    {
        if (empty($accesstoken)) return ['code' => 0, 'msg' => 'code不能为空'];
        $Url = DouYinMiniProgramURLs::business_scopes_URL;
        return $this->sendRequest($Url, [], $accesstoken);
    }

    private function sendRequest($Url, $params = [], $accesstoken = '')
    {
        if (!empty($accesstoken)) {
            $this->httpClient->setAccessToken($accesstoken);
        }
        $return = $this->httpClient->sendRequestWithCustomContentType($Url, $params);
        return Response::result($return);
    }
}