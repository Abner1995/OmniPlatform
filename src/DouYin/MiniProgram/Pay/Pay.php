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
     * 预下单接口
     * @param string $app_id 必填 小程序APPID
     * @param string $out_order_no 必填 开发者侧的订单号。 只能是数字、大小写字母_-*且在同一个app_id下唯一
     * @param float $total_amount 必填 支付价格。单位为[分]
     * @param string $subject 必填 商品描述。 长度限制不超过 128 字节且不超过 42 字符
     * @param string $body 必填 商品详情 长度限制不超过 128 字节且不超过 42 字符
     * @param int $valid_time 必填 订单过期时间(秒)。最小5分钟，最大2天，小于5分钟会被置为5分钟，大于2天会被置为2天
     * @param string $sign 必填 签名
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-05-14 14:16:42
     */    
    public function pay($params = [])
    {
        if (empty($params['app_id'])) {
            return ['code' => 0, 'msg' => 'APPID不能为空'];
        }
        if (empty($params['out_order_no'])) {
            return ['code' => 0, 'msg' => 'out_order_no不能为空'];
        }
        if (!isset($params['total_amount']) || $params['total_amount'] <= 0) {
            return ['code' => 0, 'msg' => '订单金额错误'];
        }
        if (empty($params['subject'])) {
            return ['code' => 0, 'msg' => '商品描述不能为空'];
        }
        if (empty($params['body'])) {
            return ['code' => 0, 'msg' => '商品详情不能为空'];
        }
        $params['valid_time'] = isset($params['valid_time']) ? $params['valid_time'] : time() + 900;
        $params['notify_url'] = isset($params['notify_url']) ? $params['notify_url'] : (isset($this->config['notify_url']) ? $this->config['notify_url'] : "");
        $params['sign'] = $this->getSign($params);
        return $this->sendRequest(DouYinMiniProgramURLs::ecpay_create_order_full_URL, $params);
    }

    /**
     * 支付结果查询  
     * @param string $app_id 小程序APPID
     * @param string $out_order_no 开发者侧的订单号, 同一小程序下不可重复
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-05-14 14:03:23
     */  
    public function query($params = [])
    {
        if (empty($params['app_id'])) {
            return ['code' => 0, 'msg' => 'APPID不能为空'];
        }
        if (empty($params['out_order_no'])) {
            return ['code' => 0, 'msg' => 'out_order_no不能为空'];
        }
        $params['sign'] = $this->getSign($params);
        return $this->sendRequest(DouYinMiniProgramURLs::ecpay_query_order_full_URL, $params);
    }

    /**
     * 发起退款
     * @param string $app_id 必填 小程序APPID
     * @param string out_order_no 必填 商户分配支付单号，标识进行退款的订单
     * @param string out_refund_no 必填 商户分配退款号，保证在商户中唯一
     * @param array $reason  必填 退款原因
     * @param float $refund_amount 必填 退款金额，单位分
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-05-14 14:03:23
     */    
    public function refund($params = [])
    {
        if (empty($params['app_id'])) {
            return ['code' => 0, 'msg' => 'APPID不能为空'];
        }
        if (empty($params['out_order_no'])) {
            return ['code' => 0, 'msg' => 'out_order_no不能为空'];
        }
        if (empty($params['out_refund_no'])) {
            return ['code' => 0, 'msg' => 'out_refund_no不能为空'];
        }
        if (empty($params['reason'])) {
            return ['code' => 0, 'msg' => '退款原因不能为空'];
        }
        if (!isset($params['refund_amount']) || $params['refund_amount'] <= 0) {
            return ['code' => 0, 'msg' => '订单金额错误'];
        }
        $params['notify_url'] = isset($params['notify_url']) ? $params['notify_url'] : (isset($this->config['notify_url']) ? $this->config['notify_url'] : "");
        $params['sign'] = $this->getSign($params);
        return $this->sendRequest(DouYinMiniProgramURLs::ecpay_create_refund_URL, $params);
    }

    /**
     * 退款结果查询  
     * @param string $app_id 必填 小程序APPID
     * @param string $out_refund_no 商户退款单号
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-05-14 14:03:23
     */  
    public function queryRefund($params = [])
    {
        if (empty($params['app_id'])) {
            return ['code' => 0, 'msg' => 'APPID不能为空'];
        }
        if (empty($params['out_refund_no'])) {
            return ['code' => 0, 'msg' => 'out_refund_no不能为空'];
        }
        $params['sign'] = $this->getSign($params);
        return $this->sendRequest(DouYinMiniProgramURLs::ecpay_query_refund_full_URL, $params);
    }

    public function verify($params)
    {
        $result = false;
        $order = [];
        if (!empty($params)) {
            $order = json_decode($params, true);
            $order['msg'] = json_decode($order['msg'], true);
            $data = [
                $order['timestamp'],
                $order['nonce'],
                json_encode($order['msg']),
                $this->config['token'],
            ];
            sort($data, SORT_STRING);
            $str = implode('', $data);
            if (!strcmp(sha1($str), $order['msg_signature']) && !empty($order['msg_signature'])) {
                $result = true;
            }
            if ($result) return $order;
        }
        return [];
    }

    private function getSign($params)
    {
        $salt = isset($params['salt']) ? $params['salt'] : (isset($this->config['salt']) ? $this->config['salt'] : "");
        return Signature::sign($params, $salt);
    }

    private function sendRequest($url, $params = [])
    {
        $return = $this->httpClient->sendRequestWithCustomContentType($url, $params);
        return Response::result($return);
    }
}