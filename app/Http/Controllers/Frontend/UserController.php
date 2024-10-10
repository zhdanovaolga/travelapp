<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SubscribedUser;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index($username) {
        $user = User::where("status", true)->where("username", $username)->first();
        if ($user) {
            return view("frontend.user.index", compact("user", "posts"));
        }
        return abort(404);
    }


    public function subscribe(Request $request) 
    {
        $subscribed_user = SubscribedUser::create([
            "user_id" => Auth::user()->id,
            "favorite_user_id" => $request->input('subscribed_user_id'),
       ])->first();

        $subscribed_user->save();

        return redirect()->back();
    }


    public function unsubscribe(Request $request) 
    {
        $subscribed_user = SubscribedUser::where([
            "user_id" => Auth::user()->id,
            "favorite_user_id" => $request->input('subscribed_user_id'),
       ])->first();
      
       
        $subscribed_user->delete();
         
        return redirect()->back();


    }

}
