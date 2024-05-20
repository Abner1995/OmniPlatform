<?php
namespace Abner\Omniplatform\DouYin\MiniProgram\Order;

use Abner\Omniplatform\DouYin\Common\Response;
use Abner\Omniplatform\Common\Http\HttpClientService;
use Abner\Omniplatform\Common\Url\DouYin\MiniProgram\DouYinMiniProgramURLs;

class OrderSync
{
    private $config;
    private $httpClient;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->httpClient = new HttpClientService($config);
    }

    /**
     * 订单同步
     * @param string $access_token 必填 服务端 API 调用标识，通过 getAccessToken 获取
     * @param string $open_id 必填 小程序用户的 open_id
     * @param string $order_detail 必填 json string，根据不同订单类型有不同的结构体，请参见 order_detail 字段说明（json string）
     * @param string $order_detail.order_id 必填 开发者侧业务单号。用作幂等控制。该订单号是和担保支付的支付单号绑定的，也就是预下单时传入的 out_order_no 字段，长度 <= 64byte
     * @param int $order_detail.create_time 必填 订单创建的时间，13 位毫秒时间戳
     * @param string $order_detail.status 必填 订单状态，建议采用以下枚举值：待支付 已支付 已取消 已超时 已核销 退款中 已退款 退款失败
     * @param int $order_detail.amount 必填 订单商品总数
     * @param int $order_detail.total_price 必填 订单总价，单位为分
     * @param string $order_detail.detail_url 必填 小程序订单详情页 path，长度<=1024 byte (备注：该路径需要保证在小程序内配置过，相对路径即可）
     * @param string $order_detail.item_list 必填 子订单商品列表，不可为空
     * @param string $order_detail.item_list[0].item_code 必填 开发者侧商品 ID，长度 <= 64 byte
     * @param string $order_detail.item_list[0].img 必填 子订单商品图片 URL，长度 <= 512 byte
     * @param string $order_detail.item_list[0].title 必填 子订单商品介绍标题，长度 <= 256 byte
     * @param string $order_detail.item_list[0].sub_title 必填 子订单商品介绍副标题，长度 <= 256 byte
     * @param int $order_detail.item_list[0].amount 必填 单类商品的数目
     * @param int $order_detail.item_list[0].price 必填 单类商品的总价，单位为分
     * @param string $order_status 必填 注意：普通小程序订单必传，担保支付分账依赖该状态
     * @param int $order_type 必填 订单类型，枚举值: 0：普通小程序订单（非POI订单）;9101：团购券订单（POI 订单）;9001：景区门票订单（POI订单）
     * @param int $update_time 必填 订单信息变更时间，10 位秒级时间戳，
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-05-14 14:16:42
     */    
    public function push($params = [])
    {
        if (empty($params['access_token'])) {
            return ['code' => 0, 'msg' => 'access_token不能为空'];
        }
        if (empty($params['open_id'])) {
            return ['code' => 0, 'msg' => 'open_id不能为空'];
        }
        if (empty($params['order_detail'])) {
            return ['code' => 0, 'msg' => 'order_detail不能为空'];
        }
        $params['app_name'] = isset($params['app_name']) ? $params['app_name'] : 'douyin';
        $params['order_type'] = isset($params['order_type']) ? $params['order_type'] : 0;
        $params['update_time'] = isset($params['update_time']) ? $params['update_time'] : time();
        return $this->sendRequest(DouYinMiniProgramURLs::push_order_full_URL, $params);
    }

    /**
     * 订单同步异步推送
     * @param string $access_token 必填 服务端 API 调用标识，通过 getAccessToken 获取
     * @param string $open_id 必填 小程序用户的 open_id
     * @param string $order_detail 必填 json string，根据不同订单类型有不同的结构体，请参见 order_detail 字段说明（json string）
     * @param string $order_detail.order_id 必填 开发者侧业务单号。用作幂等控制。该订单号是和担保支付的支付单号绑定的，也就是预下单时传入的 out_order_no 字段，长度 <= 64byte
     * @param int $order_detail.create_time 必填 订单创建的时间，13 位毫秒时间戳
     * @param string $order_detail.status 必填 订单状态，建议采用以下枚举值：待支付 已支付 已取消 已超时 已核销 退款中 已退款 退款失败
     * @param int $order_detail.amount 必填 订单商品总数
     * @param int $order_detail.total_price 必填 订单总价，单位为分
     * @param string $order_detail.detail_url 必填 小程序订单详情页 path，长度<=1024 byte (备注：该路径需要保证在小程序内配置过，相对路径即可）
     * @param string $order_detail.item_list 必填 子订单商品列表，不可为空
     * @param string $order_detail.item_list[0].item_code 必填 开发者侧商品 ID，长度 <= 64 byte
     * @param string $order_detail.item_list[0].img 必填 子订单商品图片 URL，长度 <= 512 byte
     * @param string $order_detail.item_list[0].title 必填 子订单商品介绍标题，长度 <= 256 byte
     * @param string $order_detail.item_list[0].sub_title 必填 子订单商品介绍副标题，长度 <= 256 byte
     * @param int $order_detail.item_list[0].amount 必填 单类商品的数目
     * @param int $order_detail.item_list[0].price 必填 单类商品的总价，单位为分
     * @param string $order_status 必填 注意：普通小程序订单必传，担保支付分账依赖该状态
     * @param int $order_type 必填 订单类型，枚举值: 0：普通小程序订单（非POI订单）;9101：团购券订单（POI 订单）;9001：景区门票订单（POI订单）
     * @param int $update_time 必填 订单信息变更时间，10 位秒级时间戳，
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-05-14 14:16:42
     */
    public function pushAsync($params = [], $isreturn = false)
    {
        if (empty($params['access_token'])) {
            return ['code' => 0, 'msg' => 'access_token不能为空'];
        }
        if (empty($params['open_id'])) {
            return ['code' => 0, 'msg' => 'open_id不能为空'];
        }
        if (empty($params['order_detail'])) {
            return ['code' => 0, 'msg' => 'order_detail不能为空'];
        }
        $params['app_name'] = isset($params['app_name']) ? $params['app_name'] : 'douyin';
        $params['order_type'] = isset($params['order_type']) ? $params['order_type'] : 0;
        $params['update_time'] = isset($params['update_time']) ? $params['update_time'] : time();
        return $this->sendRequestAsync(DouYinMiniProgramURLs::push_order_full_URL, $params, $isreturn);
    }

    private function sendRequest($url, $params = [])
    {
        $this->httpClient->setAccessToken($this->config['accessToken']);
        $return = $this->httpClient->sendRequestWithCustomContentType($url, $params);
        return Response::result($return);
    }

    private function sendRequestAsync($url, $params = [], $isreturn = false)
    {
        $this->httpClient->setAccessToken($this->config['accessToken']);
        $return = $this->httpClient->sendRequestWithCustomContentTypeAsync($url, $params, $isreturn);
        return $isreturn ? $return : '';
    }
}