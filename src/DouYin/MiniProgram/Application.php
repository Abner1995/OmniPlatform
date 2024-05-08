<?php
namespace Abner\Omniplatform\Douyin\MiniProgram;


use Abner\Omniplatform\Douyin\MiniProgram\Login\Login;
use Abner\Omniplatform\Platform\AbstractApplication;

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