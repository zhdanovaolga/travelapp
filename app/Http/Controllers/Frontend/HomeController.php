<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Journey;
class HomeController extends Controller
{
    public function index() {
        $journies = Journey::with(["user"])->orderBy("id", "DESC")->paginate(20);

        if ($journies) {
            return view("frontend.home.index", compact("journies"));
        }
        return abort(404);
    }
}
