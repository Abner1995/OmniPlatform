<?php
namespace Abner\Omniplatform\DouYin\MiniProgram;

use Abner\Omniplatform\DouYin\MiniProgram\Pay\Pay;
use Abner\Omniplatform\Platform\AbstractApplication;
use Abner\Omniplatform\DouYin\MiniProgram\Login\Login;
use Abner\Omniplatform\DouYin\MiniProgram\Auth\UserToken;
use Abner\Omniplatform\DouYin\MiniProgram\Order\OrderSync;
use Abner\Omniplatform\DouYin\MiniProgram\Auth\NoUserToken;
use Abner\Omniplatform\DouYin\MiniProgram\Auth\BusinessToken;
use Abner\Omniplatform\DouYin\MiniProgram\Locallife\Shop\Shop;
use Abner\Omniplatform\DouYin\MiniProgram\Locallife\Goods\Goods;
use Abner\Omniplatform\DouYin\MiniProgram\Locallife\Goods\Category;
use Abner\Omniplatform\DouYin\MiniProgram\SubscribeNotification\UrlQrcode;
use Abner\Omniplatform\DouYin\MiniProgram\SubscribeNotification\NotifyUser;
use Abner\Omniplatform\DouYin\MiniProgram\Operatedtrade\Pay as OperatedTradePay;

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

    public function getNoUserTokenService()
    {
        return new NoUserToken($this->config);
    }

    public function getUserTokenService()
    {
        return new UserToken($this->config);
    }

    public function getBusinessTokenService()
    {
        return new BusinessToken($this->config);
    }

    public function getNotifyUserService()
    {
        return new NotifyUser($this->config);
    }

    public function getUrlQrcodeService()
    {
        return new UrlQrcode($this->config);
    }

    public function getPayService($config = [])
    {
        if (!empty($config)) {
            $newconfig = array_merge($this->config, $config);
        }
        return new Pay($newconfig);
    }

    public function getOperatedTradePayService($config = [])
    {
        if (!empty($config)) {
            $newconfig = array_merge($this->config, $config);
        }
        return new OperatedTradePay($newconfig);
    }

    public function getGoodsService($config = [])
    {
        $config = !empty($config) ? array_merge($this->config, $config) : [];
        return new Goods($config);
    }

    public function getShopService($config = [])
    {
        $config = !empty($config) ? array_merge($this->config, $config) : [];
        return new Shop($config);
    }

    public function getCategoryService($config = [])
    {
        $config = !empty($config) ? array_merge($this->config, $config) : [];
        return new Category($config);
    }

    public function getOrderService($config = [])
    {
        if (!empty($config)) {
            $newconfig = array_merge($this->config, $config);
        }
        return new OrderSync($newconfig);
    }
}