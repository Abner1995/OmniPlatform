<?php

namespace Abner\Omniplatform\Common\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HttpClientService
{
    private $client;
    private $verify = false;
    private $ContentType = 'application/json';

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
            if ($this->ContentType == 'application/json') {
                $data = json_encode($data);
            }
            $response = $this->client->request('POST', $url, [
                'headers' => $headers,
                'body' => $data,
            ]);
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
}
