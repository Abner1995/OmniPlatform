<?php
/**
 * @author: zuoyi
 * @Date: 2024-04-30 10:26:00
 * @Copyright: Copyright (c) 2013 - 2023, Iqi, Inc.
 * @Description: Do not edit
 * @LastEditTime: 2024-04-30 10:26:02
 */
namespace Abner\OmniPlatform;

use InvalidArgumentException;
use Abner\OmniPlatform\DouYin\MiniProgram\Auth;

class Factory
{
    public static function create($platform) {
        switch ($platform) {
            case 'DouYinMiniProgram':
                return new Auth();
            default:
                throw new InvalidArgumentException("Unsupported platform: $platform");
        }
    }
}