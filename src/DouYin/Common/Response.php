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
            $msg = '错误码：' . $err_no . '，错误信息：' . $err_tips;
        }
        return ['code' => $code, 'msg' => $msg, 'data' => $data];
    }
}