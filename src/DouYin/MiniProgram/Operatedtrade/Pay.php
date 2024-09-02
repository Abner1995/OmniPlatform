<?php
namespace Abner\Omniplatform\DouYin\MiniProgram\Operatedtrade;

use Abner\Omniplatform\DouYin\Common\Response;
use Abner\Omniplatform\Common\Http\HttpClientService;
use Abner\Omniplatform\Common\Url\DouYin\MiniProgram\DouYinMiniProgramURLs;

class Pay
{
    private $config;
    private $httpClient;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->httpClient = new HttpClientService($config);
    }

    /**
     * 发起下单  
     * @param array $params 参数
     * @param array $params.goods_list 商品信息，详情见字段描述
     * @param string $params.goods_list.goods_image 商品图片链接，长度 <= 512 byte 注意：非 POI 商品必传
     * @param string $params.goods_list.goods_title 商品标题/商品名称，长度 <= 256 byte 注意：非 POI 商品必传
     * @param string $params.goods_list.price 商品价格，单位（分）注意：非 POI 商品必传
     * @param string $params.goods_list.quantity 商品数量
     * @param string $params.goods_list.goods_id 商品id
     * @param string $params.goods_list.goods_id_type 商品 id 类别，POI 商品传 1 非 POI 商品传 2
     * @param string $params.open_id 用户OpenID
     * @param string $params.out_order_no 开发者的单号，长度 <= 64 byte
     * @param float $params.total_amount 订单总价，单位分
     * @param array $params.order_entry_schema 订单详情页信息，详情见字段描述
     * @param string $params.order_entry_schema.path 订单详情页跳转路径，没有前导的“/”，长度 <= 512byte pages/xxxindexxx
     * @param string $params.order_entry_schema.params 订单详情页路径参数，自定义的 json 结构，序列化成字符串存入该字段，平台不限制，但是写入的内容需要能够保证生成访问订单详情的 schema 能正确跳转到小程序内部的订单详情页，长度 <= 512byte {\"id\":\"xxxxxx\"}
     * @param int $params.pay_expire_seconds 支付超时时间，单位秒，例如 300 表示 300 秒后过期；不传或传 0 会使用默认值 300，最大不能超过48小时。
     * @param string $params.pay_notify_url 支付结果通知地址，必须是 HTTPS 类型。若不填，默认使用在行业模板配置-消息通知的支付结果通知地址。
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-02 09:19:43
     */    
    public function pay($params = [])
    {
        if (empty($params['open_id'])) {
            return ['code' => 0, 'msg' => '用户OpenID不能为空'];
        }
        if (empty($params['out_order_no'])) {
            return ['code' => 0, 'msg' => 'out_order_no不能为空'];
        }
        if (!isset($params['total_amount']) || $params['total_amount'] <= 0) {
            return ['code' => 0, 'msg' => '订单金额错误'];
        }
        if (empty($params['order_entry_schema'])) {
            return ['code' => 0, 'msg' => '订单详情页跳转路径不能为空'];
        }
        $params['pay_expire_seconds'] = isset($params['pay_expire_seconds']) ? $params['pay_expire_seconds'] : 300;
        $params['pay_notify_url'] = isset($params['pay_notify_url']) ? $params['pay_notify_url'] : (isset($this->config['pay_notify_url']) ? $this->config['pay_notify_url'] : "");
        $furl = DouYinMiniProgramURLs::getFullUrl(DouYinMiniProgramURLs::operatedtrade_create_order);
        return $this->sendRequest($furl, $params);
    }

    /**
     * 关闭下单  
     * @param array $params 参数
     * @param string $params.order_id 抖音开平内部交易订单号，通过预下单回调传给开发者服务，长度 < 64byte
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-02 09:19:43
     */    
    public function closeOrder($params = [])
    {
        if (empty($params['order_id'])) {
            return ['code' => 0, 'msg' => 'order_id不能为空'];
        }
        $furl = DouYinMiniProgramURLs::getFullUrl(DouYinMiniProgramURLs::operatedtrade_close_order);
        return $this->sendRequest($furl, $params);
    }

    /**
     * 查询订单信息  
     * order_id 与 out_order_no 二选一。  
     * @param array $params 参数
     * @param string $params.order_id 抖音开平内部交易订单号，通过预下单回调传给开发者服务，长度 < 64byte
     * @param string $params.out_order_no 开发者系统生成的订单号，与唯一order_id关联，长度 < 64byte
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-02 09:19:43
     */    
    public function queryOrder($params = [])
    {
        if (empty($params['order_id']) && empty($params['out_order_no'])) {
            return ['code' => 0, 'msg' => 'order_id或out_order_no不能为空'];
        }
        $furl = DouYinMiniProgramURLs::getFullUrl(DouYinMiniProgramURLs::operatedtrade_query_order);
        return $this->sendRequest($furl, $params);
    }

    /**
     * 发起退款  
     * @param array $params 参数
     * @param string $params.out_order_no 开发者侧订单号，长度 <= 64 byte
     * @param string $params.out_refund_no 开发者侧退款单号，长度 <= 64 byte
     * @param array $params.order_entry_schema 退款单的跳转的 schema
     * @param string $params.order_entry_schema.path 订单详情页路径，没有前导的/，该字段不能为空，长度 <= 512byte pages/indexx
     * @param string $params.order_entry_schema.params 路径参数，自定义的 json 结构，序列化成字符串存入该字段，平台不限制，但是写入的内容需要能够保证生成访问订单详情的 schema 能正确跳转到小程序内部的订单详情页，长度 <= 512byte {\"id\":\"cx\"}
     * @param array $params.item_order_detail 需要发起退款的商品单信息，数组长度<100 注意：交易系统订单必传
     * @param string $params.item_order_detail.item_order_id 商品单号，参见通用参数-重要 ID 字段说明说明
     * @param array $params.item_order_detail.refund_amount 该item_order需要退款的金额，单位分，不能大于该item_order实付金额且要大于0需要指定 item_order 的退款金额，需要申请开通指定金额退款权限才能使用
     * @param int $params.refund_total_amount 款总金额，单位分 担保交易订单必传 交易系统订单该字段不生效
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-02 09:19:43
     */    
    public function refund($params = [])
    {
        if (empty($params['out_order_no'])) {
            return ['code' => 0, 'msg' => 'out_order_no不能为空'];
        }
        if (empty($params['out_refund_no'])) {
            return ['code' => 0, 'msg' => 'out_refund_no不能为空'];
        }
        if (empty($params['order_entry_schema'])) {
            return ['code' => 0, 'msg' => '路径不能为空'];
        }
        $params['notify_url'] = isset($params['notify_url']) ? $params['notify_url'] : (isset($this->config['notify_url']) ? $this->config['notify_url'] : "");
        $furl = DouYinMiniProgramURLs::getFullUrl(DouYinMiniProgramURLs::operatedtrade_create_refund);
        return $this->sendRequest($furl, $params);
    }

    /**
     * 查询退款  
     * @param array $params 参数
     * @param string $params.refund_id 抖音开平内部交易退款单号，长度 <=  64byte
     * @param string $params.out_refund_no 开发者系统生成的退款单号，长度 <=  64byte
     * @param array $params.order_id 抖音开平内部交易订单号，长度 <=  64byte
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-02 09:19:43
     */    
    public function queryRefund($params = [])
    {
        if (empty($params['refund_id']) && empty($params['out_refund_no']) && empty($params['order_id'])) {
            return ['code' => 0, 'msg' => 'out_order_no不能为空'];
        }
        $furl = DouYinMiniProgramURLs::getFullUrl(DouYinMiniProgramURLs::operatedtrade_query_refund);
        return $this->sendRequest($furl, $params);
    }

    private function sendRequest($url, $params = [])
    {
        $return = $this->httpClient->sendRequestWithCustomContentType($url, $params);
        return Response::result($return);
    }
}