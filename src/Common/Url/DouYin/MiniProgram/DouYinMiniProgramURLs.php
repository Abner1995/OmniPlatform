<?php
/**
 * @author: zuoyi
 * @Date: 2024-04-30 10:40:05
 * @Copyright: Copyright (c) 2013 - 2023, Iqi, Inc.
 * @Description: 抖音小程序URL
 * @LastEditTime: 2024-04-30 10:46:27
 */
namespace Abner\Omniplatform\Common\Url\DouYin\MiniProgram;

/**
 * 抖音小程序URL
 *
 * @author zuoyi
 */
class DouYinMiniProgramURLs
{
    const DouYin_BASE_URL = 'https://open-sandbox.douyin.com';
    const DouYin_sandbox_URL = 'https://open-sandbox.douyin.com';
    
    const JSCODE2SESSION_URL = self::DouYin_BASE_URL . '/api/apps/v2/jscode2session';
    const JSCODE2SESSION_sandbox_URL = self::DouYin_sandbox_URL . '/api/apps/v2/jscode2session';

    const nouser_client_token_URL = 'https://open.douyin.com/oauth/client_token';
    const nouser_token_URL = 'https://developer.toutiao.com/api/apps/v2/token';

    const user_access_token_URL = 'https://open.douyin.com/oauth/access_token';
    const user_refresh_token_URL = 'https://open.douyin.com/oauth/refresh_token';
    const user_renew_refresh_token_URL = 'https://open.douyin.com/oauth/renew_refresh_token';

    const business_access_token_URL = 'https://open.douyin.com/oauth/business_token';
    const business_refresh_token_URL = 'https://open.douyin.com/oauth/refresh_biz_token';
    const business_scopes_URL = 'https://open.douyin.com/oauth/business_scopes';

    const notify_user_URL = 'https://open.douyin.com/api/notification/v2/subscription/notify_user/';

    const generate_schema_URL = 'https://open.douyin.com/api/apps/v1/url/generate_schema/';
    const query_schema_URL = 'https://open.douyin.com/api/apps/v1/url/query_schema/';
    const query_schema_quota_URL = 'https://open.douyin.com/api/apps/v1/url/query_schema_quota/';

    const generate_url_link_URL = 'https://open.douyin.com/api/apps/v1/url_link/generate/';
    const query_url_link_URL = 'https://open.douyin.com/api/apps/v1/url_link/query_info/';
    const query_url_link_quota_URL = 'https://open.douyin.com/api/apps/v1/url_link/query_quota/';

    const create_qrcode_URL = 'https://open.douyin.com/api/apps/v1/qrcode/create/';

    const create_order_URL = '/api/apps/trade/v2/order/create_order';
    const create_order_full_URL = 'https://open.douyin.com/api/apps/trade/v2/order/create_order';
    const query_order_URL = '/api/apps/trade/v2/order/query_order';
    const query_order_full_URL = 'https://open.douyin.com/api/apps/trade/v2/order/query_order';

    const create_refund_URL = '/api/apps/trade/v2/refund/create_refund';
    const create_refund_full_URL = 'https://open.douyin.com/api/apps/trade/v2/refund/create_refund';
    const audit_refund_URL = '/api/apps/trade/v2/refund/merchant_audit_callback';
    const audit_refund_full_URL = 'https://open.douyin.com/api/apps/trade/v2/refund/merchant_audit_callback';
    const query_refund_URL = '/api/apps/trade/v2/refund/query_refund';
    const query_refund_full_URL = 'https://open.douyin.com/api/apps/trade/v2/refund/query_refund';

    const ecpay_create_order_URL = '/api/apps/ecpay/v1/create_order';
    const ecpay_create_order_full_URL = 'https://developer.toutiao.com/api/apps/ecpay/v1/create_order';
    const ecpay_query_order_URL = '/api/apps/ecpay/v1/query_order';
    const ecpay_query_order_full_URL = 'https://developer.toutiao.com/api/apps/ecpay/v1/query_order';

    const ecpay_create_refund_URL = '/api/apps/ecpay/v1/create_refund';
    const ecpay_create_refund_full_URL = 'https://developer.toutiao.com/api/apps/ecpay/v1/create_refund';
    const ecpay_query_refund_URL = '/api/apps/ecpay/v1/query_refund';
    const ecpay_query_refund_full_URL = 'https://developer.toutiao.com/api/apps/ecpay/v1/query_refund';

    const push_order_full_URL = 'https://developer.toutiao.com/api/apps/order/v2/push';
    
    
    const DouYin_Base_URL = 'https://open.douyin.com';

    const operatedtrade_create_order = '/api/apps/trade/v2/order/create_order';
    const operatedtrade_close_order = '/api/apps/trade/v2/order/close_order';
    const operatedtrade_query_order = '/api/apps/trade/v2/order/query_order';
    const operatedtrade_create_refund = '/api/apps/trade/v2/refund/create_refund';
    const operatedtrade_query_refund = '/api/apps/trade/v2/refund/query_refund';

    /**
     * 获取完整的URL
     * @param string $url
     * @return string
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-02 09:29:33
     */    
    public static function getFullUrl($url)
    {
        return self::DouYin_Base_URL . $url;
    }
}