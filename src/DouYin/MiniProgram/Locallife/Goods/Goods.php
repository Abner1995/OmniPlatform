<?php
namespace Abner\Omniplatform\DouYin\MiniProgram\Locallife\Goods;

use Abner\Omniplatform\DouYin\Common\Response;
use Abner\Omniplatform\Common\Http\HttpClientService;
use Abner\Omniplatform\Common\Url\DouYin\MiniProgram\DouYinMiniProgramURLs;

class Goods
{
    private $config;
    private $httpClient;

    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->httpClient = new HttpClientService();
    }

    /**
     * 创建/修改团购商品
     * @param array $product 商品
     * @param string $product.product_id 商品Id，创建时不必填写，更新时如有 out_id 可不填写​
     * @param string $product.out_id 外部商品id​
     * @param string $product.product_name 商品名
     * @param string $product.category_full_name 品类全名，保存时不必填写​
     * @param int $product.category_id 品类id​​
     * @param int $product.product_type 商品类型：​1:团购套餐​;3:预售券;​4:日历房;5:门票;7:旅行跟拍;8:一日游;11:代金券;​14:x项目;​
     * @param int $product.biz_line 业务线：​1:闭环自研开发者;3:直连服务商;5:小程序;
     * @param string $product.account_name 商家名
     * @param array $product.poi_list 店铺列表​
     * @param int $product.poi_list.supplier_ext_id 接入方店铺id，保存时必传​
     * @param array $sku 售卖单元​​
     * @param string $sku.sku_id sku id，创建时不必填写​
     * @param string $sku.sku_name sku名​
     * @param string $sku.origin_amount 原价，团购创建时如有commodity属性可不填，会根据菜品搭配计算原价​
     * @param string $sku.actual_amount 实际支付价格​​
     * @param array $sku.stock 库存信息​
     * @param int $sku.stock.limit_type 库存上限类型，为2时stock_qty和avail_qty字段无意义 1-有限库存 2-无限库存​
     * @param int $sku.stock.stock_qty 总库存，limit_type=2时无意义​​
     * @param int $sku.out_sku_id 第三方id​
     * @param int $sku.status 状态。1：在线 ； 默认传1​
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-05 14:22:39
     */
    public function saveGoods($params = [])
    {
        if (empty($params['product'])) {
            return ['code' => 0, 'msg' => '商品不能为空'];
        }
        if (empty($params['sku'])) {
            return ['code' => 0, 'msg' => 'sku不能为空'];
        }
        $params['sku']['status'] = !empty($params['sku']['status']) ? $params['sku']['status'] : 1;
        $furl = DouYinMiniProgramURLs::getFullUrl(DouYinMiniProgramURLs::locallife_goods_save);
        return $this->sendRequest($furl, $params);
    }

    /**
     * 免审修改商品
     * @param string $product_id 商品id (商品id或商品外部id 选其一）
     * @param string $out_id 商品外部id (商品id或商品外部id 选其一）​
     * @param int $sold_end_time 售卖结束时间
     * @param int $stock_qty 总库存
     * @param string $owner_account_id 商品归属账户ID，非必传；传入时须与该商家满足商服关系​​
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-05 14:22:39
     */
    public function auditGoods($params = [])
    {
        if (empty($params['product_id']) && empty($params['out_id'])) {
            return ['code' => 0, 'msg' => '商品id不能为空'];
        }
        $furl = DouYinMiniProgramURLs::getFullUrl(DouYinMiniProgramURLs::locallife_goods_audit);
        return $this->sendRequest($furl, $params);
    }

    /**
     * 上下架商品
     * @param string $product_id 商品id (商品id或商品外部id 选其一）
     * @param string $out_id 商品外部id (商品id或商品外部id 选其一）​
     * @param int $op_type 1-上线 2-下线
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-05 14:22:39
     */
    public function operateGoods($params = [])
    {
        if (empty($params['product_id']) && empty($params['out_id'])) {
            return ['code' => 0, 'msg' => '商品id不能为空'];
        }
        $params['op_type'] = !empty($params['op_type']) ? $params['op_type'] : 1;
        $furl = DouYinMiniProgramURLs::getFullUrl(DouYinMiniProgramURLs::locallife_goods_operate);
        return $this->sendRequest($furl, $params);
    }

    /**
     * 同步库存
     * @param string $product_id 商品id (商品id或商品外部id 选其一）
     * @param string $out_id 商品外部id (商品id或商品外部id 选其一）​
     * @param array $stock 库存信息​
     * @param int $stock.limit_type 库存上限类型，为2时stock_qty和avail_qty字段无意义 1-有限库存 2-无限库存​
     * @param int $stock.stock_qty 总库存，limit_type=2时无意义​
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-05 14:22:39
     */
    public function syncStock($params = [])
    {
        if (empty($params['product_id']) && empty($params['out_id'])) {
            return ['code' => 0, 'msg' => '商品id不能为空'];
        }
        $params['op_type'] = !empty($params['op_type']) ? $params['op_type'] : 1;
        $furl = DouYinMiniProgramURLs::getFullUrl(DouYinMiniProgramURLs::locallife_goods_sync_stock);
        return $this->sendRequest($furl, $params);
    }

    /**
     * 查询商品模板
     * @param int $category_id 行业类目；详细见；
     * @param int $product_type 商品类型 1:团购套餐;3:预售券;4:日历房;5:门票;7:旅行跟拍;8:一日游;11:代金券;
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-05 14:22:39
     */
    public function getTemplate($params = [])
    {
        if (empty($params['category_id'])) {
            return ['code' => 0, 'msg' => '行业类目不能为空'];
        }
        if (empty($params['product_type'])) {
            return ['code' => 0, 'msg' => '商品类型不能为空'];
        }
        $furl = DouYinMiniProgramURLs::getFullUrl(DouYinMiniProgramURLs::locallife_goods_template_get);
        return $this->sendRequest($furl, $params, 'GET');
    }

    /**
     * 查询商品草稿数据
     * @param string $product_ids 商品ID列表（逗号分隔）
     * @param string $out_ids 外部商品ID列表（逗号分隔）
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-05 14:22:39
     */
    public function getDraft($params = [])
    {
        if (empty($params['category_id']) && empty($params['out_ids'])) {
            return ['code' => 0, 'msg' => '商品ID不能为空'];
        }
        $furl = DouYinMiniProgramURLs::getFullUrl(DouYinMiniProgramURLs::locallife_goods_draft_get);
        return $this->sendRequest($furl, $params, 'GET');
    }

    /**
     * 查询商品线上数据
     * @param string $product_ids 商品ID列表（逗号分隔）
     * @param string $out_ids 外部商品ID列表（逗号分隔）
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-05 14:22:39
     */
    public function getOnline($params = [])
    {
        $furl = DouYinMiniProgramURLs::getFullUrl(DouYinMiniProgramURLs::locallife_goods_online_get);
        return $this->sendGetQueryRequest($furl, $params);
    }

    /**
     * 查询商品线上数据列表
     * @param string $cursor 第一页不传，之后用前一次返回的next_cursor传入进行翻页
     * @param int $count 分页数量，不传默认为5
     * @param int $status 过滤在线状态 1-在线 2-下线 3-封禁
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-05 14:22:39
     */
    public function listOnline($params = [])
    {
        $furl = DouYinMiniProgramURLs::getFullUrl(DouYinMiniProgramURLs::locallife_goods_online_list);
        return $this->sendRequest($furl, $params, 'GET');
    }

    /**
     * 查询商品草稿数据列表
     * @param string $cursor 第一页不传，之后用前一次返回的next_cursor传入进行翻页
     * @param int $count 分页数量，不传默认为5
     * @param int $status 过滤在线状态 1-在线 2-下线 3-封禁
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-05 14:22:39
     */
    public function listDraft($params = [])
    {
        $furl = DouYinMiniProgramURLs::getFullUrl(DouYinMiniProgramURLs::locallife_goods_draft_list);
        return $this->sendRequest($furl, $params, 'GET');
    }

    /**
     * 创建/更新多SKU商品的SKU列表
     * @param string $product_id 商品id
     * @param string $out_id 商品外部id
     * @param array $sku_list SKU列表
     * @param string $sku_list.sku_id sku id，创建时不必填写​
     * @param string $sku_list.sku_name sku名​​
     * @param string $sku_list.origin_amount 原价，团购创建时可不填，会根据商品搭配计算原价​
     * @param string $sku_list.actual_amount 实际支付价格​
     * @param array $sku_list.stock 库存信息​​
     * @param int $sku_list.stock.limit_type 库存上限类型，为2时stock_qty和avail_qty字段无意义 1-有限库存 2-无限库存​
     * @param int $sku_list.stock.stock_qty 总库存，limit_type=2时无意义​
     * @param string $sku_list.out_sku_id 第三方id​
     * @param int $sku_list.status 状态 1-在线 -1-删除​
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-05 14:22:39
     */
    public function saveSku($params = [])
    {
        if (empty($params['product_id']) && empty($params['out_id'])) {
            return ['code' => 0, 'msg' => '商品不能为空'];
        }
        if (empty($params['sku_list'])) {
            return ['code' => 0, 'msg' => 'sku不能为空'];
        }
        $params['sku_list']['status'] = !empty($params['sku_list']['status']) ? $params['sku_list']['status'] : 1;
        $furl = DouYinMiniProgramURLs::getFullUrl(DouYinMiniProgramURLs::locallife_goods_sku_save);
        return $this->sendRequest($furl, $params);
    }

    private function sendGetQueryRequest($url, $params = [])
    {
        $return = $this->httpClient->sendGetQueryRequest($url, $params);
        return Response::result($return);
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