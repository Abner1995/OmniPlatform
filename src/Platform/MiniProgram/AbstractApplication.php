<?php
namespace Abner\Omniplatform\Platform\MiniProgram;

use Abner\Omniplatform\Douyin\MiniProgram\Login\AbstractLogin;


abstract class AbstractApplication
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    abstract public function getLoginService(): AbstractLogin;
}