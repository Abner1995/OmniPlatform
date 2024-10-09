<?php
namespace Abner\Omniplatform\DouYin\Common;

class Response
{
    public static function result($return = [])
    {
        $code = 0;
        if (isset($return['err_no']) && $return['err_no'] == 0) {
            $code = 1;
        }
        // 兼容抖音订单同步
        if (isset($return['err_code']) && $return['err_code'] == 0) {
            $code = 1;
        }
        // 兼容抖音获取应用授权调用凭证
        if (isset($return['data']) && !empty($return['data']) && isset($return['data']['error_code']) && $return['data']['error_code'] == 0) {
            $code = 1;
        }
        $data = !empty($return['data']) ? $return['data'] : [];
        $extra = !empty($return['extra']) ? $return['extra'] : [];

        if ($code == 1) {
            $msg = '获取成功';
        } else {
            $err_no = '-1';
            $err_tips = '获取失败';
            if (isset($return['err_no'])) {
                $err_no = $return['err_no'];
            }
            if (isset($return['err_code'])) {
                $err_no = $return['err_code'];
            }
            if (isset($return['data']['error_code'])) {
                $err_no = $return['data']['error_code'];
            }
            if (isset($return['err_tips'])) {
                $err_tips = $return['err_tips'];
            }
            if (isset($return['msg'])) {
                $err_tips = $return['msg'];
            }
            if (isset($return['err_msg'])) {
                $err_tips = $return['err_msg'];
            }
            if (isset($return['data']['description'])) {
                $err_tips = $return['data']['description'];
            }
            // 副错误信息
            if (isset($return['extra']['sub_error_code'])) {
                $err_no .= '，sub：' . $return['extra']['sub_error_code'];
            }
            if (isset($return['extra']['sub_description'])) {
                $err_tips .= $return['extra']['sub_description'];
            }
            // 兼容抖音生活服务/商品库接入/查询商品线上数据
            if (isset($return['base']['gateway_code'])) {
                $err_no .= '，gateway_code：' . $return['base']['gateway_code'];
            }
            if (isset($return['base']['gateway_msg'])) {
                $err_tips .= $return['base']['gateway_msg'];
            }
            $msg = '错误码：' . $err_no . '，错误信息：' . $err_tips;
        }
        return ['code' => $code, 'msg' => $msg, 'data' => $data];
    }
}