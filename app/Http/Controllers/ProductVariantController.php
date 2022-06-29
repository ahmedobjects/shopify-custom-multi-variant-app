<?php

namespace App\Http\Controllers;

use App\Http\Traits\ShopifyStoreTrait;
use App\Models\ScriptTag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Throwable;

class ProductVariantController extends Controller
{
    use ShopifyStoreTrait;

    public function index(Request $request){
        $params = $request->all();
        $token = isset($params['token']) ? $params['token'] : null;
        $shop = isset($params['shop']) ? $params['shop'] : null;
        $productId = isset($params['product_id']) ? $params['product_id'] : null;
        $user = User::where('name',$shop)->first();

        if(!empty($token) && !empty($shop) && !empty($productId) && decryptStoreName($token) == $shop && !empty($user) && $user->is_active){
            $storeLink = getStoreFullUrl($user->name);
            $accessToken =  $user->password;
            $shopifyStore = $this->shopifyStore($storeLink, $accessToken);
            $result = [];
            try {
                $product = $shopifyStore->Product($productId)->get();
                $shop = $shopifyStore->Shop()->get();
                $data['product'] = $product;
                $data['props'] = [
                    'is_active' => $user->is_active,
                    'money_with_currency_format' => $shop['money_with_currency_format'] ,
                    'money_format' => $shop['money_format']
                ];
                $result['data'] = $data;
                return $result;
            } catch (Throwable $e) {
               return [];
            }
        }
        return [];
    }
}
