<?php

namespace Abner\Omniplatform\Common\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HttpClientService
{
    private $client;
    private $verify = false;

    public function __construct()
    {
        $config = [
            'verify' => $this->verify,
        ];
        $this->client = new Client($config);
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
}
