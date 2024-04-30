<?php
namespace Abner\Omniplatform\Tests\DouYin\MiniProgram\Auth;

use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase
{
    public function testIndex()
    {
        $Auth = new \Abner\Omniplatform\DouYin\MiniProgram\Auth();
        $Auth->index();
    }
}