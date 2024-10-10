<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Journey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class JourneyController extends Controller
{
    public function index() {
        $journies = Journey::with(["user"])->orderBy("id", "DESC")->paginate(20);
        return view("dashboard.journey.index", compact("journies"));
    }

    public function create() {
        return view("dashboard.journey.add");
    }

    public function store(Request $request) {
        $validated = $request->validate([
            "description" => ["required", "string"],
            "thumbnail" => ["required", "image"],     
        ]);

        $image = $request->file("thumbnail");
        $imageName = md5(time().rand(11111, 99999)).".".$image->extension();
        $image->move(public_path("uploads/journey"), $imageName);
        $journey = Journey::create([
            "user_id" => Auth::user()->id,
            "description" => $validated["description"],
            "thumbnail" => $imageName,
            
        ]);
    
        return redirect()->route("dashboard.journies.index")->with("success", "Journey created!");
    }

    public function edit($id) {
        $journey = Journey::find($id);
        if ($journey && Gate::allows("update-journey", $journey)) {
            return view("dashboard.journey.edit", compact("journey"));
        }
        return back()->withErrors("Journey not exists!");
    }

    public function update(Request $request, $id) {
        $journey = Journey::find($id);
        if ($journey && Gate::allows("update-journey", $journey)) {
            $validated = $request->validate([
                "description" => ["required", "string"],
                "thumbnail" => ["nullable", "image"],
            ]);
            $journey->description = $validated["desription"];
            
            if ($request->hasFile("thumbnail")) {
                $image = $request->file("thumbnail");
                $imageName = md5(time().rand(11111, 99999)).".".$image->extension();
                $image->move(public_path("uploads/journey"), $imageName);
                if (File::exists(public_path("uploads/journey/".$journey->thumbnail))) {
                    File::delete(public_path("uploads/journey/".$journey->thumbnail));
                }
                $journey->thumbnail = $imageName;
            }
            $journey->save();
            
            return redirect()->route("dashboard.journies.index")->with("success", "Journey updated!");
        }
        return back()->withErrors("Journey not exists!");
    }

    public function destroy($id) {
        $journey = Journey::find($id);
        if ($journey && Gate::allows("update-journey", $journey)) {
            $journey->delete();
            return back()->with("success", "Journey deleted!");
        }
        return back()->withErrors("Journey not exists!");
    }

}
