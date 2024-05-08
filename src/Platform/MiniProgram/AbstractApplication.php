<?php
namespace Abner\Omniplatform\Platform\MiniProgram;

abstract class AbstractApplication
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    abstract public function getLoginService();
}