<?php
namespace Abner\Omniplatform\Tests;

use Abner\Omniplatform\Factory;
use PHPUnit\Framework\TestCase;

class OperatedTradePayTest extends TestCase
{
    /**
     * 发起下单  
     * PS D:\wwwroot\OmniPlatform> vendor/bin/phpunit --filter testPay .\tests\OperatedTradePayTest.php
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-02 11:33:25
     */    
    public function testPay()
    {
        $config = [
            'appid' => 'tt445932e4db69198f01',
            'secret' => '502816e21ea2ca78d18cfe58b706ea241fde92f8',
        ];
        $app = Factory::make('DouYin', 'MiniProgram', $config);
        $pay = $app->getOperatedTradePayService($config);
        $p = json_encode(['id' => 6034]);
        $data = [
            'goods_list' => [
                'goods_image' => '',
                'goods_title' => '',
                'price' => 10 * 100,
                'quantity' => 1,
                'goods_id' => 1,
                'goods_id_type' => 1,
            ],
            'open_id' => '_00022mS6_LoXClbkZSf8w-Rjwc7A07WJU2F',
            'out_order_no' => '202408302483095290478521',
            'total_amount' => 10 * 100,
            'order_entry_schema' => [
                'path' => 'pages/petservices/servicesorder/details',
                'params' => $p,
            ],
            'pay_expire_seconds' => 500,
            'pay_notify_url' => 'https://aichongchong.com/api/v1/callback/notify/type/toutiao'
        ];
        $res = $pay->pay($data);
        print_r($res);
        echo "\r\n";
        // 关闭下单
        $data = [
            'order_id' => '1-Rjwc7A07WJU2F',
        ];
        $res = $pay->closeOrder($data);
        print_r($res);
        echo "\r\n";
    }

    /**
     * 关闭下单  
     * PS D:\wwwroot\OmniPlatform> vendor/bin/phpunit --filter testCloseOrder .\tests\OperatedTradePayTest.php
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-02 11:33:25
     */    
    public function testCloseOrder()
    {
        $config = [
            'appid' => 'tt445932e4db69198f01',
            'secret' => '502816e21ea2ca78d18cfe58b706ea241fde92f8',
        ];
        $app = Factory::make('DouYin', 'MiniProgram', $config);
        $pay = $app->getOperatedTradePayService($config);
        $data = [
            'order_id' => '1',
        ];
        $res = $pay->closeOrder($data);
        print_r($res);
        echo "\r\n";
    }

    /**
     * 查询订单信息  
     * PS D:\wwwroot\OmniPlatform> vendor/bin/phpunit --filter testQueryOrder .\tests\OperatedTradePayTest.php
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-02 11:33:25
     */    
    public function testQueryOrder()
    {
        $config = [
            'appid' => 'tt445932e4db69198f01',
            'secret' => '502816e21ea2ca78d18cfe58b706ea241fde92f8',
        ];
        $app = Factory::make('DouYin', 'MiniProgram', $config);
        $pay = $app->getOperatedTradePayService($config);
        $data = [
            'order_id' => '1',
        ];
        $res = $pay->queryOrder($data);
        print_r($res);
        echo "\r\n";
    }

    /**
     * 发起退款  
     * PS D:\wwwroot\OmniPlatform> vendor/bin/phpunit --filter testRefund .\tests\OperatedTradePayTest.php
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-02 11:33:25
     */    
    public function testRefund()
    {
        $config = [
            'appid' => 'tt445932e4db69198f01',
            'secret' => '502816e21ea2ca78d18cfe58b706ea241fde92f8',
        ];
        $app = Factory::make('DouYin', 'MiniProgram', $config);
        $pay = $app->getOperatedTradePayService($config);
        $p = json_encode(['id' => 6034]);
        $data = [
            'out_order_no' => '1',
            'out_refund_no' => '2',
            'order_entry_schema' => [
                'path' => 'pages/petservices/servicesorder/details',
                'params' => $p,
            ],
            'item_order_detail' => [
                'item_order_id' => '1',
                'refund_amount' => 1 * 100,
            ],
            'refund_total_amount' => 1 * 100,
        ];
        $res = $pay->refund($data);
        print_r($res);
        echo "\r\n";
    }

    /**
     * 查询退款  
     * PS D:\wwwroot\OmniPlatform> vendor/bin/phpunit --filter testQueryRefund .\tests\OperatedTradePayTest.php
     * @return array
     * @author: zuoyi <wan19950504@outlook.com>
     * @Date: 2024-09-02 11:33:25
     */    
    public function testQueryRefund()
    {
        $config = [
            'appid' => 'tt445932e4db69198f01',
            'secret' => '502816e21ea2ca78d18cfe58b706ea241fde92f8',
        ];
        $app = Factory::make('DouYin', 'MiniProgram', $config);
        $pay = $app->getOperatedTradePayService($config);
        $p = json_encode(['id' => 6034]);
        $data = [
            'refund_id' => '1',
            'out_refund_no' => '2',
            'order_id' => '3',
        ];
        $res = $pay->queryRefund($data);
        print_r($res);
        echo "\r\n";
    }
}