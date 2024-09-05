<?php
namespace Abner\Omniplatform\DouYin\MiniProgram\Locallife\Goods;

use Abner\Omniplatform\DouYin\Common\Response;
use Abner\Omniplatform\Common\Http\HttpClientService;
use Abner\Omniplatform\Common\Url\DouYin\MiniProgram\DouYinMiniProgramURLs;

class Category
{
    private $config;
    private $httpClient;

    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->httpClient = new HttpClientService();
    }

    /**
     * 查询商品品类
     * @param int $category_id 行业类目ID，返回当前id下的直系子类目信息；传0或者不传，均返回所有一级行业类目
     * @param int $account_id 服务商的入驻商户ID/代运营的商户ID，不传时默认为服务商身份​
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-05 14:22:39
     */
    public function getCategory($params = [])
    {
        $furl = DouYinMiniProgramURLs::getFullUrl(DouYinMiniProgramURLs::locallife_goods_category_get);
        return $this->sendRequest($furl, $params);
    }

    private function sendRequest($url, $params = [], $method = 'POST')
    {
        if (!empty($this->config['accessToken'])) {
            $this->httpClient->setAccessToken($this->config['accessToken']);
        }
        $return = $this->httpClient->sendRequestWithCustomContentType($url, $params, $method);
        return Response::result($return);
    }
}