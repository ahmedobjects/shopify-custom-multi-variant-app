<?php

namespace App\Http\Controllers;

use App\Http\Traits\ShopifyStoreTrait;
use App\Models\ScriptTag;
use Illuminate\Http\Request;

class AppConfigController extends Controller
{
    use ShopifyStoreTrait;

    public function toggleActivity($id){
        $user = auth()->user();
        if(!empty($user) && !empty($id) && $user->id == $id){
            $is_active = $user->is_active;

            if($is_active){
                $user->is_active = false;
            }else{
                $user->is_active = true;
            }

            $user->save();
            return redirect("/home");

        }
        return redirect("/");
    }

}
