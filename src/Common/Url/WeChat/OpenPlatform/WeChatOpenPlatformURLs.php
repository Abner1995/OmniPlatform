<?php
/**
 * @author: zuoyi
 * @Date: 2024-04-30 10:40:05
 * @Copyright: Copyright (c) 2013 - 2023, Iqi, Inc.
 * @Description: 微信开发平台URL
 * @LastEditTime: 2024-04-30 10:46:27
 */
namespace Abner\Omniplatform\Common\Url\WeChat\OpenPlatform;

/**
 * 微信开发平台URL
 *
 * @author zuoyi
 */
class WeChatOpenPlatformURLs
{
    const WeChatOpenPlatform_BASE_URL = 'https://api.weixin.qq.com';
    
    const access_token_URL = self::WeChatOpenPlatform_BASE_URL . '/sns/oauth2/access_token';
    const refresh_token_URL = self::WeChatOpenPlatform_BASE_URL . '/sns/oauth2/refresh_token';
    const check_token_URL = self::WeChatOpenPlatform_BASE_URL . '/sns/auth';
    const userinfo_URL = self::WeChatOpenPlatform_BASE_URL . '/sns/userinfo';
}