<?php
namespace Abner\Omniplatform\Tests\DouYin\MiniProgram\Auth;

use Abner\Omniplatform\Factory;
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    public function testIndex()
    {
        $app = Factory::make('WeChat', [
            'app_id' => 'app_id',
            'app_secret' => 'app_secret',
        ]);
        return $app->getLoginService()->login(1);
    }
}