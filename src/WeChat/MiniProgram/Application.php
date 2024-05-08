<?php
namespace Abner\Omniplatform\WeChat\MiniProgram;

use Abner\Omniplatform\WeChat\MiniProgram\Login\Login;
use Abner\Omniplatform\Platform\MiniProgram\AbstractApplication;

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