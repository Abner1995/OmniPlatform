<?php
namespace Abner\Omniplatform\Douyin\MiniProgram\Login;

interface AbstractLogin
{
    public function login($code);
}