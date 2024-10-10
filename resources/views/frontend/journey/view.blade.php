@extends("frontend.master")

@section("content")
<section class="post-single">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset("uploads/journey/".$journey->thumbnail) }}" class="card-img-top">
                    <div class="card-body">
                        {!! $journey->description !!}
                    </div>
                </div>
                <div class="journey-single-body">
                        @foreach($events as $event)
                            @if ($event->type == 'place')
                                @include("frontend.places.place", ['place' => $event->place, 'isOwner' => $isOwner])
                            @elseif ($event->type == 'location')
                                @include("frontend.locations.location", ['location' => $event->location, 'isOwner' => $isOwner])
                            @elseif ($event->type == 'expense')
                                @include("frontend.expenses.expense", ['expense' => $event->expense, 'event' => $event, 'isOwner' => $isOwner])
                            @endif
                        @endforeach              
                        @include("frontend.journey.inc.author")      
                        @if ($isOwner)
                        <a href="{{ route("dashboard.locations.add", $journey->id) }}" class="btn btn-warning mr-1">Add Location</a>

                        <a href="{{ route("dashboard.expenses.add", $journey->id) }}" class="btn btn-warning mr-1">Add Expense</a>

                        <a href="{{ route("dashboard.places.add", $journey->id) }}" class="btn btn-warning mr-1">Add Place</a>
                        @endif
                </div>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>
</section>
@endsection
