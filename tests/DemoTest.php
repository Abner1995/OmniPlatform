<?php
namespace Abner\Omniplatform\Tests;

use Abner\Omniplatform\Factory;
use PHPUnit\Framework\TestCase;

class DemoTest extends TestCase
{
    public function testIndex()
    {
        echo "\r\n";
        echo "微信小程序";
        echo "\r\n";
        // 微信小程序
        $app = Factory::make('WeChat', 'MiniProgram', []);
        $a = $app->getLoginService()->login(0);
        print_r($a);
        echo "\r\n";
        echo "微信开发平台";
        echo "\r\n";
        // 微信开发平台
        $app = Factory::make('WeChat', 'OpenPlatform', []);
        // $a = $app->getTokenService()->accessToken(0);
        $a = $app->getTokenService()->userinfo(0, 0);
        print_r($a);
        echo "\r\n";
    }
}