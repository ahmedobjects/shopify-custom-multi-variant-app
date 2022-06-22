<?php
namespace App\Http\Traits;

use PHPShopify\ShopifySDK;

trait ShopifyStoreTrait {

    public function shopifyStore($shop, $accessToken) {
        $config = array(
            'ShopUrl' => $shop,
            'AccessToken' => $accessToken
        );

        return new ShopifySDK($config);
    }
}