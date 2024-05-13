<?php
namespace Abner\Omniplatform\DouYin\MiniProgram\SubscribeNotification;

use Abner\Omniplatform\DouYin\Common\Response;
use Abner\Omniplatform\Common\Http\HttpClientService;
use Abner\Omniplatform\Common\Url\DouYin\MiniProgram\DouYinMiniProgramURLs;

class UrlQrcode
{
    private $config;
    private $httpClient;

    public function __construct(array $config)
    {
        $this->config = $config;
        if (empty($this->config['accessToken'])) return ['code' => 0, 'msg' => 'accessToken不能为空'];
        $this->httpClient = new HttpClientService();
    }

    public function generateSchema($params = [])
    {
        if (empty($params)) return ['code' => 0, 'msg' => '参数不能为空'];
        $data = [
            'app_id' => $this->config['app_id'],
        ];
        $data = array_merge($data, $params);
        $Url = DouYinMiniProgramURLs::generate_schema_URL;
        return $this->sendRequest($Url, $data);
    }

    public function querySchema($schema)
    {
        if (empty($schema)) return ['code' => 0, 'msg' => '参数不能为空'];
        $data = [
            'app_id' => $this->config['app_id'],
            'schema' => $schema,
        ];
        $Url = DouYinMiniProgramURLs::query_schema_URL;
        return $this->sendRequest($Url, $data);
    }

    public function querySchemaQuota()
    {
        if (empty($schema)) return ['code' => 0, 'msg' => '参数不能为空'];
        $data = [
            'app_id' => $this->config['app_id'],
        ];
        $Url = DouYinMiniProgramURLs::query_schema_quota_URL;
        return $this->sendRequest($Url, $data);
    }

    public function generateUrlLink($params = [])
    {
        if (empty($params)) return ['code' => 0, 'msg' => '参数不能为空'];
        $data = [
            'app_id' => $this->config['app_id'],
        ];
        $data = array_merge($data, $params);
        $Url = DouYinMiniProgramURLs::generate_url_link_URL;
        return $this->sendRequest($Url, $data);
    }

    public function queryUrlLink($url_link)
    {
        if (empty($url_link)) return ['code' => 0, 'msg' => '参数不能为空'];
        $data = [
            'app_id' => $this->config['app_id'],
            'url_link' => $url_link,
        ];
        $Url = DouYinMiniProgramURLs::query_url_link_URL;
        return $this->sendRequest($Url, $data);
    }

    public function queryUrlLinkQuota()
    {
        if (empty($schema)) return ['code' => 0, 'msg' => '参数不能为空'];
        $data = [
            'app_id' => $this->config['app_id'],
        ];
        $Url = DouYinMiniProgramURLs::query_url_link_quota_URL;
        return $this->sendRequest($Url, $data);
    }

    public function createQrcode($params = [])
    {
        if (empty($params)) return ['code' => 0, 'msg' => '参数不能为空'];
        $Url = DouYinMiniProgramURLs::create_qrcode_URL;
        return $this->sendRequest($Url, $params);
    }

    private function sendRequest($Url, $params)
    {
        $this->httpClient->setAccessToken($this->config['accessToken']);
        $return = $this->httpClient->sendRequestWithCustomContentType($Url, $params);
        return Response::result($return);
    }
}