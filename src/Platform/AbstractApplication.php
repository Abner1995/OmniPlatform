<?php
namespace Abner\Omniplatform\Platform;

abstract class AbstractApplication
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }
}