<?php
namespace Abner\Omniplatform\DouYin\MiniProgram\Locallife\Shop;

use Abner\Omniplatform\DouYin\Common\Response;
use Abner\Omniplatform\Common\Http\HttpClientService;
use Abner\Omniplatform\Common\Url\DouYin\MiniProgram\DouYinMiniProgramURLs;

class Shop
{
    private $config;
    private $httpClient;

    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->httpClient = new HttpClientService();
    }

    /**
     * 同步店铺信息
     * @param string $supplier_ext_id 接入方店铺id
     * @param string $name 店铺名称
     * @param string $poi_id 抖音poi id, 三方如果使用高德poi id可以通过/poi/query/接口转换，其它三方poi id走poi匹配功能进行抖音poi id获取
     * @param mixed $attributes 店铺属性字段，编号规则：垂直行业 1xxx-酒店民宿 2xxx-餐饮 3xxx-景区 通用属性-9yxxx
     * @param string $type 店铺类型 1 - 酒店民宿 2 - 餐饮 3 - 景区 4 - 电商 5 - 教育 6 - 丽人 7 - 爱车 8 - 亲子 9 - 宠物 10 - 家装 11 - 娱乐场所 12 - 图文快印
     * @param int $status 在线状态 1 - 在线; 2 - 下线
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-05 14:22:39
     */
    public function syncShop($params = [])
    {
        if (empty($params['supplier_ext_id'])) {
            return ['code' => 0, 'msg' => '店铺id不能为空'];
        }
        if (empty($params['name'])) {
            return ['code' => 0, 'msg' => '店铺名称不能为空'];
        }
        if (empty($params['poi_id'])) {
            return ['code' => 0, 'msg' => '抖音POIid不能为空'];
        }
        if (empty($params['attributes'])) {
            return ['code' => 0, 'msg' => '订单详情页跳转路径不能为空'];
        }
        $params['type'] = !empty($params['type']) ? $params['type'] : 9;
        $params['status'] = !empty($params['status']) ? $params['status'] : 1;
        $furl = DouYinMiniProgramURLs::getFullUrl(DouYinMiniProgramURLs::locallife_shop_sync);
        return $this->sendRequest($furl, $params);
    }

    /**
     * 查询店铺
     * @param string $supplier_ext_id 接入方店铺id
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-05 14:22:39
     */
    public function queryShop($params = [])
    {
        if (empty($params['supplier_ext_id'])) {
            return ['code' => 0, 'msg' => '店铺id不能为空'];
        }
        $furl = DouYinMiniProgramURLs::getFullUrl(DouYinMiniProgramURLs::locallife_shop_query);
        return $this->sendRequest($furl, $params);
    }

    /**
     * 获取抖音POIID
     * @param string $amap_id 
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-05 14:22:39
     */
    public function queryShopPoiId($params = [])
    {
        if (empty($params['amap_id'])) {
            return ['code' => 0, 'msg' => 'amap_id不能为空'];
        }
        $furl = DouYinMiniProgramURLs::getFullUrl(DouYinMiniProgramURLs::locallife_shop_query_poi_id);
        return $this->sendRequest($furl, $params);
    }

    private function sendRequest($url, $params = [])
    {
        if (!empty($this->config['accessToken'])) {
            $this->httpClient->setAccessToken($this->config['accessToken']);
        }
        $return = $this->httpClient->sendRequestWithCustomContentType($url, $params);
        return Response::result($return);
    }
}