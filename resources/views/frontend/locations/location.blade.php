<div class="journey-single-place">
    <div class="place-info">
        <div class="card mb-3" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="{{ asset('uploads/journey/'.($location->file_name)) }}" alt="{{ $location->description}}"
                        class="img-fluid rounded-start">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <p class="card-text">
                            <p class="row">{{ $location->description }}</p>
                            <p class="row">{{ $location->event->toArray()['event_date'] }}</p>
                            @if($isOwner)
                            <div class="row">
                                <a href="{{ route('dashboard.locations.edit', $location->id) }}"
                                    class="btn btn-warning mr-1">Edit</a>

                                <form action="{{ route('dashboard.locations.destroy', $location->id) }}" method="POST">
                                    @method("DELETE")
                                    @csrf
                                    <button 
                                        type="submit"
                                        onclick= "return confirm('Are You Sure Want to Delete?')" 
                                        class="btn btn-danger deletebtn">Delete</button>
                                </form>
                            </div>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>