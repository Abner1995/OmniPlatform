<?php
namespace Abner\Omniplatform\DouYin\MiniProgram\Auth;

use Abner\Omniplatform\DouYin\Common\Response;
use Abner\Omniplatform\Common\Http\HttpClientService;
use Abner\Omniplatform\Common\Url\DouYin\MiniProgram\DouYinMiniProgramURLs;

class NoUserToken
{
    private $config;
    private $httpClient;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->httpClient = new HttpClientService();
    }

    public function clientToken($grant_type = 'client_credential')
    {
        $params = [
            'client_key' => $this->config['app_id'],
            'client_secret' => $this->config['app_secret'],
            'grant_type' => $grant_type,
        ];
        $Url = DouYinMiniProgramURLs::nouser_client_token_URL;
        return $this->sendRequest($Url, $params);
    }

    public function getToken($grant_type = 'client_credential')
    {
        $params = [
            'appid' => $this->config['app_id'],
            'secret' => $this->config['app_secret'],
            'grant_type' => $grant_type,
        ];
        $Url = DouYinMiniProgramURLs::nouser_token_URL;
        return $this->sendRequest($Url, $params);
    }

    private function sendRequest($Url, $params = [])
    {
        $return = $this->httpClient->sendRequestWithCustomContentType($Url, $params);
        return Response::result($return);
    }
}