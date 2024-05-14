<?php
namespace Abner\Omniplatform\DouYin\MiniProgram\SubscribeNotification;

use Abner\Omniplatform\DouYin\Common\Response;
use Abner\Omniplatform\Common\Http\HttpClientService;
use Abner\Omniplatform\Common\Url\DouYin\MiniProgram\DouYinMiniProgramURLs;

class NotifyUser
{
    private $config;
    private $httpClient;

    public function __construct(array $config)
    {
        $this->config = $config;
        if (empty($this->config['accessToken'])) return ['code' => 0, 'msg' => 'accessToken不能为空'];
        $this->httpClient = new HttpClientService();
    }

    public function notifyUser($params = [])
    {
        if (empty($params['msg_id']) || empty($params['open_id'])) {
            return ['code' => 0, 'msg' => '消息id或不能为空'];
        }
        $Url = DouYinMiniProgramURLs::notify_user_URL;
        return $this->sendRequest($Url, $params);
    }

    private function sendRequest($Url, $params = [])
    {
        $this->httpClient->setAccessToken($this->config['accessToken']);
        $return = $this->httpClient->sendRequestWithCustomContentType($Url, $params);
        return Response::result($return);
    }
}