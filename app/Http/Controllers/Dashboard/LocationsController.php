<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Event;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class LocationsController extends Controller
{

    public function create($journeyId) {
        
        return view("dashboard.locations.add", compact('journeyId'));
    }

    public function store(Request $request, $journeyId) { 
        $validated = $request->validate([
            "description" => ["required", "string"],
            'event_date' => ["required", "string"],
        ]);

        $image = $request->file("file_name");
        $imageName = md5(time().rand(11111, 99999)).".".$image->extension();
        $image->move(public_path("uploads/journey"), $imageName);

        $event = Event::create([
            'journey_id' => $journeyId,
            'type' => 'location',
            'event_date' => $validated["event_date"],
        ]);
        $location = Location::create([
            "event_id" => $event->id,
            "description" => $validated["description"],
            "file_name" => $imageName,
        ]);
    
        return redirect()->route("dashboard.journies.view")->with("success", "Location created!");
    }

    public function edit($id) {
        $location = Location::with('event.journey')->where('id', $id)->first();
        if ($location && Gate::allows("update-journey", $location->event->journey)) {
            return view("dashboard.locations.edit", compact("location"));
        }
        return back()->withErrors("Location not exists!");
    }

    public function update(Request $request, $id) {
        $location = Location::with('event.journey')->where('id', $id)->first();
        if ($location && Gate::allows("update-journey", $location->event->journey)) {
            $validated = $request->validate([
                "description" => ["required", "string"],
                'event_date' => ["required", "string"],
            ]);
            $location->event->event_date = $validated["event_date"];
            $location->description = $validated["description"];
            
            if ($request->hasFile("file_name")) {
                $image = $request->file("file_name");
                $imageName = md5(time().rand(11111, 99999)).".".$image->extension();
                $image->move(public_path("uploads/journey"), $imageName);
                if (File::exists(public_path("uploads/journey/".$location->file_name))) {
                    File::delete(public_path("uploads/journey/".$location->file_name));
                }
                $location->file_name = $imageName;
            }
            $location->save();
            $location->event->save();

            return redirect()->route("dashboard.journies.index")->with("success", "Location updated!");
        }
        return back()->withErrors("Location not exists!");
    }

    public function destroy($id) {
        $location = Location::with('event.journey')->where('id', $id)->first();;
        if ($location && Gate::allows("update-journey", $location->event->journey)) {
            $location->delete();
            $location->event->delete();
            return back()->with("success", "Location deleted!");
        }
        return back()->withErrors("Location not exists!");
    }

}
