<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class PlacesController extends Controller
{

    public function create($journeyId) {
       
        return view("dashboard.places.add", compact('journeyId'));
    }

    public function store(Request $request, $journeyId) {
        $validated = $request->validate([
            "description" => ["required", "string"],
            "title" => ["required", "string"], 
            'event_date' => ["required", "string"],   
        ]);

        $image = $request->file("file_name");
        $imageName = md5(time().rand(11111, 99999)).".".$image->extension();
        $image->move(public_path("uploads/journey"), $imageName);
        $event = Event::create([
            'journey_id' => $journeyId,
            'type' => 'place',
            'event_date' => $validated["event_date"],
        ]);
        $place = Place::create([
            "event_id" => $event->id,
            "title" => $validated["title"],
            "description" => $validated["description"],
            "file_name" => $imageName,
        ]);
    
        return redirect()->route("dashboard.journies.view")->with("success", "Event created!");
    }

    public function edit($id) {
        $place = Place::with('event.journey')->where('id', $id)->first();

        if ($place && Gate::allows("update-journey", $place->event->journey)) {

            return view("dashboard.places.edit", compact("place"));
        }
        return back()->withErrors("Place not exists!");
    }

    public function update(Request $request, $id) {
        $place = Place::with('event.journey')->where('id', $id)->first();

        if ($place && Gate::allows("update-journey", $place->event->journey)) {
            $validated = $request->validate([
                "description" => ["required", "string"],
                "title" => ["required", "string"],
                'event_date' => ["required", "string"],
            ]);
            $place->event->event_date = $validated["event_date"];
            $place->description = $validated["description"];
            
            if ($request->hasFile("file_name")) {
                $image = $request->file("file_name");
                $imageName = md5(time().rand(11111, 99999)).".".$image->extension();
                $image->move(public_path("uploads/journey"), $imageName);
                if (File::exists(public_path("uploads/journey/".$place->file_name))) {
                    File::delete(public_path("uploads/journey/".$place->file_name));
                }
                $place->file_name = $imageName;
            }
            $place->save();
            $place->event->save();
            return redirect()->route("dashboard.journies.view")->with("success", "Place updated!");
        }
        return back()->withErrors("Place not exists!");
    }

    public function destroy($id) {
        $place = Place::find($id);
        if ($place && Gate::allows("update-journey", $place->event->journey)) {
            $place->delete();
            $place->event->delete();
            return back()->with("success", "Place deleted!");
        }
        return back()->withErrors("Place not exists!");
    }

}
