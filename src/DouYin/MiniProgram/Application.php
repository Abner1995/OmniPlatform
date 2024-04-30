<?php
namespace Abner\Omniplatform\Douyin\MiniProgram;


use Abner\Omniplatform\Douyin\MiniProgram\Login\Login;
use Abner\Omniplatform\Platform\MiniProgram\AbstractApplication;

class Application extends AbstractApplication
{
    public function __construct(array $config)
    {
        parent::__construct($config);
    }
    
    public function getLoginService(): Login
    {
        return new Login($this->config);
    }
}