<?php

namespace App\Http\Controllers;

use App\Models\ScriptTag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        if(!empty($user)){
            $scriptTag = ScriptTag::where('user_id',$user->id)->first();
            return view('home',compact('scriptTag', 'user'));
        }
        return view('welcome');
    }
}
