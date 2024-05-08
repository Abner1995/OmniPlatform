<?php
/**
 * @author: zuoyi
 * @Date: 2024-04-30 10:40:05
 * @Copyright: Copyright (c) 2013 - 2023, Iqi, Inc.
 * @Description: 微信小程序URL
 * @LastEditTime: 2024-04-30 10:46:27
 */
namespace Abner\Omniplatform\Common\Url\WeChat\MiniProgram;

/**
 * 微信小程序URL
 *
 * @author zuoyi
 */
class WeChatMiniProgramURLs
{
    const WeChat_BASE_URL = 'https://api.weixin.qq.com';
    
    const JSCODE2SESSION_URL = self::WeChat_BASE_URL . '/sns/jscode2session';
}