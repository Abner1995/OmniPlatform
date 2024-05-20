<?php
namespace Abner\Omniplatform\Tests;

use Abner\Omniplatform\Factory;
use PHPUnit\Framework\TestCase;
use Abner\Omniplatform\Common\Http\HttpClientService;

/**
 * 测试案例  
 *   
 * D:\wwwroot\OmniPlatform> vendor/bin/phpunit --filter testWeChatOpenPlatform .\tests\DemoTest.php  
 * 
 * @author zuoyi
 */
class DemoTest extends TestCase
{

    public function testHttpClient()
    {
        $config = [
            'appid' => 'xxxx',
            'secret' => 'xxxx',
            'log' => [
                'name' => 'omniplatform',
                'level' => 'debug',
                'file' => './wechat' . date("Y-m-d") . '.log',
            ]
        ];
        $httpClient = new HttpClientService($config);
        // $return = $httpClient->sendPostRequest('https://www.baidu.com', [
        //     'a'=>1,
        //     'n'=>1,
        // ]);
        $return = $httpClient->sendRequestWithCustomContentTypeAsync('https://www.baidu.com', [
            'a'=>1,
            'n'=>1,
        ]);
        echo "111";
        echo "\r\n";
        print_r($return);die;
    }

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
            'log' => [
                'name' => 'omniplatform',
                'level' => 'debug',
                'file' => './wechat.log',
            ]
        ];
        $app = Factory::make('WeChat', 'MiniProgram', $config);
        // Token操作
        $code = 0;
        $grant_type = 'authorization_code';
        $return = $app->getLoginService($config)->login($code, $grant_type);
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
        // $return = $app->getLoginService()->login($code, $grant_type);
        $pconfig = [
            'test' => 'xxxx',
            'test99' => 'xxxx',
            'log' => [
                'name' => 'omniplatform',
                'level' => 'debug',
                'file' => './wechat' . date("Y-m-d") . '.log',
            ]
        ];
        $params = [
            '1' => '2'
        ];
        $app = $app->getPayService($pconfig);
        // $return->Pay($config);
        $return = $app->verify($params);
        print_r($return);
        echo "\r\n";
    }
}