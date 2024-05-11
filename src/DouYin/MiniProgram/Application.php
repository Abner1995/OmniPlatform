<?php
namespace Abner\Omniplatform\DouYin\MiniProgram;

use Abner\Omniplatform\Platform\AbstractApplication;
use Abner\Omniplatform\DouYin\MiniProgram\Login\Login;

class Application extends AbstractApplication
{
    public function __construct(array $config)
    {
        parent::__construct($config);
    }
    
    public function getLoginService()
    {
        return new Login($this->config);
    }
}