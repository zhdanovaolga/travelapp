<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Journey;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class JourneyController extends Controller
{

    public function view($id) {
        $journey = Journey::with(["user"])->where('id', $id)->first();

        if ($journey) {
            $isOwner = Auth::user()?->id == $journey->id;
            $events = Event::with(['place', 'location', 'expense'])
                ->where('journey_id', $id)
                ->orderBy('event_date')
                ->get();

            return view("frontend.journey.view", compact("journey", 'events', 'isOwner'));
        }
        return abort(404);
    }

}