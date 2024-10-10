<div class="col-lg-8 content">
    <div class="theiaStickySidebar">
        <div class="section-title">
            <h3>Recent Journies</h3>
            <p>Discover the most outstanding articles in all topics of life.</p>
        </div>
        @forelse ($journies as $journey)
        <div class="journey-list journey-list-style4">
            <div class="journey-list-image">
                <a href="{{ route("frontend.journey", $journey->id) }}">
                    <img src="{{ asset("uploads/journey/".$journey->thumbnail) }}" alt="{{ $journey->description }}"/>
                </a>
            </div>
            <div class="journey-list-content">
                <ul class="entry-meta">
                    <li class="journey-date"> <span class="line"></span>{{ $journey->created_at->format("F d, Y") }}</li>
                </ul>
                <h5 class="entry-title">
                    <a href="{{ route("frontend.journey", $journey->id) }}">{{ $journey->description }}</a>
                </h5>

                <div class="post-btn">
                    <a href="{{ route("frontend.journey", $journey->id) }}" class="btn-read-more">Continue Reading <i class="las la-long-arrow-alt-right"></i></a>
                </div>
            </div>
        </div>
        @empty
        <div>No journey found!</div>
        @endforelse

                                            
        <div class="pagination">
            <div class="pagination-area">
            {{ $journies->links("vendor.pagination.custom") }}
            </div>
        </div>
    </div>
</div>
