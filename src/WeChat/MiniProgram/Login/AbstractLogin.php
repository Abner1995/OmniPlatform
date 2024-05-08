<?php
namespace Abner\Omniplatform\WeChat\MiniProgram\Login;

interface AbstractLogin
{
    public function login($code);
}