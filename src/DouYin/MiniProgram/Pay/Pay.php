<?php
namespace Abner\Omniplatform\DouYin\MiniProgram\Pay;

use Abner\Omniplatform\Common\Config\Platform;
use Abner\Omniplatform\Common\Http\HttpMethod;
use Abner\Omniplatform\DouYin\Common\Response;
use Abner\Omniplatform\DouYin\Common\Signature;
use Abner\Omniplatform\Common\Http\HttpClientService;
use Abner\Omniplatform\Common\Url\DouYin\MiniProgram\DouYinMiniProgramURLs;

class Pay
{
    private $config;
    private $httpClient;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->httpClient = new HttpClientService();
    }

    /**
     * 开发者发起下单
     * @param array $params 支付信息
     * @param array $params.goods_list 商品信息
     * @param array $params.goods_list[0]['goods_image'] 商品图片链接，长度<=512byte 注意：非POI商品必传
     * @param array $params.goods_list[0]['goods_title'] 商品数量 商品标题/商品名称，长度 <= 256 byte 注意：非 POI 商品必传
     * @param array $params.goods_list[0]['quantity'] 商品数量
     * @param array $params.goods_list[0]['goods_id'] 商品id
     * @param array $params.goods_list[0]['goods_id_type'] 商品id类别:POI商品传1;非POI商品传2 
     * @param array $params.open_id  必填 用户OpenID
     * @param array $params.out_order_no 用户 必填 开发者的单号，长度<=64byte
     * @param array $params.order_entry_schema  必填 退款单的跳转的 schema
     * @param string $params.order_entry_schema.path 必填 订单详情页路径，没有前导的/，该字段不能为空，长度 <= 512byte
     * @param string $params.order_entry_schema.params 选填 路径参数，自定义的 json 结构，序列化成字符串存入该字段，平台不限制，
     * 是写入的内容需要能够保证生成访问订单详情的 schema 能正确跳转到小程序内部的订单详情页，长度 <= 512byte
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-05-14 14:16:42
     */    
    public function pay($params = [])
    {
        if (empty($params['goods_list'])) {
            return ['code' => 0, 'msg' => '商品信息不能为空'];
        }
        if (!isset($params['total_amount']) || $params['total_amount'] <= 0) {
            return ['code' => 0, 'msg' => '订单金额错误'];
        }
        if (empty($params['open_id'])) {
            return ['code' => 0, 'msg' => 'open_id不能为空'];
        }
        if (empty($params['out_order_no'])) {
            return ['code' => 0, 'msg' => 'out_order_no不能为空'];
        }
        if (empty($params['order_entry_schema']['path'])) {
            return ['code' => 0, 'msg' => '退款单的跳转的 schema不能为空'];
        }
        return $this->sendRequest(HttpMethod::POST_METHOD, DouYinMiniProgramURLs::create_order_full_URL, DouYinMiniProgramURLs::create_order_URL, $params);
    }

    /**
     * 查询订单信息  
     * order_id,out_order_no 二选一，不能都不选。优先级：out_order_no>order_id
     * @param string $order_id 抖音开放平台内部交易订单号，通过预下单回调传给开发者服务，长度 < 64byte
     * @param string $out_order_no 开发者系统生成的订单号，与唯一order_id关联，长度 < 64byte
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-05-14 14:03:23
     */  
    public function query($params = [])
    {
        if (empty($params['order_id']) && empty($params['out_order_no'])) {
            return ['code' => 0, 'msg' => '参数不能为空'];
        }
        return $this->sendRequest(HttpMethod::POST_METHOD, DouYinMiniProgramURLs::query_order_full_URL, DouYinMiniProgramURLs::query_order_URL, $params);
    }

    /**
     * 开发者发起退款
     * @param array $params 退款信息
     * @param string $params.out_order_no 必填 开发者侧订单号，长度 <= 64 byte
     * @param string $params.out_refund_no 必填 开发者侧退款单号，长度 <= 64 byte
     * @param array $params.order_entry_schema  必填 退款单的跳转的 schema
     * @param string $params.order_entry_schema.path 必填 订单详情页路径，没有前导的/，该字段不能为空，长度 <= 512byte
     * @param string $params.order_entry_schema.params 选填 路径参数，自定义的 json 结构，序列化成字符串存入该字段，平台不限制，但是写入的内容需要能够保证生成访问订单详情的 schema 能正确跳转到小程序内部的订单详情页，长度 <= 512byte
     * @param array $params.item_order_detail  必填 需要发起退款的商品单信息，数组长度<100
     * @param string $params.item_order_detail.item_order_id  必填 商品单号，参见通用参数-重要 ID 字段说明
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-05-14 14:03:23
     */    
    public function refund($params = [])
    {
        if (empty($params['out_order_no'])) {
            return ['code' => 0, 'msg' => '订单号不能为空'];
        }
        if (empty($params['out_refund_no'])) {
            return ['code' => 0, 'msg' => '订单号不能为空'];
        }
        if (empty($params['order_entry_schema']['path'])) {
            return ['code' => 0, 'msg' => '退款单的跳转的 schema不能为空'];
        }
        if (empty($params['item_order_detail']['item_order_id'])) {
            return ['code' => 0, 'msg' => '商品单信息不能为空'];
        }
        return $this->sendRequest(HttpMethod::POST_METHOD, DouYinMiniProgramURLs::create_refund_full_URL, DouYinMiniProgramURLs::create_refund_URL, $params);
    }

    /**
     * 查询退款  
     * refund_id,out_refund_no,order_id 三选一，不能都不选。优先级：refund_id>out_refund_no>order_id
     * @param string $refund_id 抖音开平内部交易退款单号，长度 <=  64byte
     * @param string $out_refund_no 开发者系统生成的退款单号，长度 <=  64byte
     * @param array $order_id 抖音开平内部交易订单号， 长度 <=  64byte
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-05-14 14:03:23
     */  
    public function queryRefund($params = [])
    {
        return $this->sendRequest(HttpMethod::POST_METHOD, DouYinMiniProgramURLs::query_refund_full_URL, DouYinMiniProgramURLs::query_refund_URL, $params);
    }

    /**
     * 同步退款审核结果  
     * @param string $out_refund_no 必填 开发者侧退款单号，长度 <= 64 byte
     * @param int $refund_audit_status 必填 审核状态 1：同意退款 2：不同意退款
     * @param string $deny_message 不同意退款信息(不同意退款时必填)，长度 <= 512 byte
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-05-14 14:03:23
     */  
    public function auditRefund($params = [])
    {
        return $this->sendRequest(HttpMethod::POST_METHOD, DouYinMiniProgramURLs::audit_refund_full_URL, DouYinMiniProgramURLs::audit_refund_URL, $params);
    }

    public function verify($http_body, $timestamp, $nonce_str, $sign)
    {
        if (empty($this->config['public_key_url'])) return null;
        $data = $timestamp . "\n" . $nonce_str . "\n" . $http_body . "\n";
        $publicKey = file_get_contents($this->config['public_key_url']);
        if (!$publicKey) {
            return null;
        }
        $res = openssl_get_publickey($publicKey);
        $result = (bool)openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
        openssl_free_key($res);
        return $result;
    }

    private function sendRequest($method = HttpMethod::POST_METHOD, $fullurl, $url, $params = [])
    {
        $timestamp = microtime(true);
        $timestamp = floor($timestamp * 1000);
        $str = substr(md5($timestamp), 5, 15);
        $body = json_encode($params);
        $sign = Signature::makeSign($this->config, $method, $url, $body, $timestamp, $str);
        $this->httpClient->setPlatform(Platform::DouYinMiniProgram);
        $this->httpClient->setByteAuthorization($this->config, $sign, $timestamp, $str);
        $return = $this->httpClient->sendRequestWithCustomContentType($fullurl, $params);
        return Response::result($return);
    }
}