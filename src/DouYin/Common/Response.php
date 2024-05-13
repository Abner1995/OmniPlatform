<?php
namespace Abner\Omniplatform\DouYin\Common;

class Response
{
    public static function result($return = [])
    {
        if (isset($return['err_no']) && $return['err_no'] == 0) {
            return ['code' => 1, 'msg' => '获取成功', 'data' => !empty($return['data']) ? $return['data'] : []];
        } else {
            $msg = '错误码：' . (isset($return['err_no']) ? $return['err_no'] : '-1') . '，错误信息：' . (!empty($return['err_tips']) ? $return['err_tips'] : '获取失败');
            return ['code' => 0, 'msg' => $msg, 'data' => !empty($return['data']) ? $return['data'] : []];
        }
    }
}