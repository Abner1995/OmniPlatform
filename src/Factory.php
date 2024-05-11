<?php
/**
 * @author: zuoyi
 * @Date: 2024-04-30 16:18:53
 * @Copyright: Copyright (c) 2013 - 2023, Iqi, Inc.
 * @Description: 微信、抖音SDK聚合类
 * @LastEditTime: 2024-04-30 16:24:11
 */
namespace Abner\Omniplatform;

/**
 * 微信、抖音SDK聚合类
 *
 * @author zuoyi
 */
class Factory
{
    public static function make(string $platform, string $module, array $config)
    {

        $applicationClass = "\\Abner\\Omniplatform\\{$platform}\\{$module}\\Application";
        return new $applicationClass($config);
    }
}
