<?php
namespace Abner\Omniplatform\WeChat\OpenPlatform;

use Abner\Omniplatform\WeChat\OpenPlatform\Auth\Token;
use Abner\Omniplatform\Platform\AbstractApplication;

class Application extends AbstractApplication
{
    public function __construct(array $config)
    {
        parent::__construct($config);
    }
    
    public function getTokenService()
    {
        return new Token($this->config);
    }
}