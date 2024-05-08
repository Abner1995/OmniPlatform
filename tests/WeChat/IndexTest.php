<?php
namespace Abner\Omniplatform\Tests\WeChat;

use PHPUnit\Framework\TestCase;
use Abner\Omniplatform\WeChat\Decrypt\wxBizDataCrypt;

class IndexTest extends TestCase
{
    public function testIndex()
    {
        $app = new wxBizDataCrypt(1,1);
        return $app->decryptData(1, 1, 1);
    }
}