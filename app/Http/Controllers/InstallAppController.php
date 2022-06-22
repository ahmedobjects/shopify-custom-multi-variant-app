<?php

namespace App\Http\Controllers;

// use App\Models\ShopifyStore;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPShopify\ShopifySDK;

class InstallAppController extends Controller
{
    public $api_key;
    public $api_secret_key;

    public function __construct() {
        $this->api_key = env('SHOPIFY_API_KEY');
        $this->api_secret_key = env('SHOPIFY_API_SECRET_KEY');
    }

    public function appLoginPreInstall(Request $request){
        $data = $request->all();
        $shop=$data['shop'];

        $scopes_from_db=DB::table('scopes')->pluck('scope_name')->toArray();
        $scopes=implode(',',$scopes_from_db);

        $redirect_uri = env('SHOPIFY_APP_URI')."/generate_token"; //replace  ngrok url for your domain
        $install_url = "https://".$shop. "/admin/oauth/authorize?client_id=".$this->api_key."&scope=".$scopes."&redirect_uri=".urlencode($redirect_uri);
        return redirect($install_url);
    }

    public function generateToken(Request $request){
        $data=$request->all();
        $result = $this->sendHttpRequestToGenerateData($data);

        if(isset($data['shop']) && $result['access_token']){
            $user = User::where('email',"shop@".$data['shop'])->where('password', $result['access_token'])->first();

            if(!$user){
                $user = new User;
                $user->name = $data['shop'];
                $user->email = "shop@".$data['shop'];
                $user->password = $result['access_token'];
                $user->save();

            }

            Auth::login($user);
            if(auth()->user()){
                $config = array(
                    'ShopUrl' => getStoreFullUrl($user->name),
                    'AccessToken' => $user->password
                );
                $shopify = new ShopifySDK($config);
                return redirect("/home");
            }
        }

        return redirect("/");
    }

    public function sendHttpRequestToGenerateData($data){
        $params = $data; // Retrieve all request parameters
        $hmac = $params['hmac']; // Retrieve HMAC request parameter
        $params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
        ksort($params); // Sort params lexographically
        $computed_hmac = hash_hmac('sha256', http_build_query($params), $this->api_secret_key );
        // Use hmac data to check that the response is from Shopify or not
       if (hash_equals($hmac, $computed_hmac)) {
            // Set variables for our request
            $query = array(
                "client_id" => $this->api_key, // Your API key
                "client_secret" => $this->api_secret_key, // Your app credentials (secret key)
                "code" => $params['code'] // Grab the access key from the URL
            );
            // Generate access token URL
            $access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";
            // Configure curl client and execute request
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $access_token_url);
            curl_setopt($ch, CURLOPT_POST, count($query));
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
            $result = curl_exec($ch);
            curl_close($ch);
            // Store the access token
            $result = json_decode($result, true);
            return $result;
            // $result=array_merge($result,['shop'=>$params['shop']]);
            // dd($result);
        }
    }

    public function unInstallApp(Request $request){
        // $revoke_url = "https://".$shop."/admin/api_permissions/current.json";
        $revoke_url = $this->store."/admin/api_permissions/current.json";
        $headers = array(
            "Content-Type: application/json",
            "Accept: application/json",
            "Content-Length: 0",
            "X-Shopify-Access-Token: " . $this->access_token);
            // "X-Shopify-Access-Token: " . $access_token);

        $handler = curl_init($revoke_url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handler, CURLOPT_HTTPHEADER, $headers);
        curl_exec($handler);
        if (!curl_errno($handler)) {
            $info = curl_getinfo($handler);
            // $info['http_code'] == 200 for success
            }
        curl_close($handler);
    }

    public function shopify_instance(){
        // $store= Store::where('id',$this->store)->first();
        $config = array(
            'ShopUrl' => $this->store,
            'AccessToken' => $this->access_token
        );
        return  new ShopifySDK($config);
    }

    public function products(){
        // $shopify = $this->shopify_instance();
        // // dd($shopify);
        // // dd($shopify,$shopify->Shop()->get());
        // // dd($shopify,$shopify->Product()->get());

        // for ($i=350; $i < 401 ; $i++) {
        //     $args = [
        //         'title' => "Brakes Foot Child $i",
        //         'status' => "active",
        //         'variants' => [ ["price" => 33 ,'inventory_quantity' => 23 , "inventory_management" => "shopify"] ]
                

        //     ];
        //     $result = $shopify->Product()->post($args);
        //     // echo $i;
        //     // var_dump($result);
        //     dump($result);
        //     // dd($result);
        //     // break;
        // }
        
    }
}
