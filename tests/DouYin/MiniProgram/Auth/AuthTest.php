<?php
namespace Abner\OmniPlatform\Tests\DouYin\MiniProgram\Auth;

use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase
{
    public function testIndex()
    {
        echo "DouYin_MiniProgram_Auth_Test";
        $Auth = new \Abner\OmniPlatform\DouYin\MiniProgram\Auth();
        $Auth->index();
    }
}