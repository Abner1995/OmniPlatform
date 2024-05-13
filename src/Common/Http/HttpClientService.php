<?php
namespace Abner\Omniplatform\Common\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Abner\Omniplatform\Common\Config\Platform;
use Abner\Omniplatform\Common\Config\AccessTokenKey;

class HttpClientService
{
    private $client;
    private $verify = false;
    private $accessToken = '';
    private $accessTokenKey = '';
    private $isAddUrlParams = true;
    private $ContentType = ContentType::application_json;

    public function __construct()
    {
        $config = [
            'verify' => $this->verify,
        ];
        $this->client = new Client($config);
    }

    /**
     * 发送带有自定义内容类型的请求
     * @param string $url 请求的URL地址
     * @param array $data 要发送的数据
     * @return array 返回请求结果，如果是JSON格式则解析为数组；请求失败时返回错误信息数组
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-05-11 17:44:23
     */    
    public function sendRequestWithCustomContentType(string $url, array $data)
    {
        try {
            $headers = [
                'Content-Type' => $this->ContentType,
            ];
            $options = [];
            if ($this->ContentType == ContentType::application_json) {
                $options['headers'] = $headers;
                $data = json_encode($data);
                $options['body'] = $data;
                if (!empty($this->accessToken)) {
                    $options[$this->accessTokenKey] = $this->accessToken;
                }
            } elseif ($this->ContentType == ContentType::application_urlencoded) {
                $options['headers'] = $headers;
                if ($this->isAddUrlParams) {
                    $queryString = http_build_query($data);
                    $url = $queryString ? $url . (stripos($url, "?") !== false ? "&" : "?") . $queryString : $url;
                } else {
                    $options['form_params'] = $data;
                }
            }
            $response = $this->client->request('POST', $url, $options);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return ['code' => 0, 'msg' => $e->getMessage()];
        }
    }

    /**
     * 发送POST请求
     * @param string $url 请求URL
     * @param array $data POST数据
     * @return mixed API响应数据
     * @throws array
     */
    public function sendPostRequest(string $url, array $data)
    {
        try {
            $response = $this->client->request('POST', $url, ['form_params' => $data]);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return ['code' => 0, 'msg' => $e->getMessage()];
        }
    }

    /**
     * 发送GET请求
     * @param string $url 请求URL
     * @param array $data POST数据
     * @return mixed API响应数据
     * @throws array
     */
    public function sendGetRequest(string $url, array $data)
    {
        try {
            $response = $this->client->request('GET', $url, ['form_params' => $data]);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return ['code' => 0, 'msg' => $e->getMessage()];
        }
    }

    public function setVerify(bool $verify)
    {
        $this->verify = $verify;
    }

    public function setContentType($ContentType)
    {
        $this->ContentType = $ContentType;
    }

    public function setIsAddUrlParams($isAddUrlParams)
    {
        $this->isAddUrlParams = $isAddUrlParams;
    }

    public function setAccessToken($accessToken, $platform = Platform::DouYinMiniProgram)
    {
        $this->accessToken = $accessToken;
        $platformArr = AccessTokenKey::AccessTokenKeys();
        $this->accessTokenKey = isset($platformArr[$platform]) ? $platformArr[$platform] : AccessTokenKey::CommonAccessTokenKey;
    }
}
