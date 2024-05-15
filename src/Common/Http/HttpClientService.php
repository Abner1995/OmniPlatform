<?php
namespace Abner\Omniplatform\Common\Http;

use Monolog\Logger;
use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use Monolog\Handler\StreamHandler;
use GuzzleHttp\Exception\GuzzleException;
use Abner\Omniplatform\Common\Config\Platform;
use Abner\Omniplatform\DouYin\Common\APIVersion;
use Abner\Omniplatform\Common\Config\AccessTokenKey;
use Abner\Omniplatform\Common\Config\AuthorizationKey;

class HttpClientService
{
    private $client;
    private $config = [];
    private $platform = '';
    private $verify = false;
    private $accessToken = '';
    private $accessTokenKey = '';
    private $isAddUrlParams = true;
    private $ByteAuthorization = '';
    private $ByteAuthorizationKey = '';
    private $ContentType = ContentType::application_json;

    public function __construct($config = [])
    {
        $this->config = array_merge($this->config, $config);
        $stack = $this->setHandler();
        $configClient = [];
        $configClient['verify'] = $this->verify;
        if (!empty($stack)) {
            $configClient['handler'] = $stack;
        }
        $this->client = new Client($configClient);
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
            if (!empty($this->accessToken)) {
                $headers[$this->accessTokenKey] = $this->accessToken;
            }
            if (!empty($this->ByteAuthorization)) {
                $headers[$this->ByteAuthorizationKey] = $this->ByteAuthorization;
            }
            $options = [];
            if ($this->ContentType == ContentType::application_json) {
                $options['headers'] = $headers;
                $data = json_encode($data);
                $options['body'] = $data;
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
            if (!empty($response)) {
                return json_decode($response->getBody(), true);
            } else {
                return ['code' => 0, 'msg' => '请求失败'];
            }
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
            if (!empty($response)) {
                return json_decode($response->getBody(), true);
            } else {
                return ['code' => 0, 'msg' => '请求失败'];
            }
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
            if (!empty($response)) {
                return json_decode($response->getBody(), true);
            } else {
                return ['code' => 0, 'msg' => '请求失败'];
            }
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

    public function setPlatform($platform)
    {
        $this->platform = $platform;
    }

    public function setByteAuthorization($config, $sign, $timestamp, $str, $version = APIVersion::MINIPROGRAM_VERSION_2)
    {
        $this->ByteAuthorization = 'SHA256-RSA2048 appid="' . $config['app_id'] . '",nonce_str=' . $str . ',timestamp="' . $timestamp . '",key_version="' . $version . '",signature="' . $sign . '"';
        $platformArr = AuthorizationKey::AuthorizationKeys();
        $this->ByteAuthorizationKey = isset($platformArr[$this->platform]) ? $platformArr[$this->platform] : AuthorizationKey::CommonAuthorizationKey;
    }

    private function setHandler()
    {
        if (!empty($this->config['log'])) {
            $logPath = isset($this->config['log']['file']) ? $this->config['log']['file'] : '';
            if (!empty($this->config['log']) && !empty($logPath)) {
                $name = isset($this->config['log']['name']) ? $this->config['log']['name'] : 'guzzle';
                $logLevel = isset($this->config['log']['level']) ? $this->config['log']['level'] : 'info';
                $logLevel = strtoupper($logLevel);
                $log = new Logger($name);
                $log->pushHandler(new StreamHandler($logPath, $logLevel));
                $stack = HandlerStack::create();
                // '{req_headers} - {req_body} - {res_headers} - {res_body}'
                $stack->push(Middleware::log(
                    $log,
                    new \GuzzleHttp\MessageFormatter('{req_headers} - {req_body} - {res_headers} - {res_body}')
                ));
                return $stack;
            }
        }
        return false;
    }
}
