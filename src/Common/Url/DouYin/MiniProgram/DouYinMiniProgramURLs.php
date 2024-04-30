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
    // https://developer.toutiao.com/api/apps/v2/jscode2session
    const DouYin_BASE_URL = 'https://open-sandbox.douyin.com';
    // https://open-sandbox.douyin.com/api/apps/v2/jscode2session
    const DouYin_sandbox_URL = 'https://open-sandbox.douyin.com';
    
    const JSCODE2SESSION_URL = self::DouYin_BASE_URL . '/api/apps/v2/jscode2session';
    const JSCODE2SESSION_sandbox_URL = self::DouYin_sandbox_URL . '/api/apps/v2/jscode2session';
}