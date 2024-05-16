<?php
namespace Abner\Omniplatform\Common\Log;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log
{
    /**
     * 记录日志
     * @param array $config 日志配置
     * @param array $logparams 日志配置
     * @return bool 
     */
    public static function addLog($config = [], $logparams = [])
    {
        if (!empty($config['log'])) {
            $logPath = isset($config['log']['file']) ? $config['log']['file'] : '';
            if (!empty($config['log']) && !empty($logPath)) {
                $name = isset($config['log']['name']) ? $config['log']['name'] : 'guzzle';
                $logLevel = isset($config['log']['level']) ? $config['log']['level'] : 'info';
                $logLevel = strtoupper($logLevel);
                $log = new Logger($name);
                $log->pushHandler(new StreamHandler($logPath, $logLevel));
                $log->addRecord(Logger::INFO, $name, $logparams);
            }
        }
    }
}
