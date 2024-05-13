<?php
namespace Abner\Omniplatform\Common\Config;

class AccessTokenKey
{
    const CommonAccessTokenKey = 'accesstoken';
    const DouYinMiniProgramAccessTokenKey = 'access-token';

    public static function AccessTokenKeys()
    {
        $platformArr = [Platform::DouYinMiniProgram => self::DouYinMiniProgramAccessTokenKey];
        return $platformArr;
    }
}
