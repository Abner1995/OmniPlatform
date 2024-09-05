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

    // 本地服务
    // -- 商铺接入
    const locallife_shop_sync = '/poi/supplier/sync/';
    const locallife_shop_query = '/poi/supplier/query/';
    const locallife_shop_query_poi_id = '/poi/query/';
    // -- 商品库接入
    const locallife_goods_save = '/life/goods/product/save/';
    const locallife_goods_audit = '/life/goods/product/free_audit/';
    const locallife_goods_operate = '/life/goods/product/operate/';
    const locallife_goods_sync_stock = '/life/goods/stock/sync/';
    const locallife_goods_template_get = '/life/goods/template/get/';
    const locallife_goods_draft_get = '/life/goods/product/draft/get/';
    const locallife_goods_online_get = '/life/goods/product/online/get/';
    const locallife_goods_online_list = '/life/goods/product/online/list/';
    const locallife_goods_draft_list = '/life/goods/product/draft/list/';
    const locallife_goods_sku_save = '/life/goods/sku/batch_save/';
    const locallife_goods_category_get = '/life/goods/category/get/';

    // 交易系统
    // -- 生活服务交易系统（账号融合版）
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