<?php

namespace App\Http\Controllers;

use App\Http\Traits\ShopifyStoreTrait;
use App\Models\ScriptTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Throwable;

class ScriptTagController extends Controller
{
    use ShopifyStoreTrait;

    public function store(Request $request){
        // dd(route('script-tag.url'));
        $user = auth()->user();
        
        if($user){
            $storeLink = getStoreFullUrl($user->name);
            $accessToken =  $user->password;
            $shopifyStore = $this->shopifyStore($storeLink, $accessToken);

            $args = [
                'src' => env('SHOPIFY_APP_URI')."/script-tag/url",
                // 'src' => route('script-tag.url'),
                'event' => "onload",
            ];

            $result = $shopifyStore->ScriptTag()->post($args);

            if(isset($result['id'])){
                $scriptTag = new ScriptTag;
                $scriptTag->script_tag_id = $result['id'];
                $scriptTag->user_id = $user->id;
                $scriptTag->src = isset($result['src']) ? $result['src'] : "";
                $scriptTag->event = isset($result['event']) ? $result['event'] : "";
                $scriptTag->display_scope = isset($result['display_scope']) ? $result['display_scope'] : "";
                $scriptTag->cache = isset($result['cache']) ? $result['cache'] : "";
                $scriptTag->save();
            }else{
                // validation_error
                // some thing wrong during creation the script tag
            }
        }else{
            // validation_error
            // there is not logged in user
        }

        
    }

    public function destroy($id){
        $scriptTag = ScriptTag::findOrFail($id);
        $user = auth()->user();
        if(!empty($user) && !empty($scriptTag) && $user->id == $scriptTag->user_id){
            $storeLink = getStoreFullUrl($user->name);
            $accessToken =  $user->password;
            $shopifyStore = $this->shopifyStore($storeLink, $accessToken);

            try {
                $result = $shopifyStore->ScriptTag($scriptTag->script_tag_id)->delete();
                $deletedRows = ScriptTag::where('id',$id)->delete();
                echo "script tag deleted successfully";
                // Validate the value...
            } catch (Throwable $e) {
                // dd($e);
                // echo $e['message'];
                echo "error";
                return false;
            }

        }else{
            // validation_error
            // there is not logged in user
        }
    }

    public function scriptUrl(Request $request){
        $script_file = FacadesFile::get(public_path('/js/script-tag.js'));
        $shop = $request->query('shop');
        $token = encryptStoreName($shop);
        $script_file = Str::replace('TOKEN_PLACEHOLDER', $token, $script_file);
        $script_file = Str::replace('SHOP_PLACEHOLDER', $shop, $script_file);
        return $script_file;
    }
}
