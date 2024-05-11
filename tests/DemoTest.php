<?php
namespace Abner\Omniplatform\Tests;

use Abner\Omniplatform\Factory;
use PHPUnit\Framework\TestCase;

/**
 * 测试案例  
 *   
 * D:\wwwroot\OmniPlatform> vendor/bin/phpunit --filter testWeChatOpenPlatform .\tests\DemoTest.php  
 * 
 * @author zuoyi
 */
class DemoTest extends TestCase
{
    /**
     * 测试微信小程序
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-05-11 08:40:27
     */  
    public function testWeChatMiniProgram()
    {
        echo "\r\n";
        echo "微信小程序";
        echo "\r\n";
        $config = [
            'appid' => 'xxxx',
            'secret' => 'xxxx',
        ];
        $app = Factory::make('WeChat', 'MiniProgram', $config);
        // Token操作
        $code = 0;
        $grant_type = 'authorization_code';
        $return = $app->getLoginService()->login($code, $grant_type);
        print_r($return);
        echo "\r\n";
    }

    /**
     * 测试微信开发平台
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-05-11 08:40:27
     */    
    public function testWeChatOpenPlatform()
    {
        echo "\r\n";
        echo "微信开发平台";
        echo "\r\n";
        $config = [
            'appid' => 'xxxx',
            'secret' => 'xxxx',
        ];
        $app = Factory::make('WeChat', 'OpenPlatform', $config);
        // Token操作
        $code = 0;
        $return = $app->getTokenService()->accessToken($code);
        print_r($return);
        echo "\r\n";
    }

    /**
     * 测试抖音小程序
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-05-11 08:40:27
     */  
    public function testDouYinMiniProgram()
    {
        echo "\r\n";
        echo "抖音小程序";
        echo "\r\n";
        $config = [
            'appid' => 'xxxx',
            'secret' => 'xxxx',
        ];
        $app = Factory::make('DouYin', 'MiniProgram', $config);
        // Token操作
        $code = 0;
        $grant_type = 'authorization_code';
        $return = $app->getLoginService()->login($code, $grant_type);
        print_r($return);
        echo "\r\n";
    }
}