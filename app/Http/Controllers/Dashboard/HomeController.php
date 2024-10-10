<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Journey;

class HomeController extends Controller
{
    public function index() {
       
        $journies = Journey::count();
       
        $users = User::count();
        return view("dashboard.home.index", compact( "journies", "users"));
    }
}
