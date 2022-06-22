<?php

namespace App\Http\Controllers;

use App\Models\ScriptTag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $user = auth()->user();
        if(!empty($user)){
            $scriptTag = ScriptTag::where('user_id',$user->id)->first();

            return view('home', compact('scriptTag'));

        }

        return view('welcome');
    }
}
