<?php
namespace Abner\Omniplatform\Common\Config;

class AuthorizationKey
{
    const CommonAuthorizationKey = 'Authorization';
    const DouYinMiniProgramAuthorizationKey = 'Byte-Authorization';

    public static function AuthorizationKeys()
    {
        $platformArr = [Platform::DouYinMiniProgram => self::DouYinMiniProgramAuthorizationKey];
        return $platformArr;
    }
}
