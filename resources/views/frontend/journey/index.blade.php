@extends("frontend.master")

@section("content")
<section class="post-single">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-lg-12">
                <div class="journey-single-image">
                    <img src="{{ asset("uploads/journey/".$journey->thumbnail) }}" />
                </div>
                <div class="journey-single-body">
                    <div class="jorney-single-title">
                        <ul class="entry-meta">
                            <li class="journey-author-img"><img src="{{ asset("uploads/author/" . ( $journey->user->profile ?? "default.webp")) }}" alt="{{ $journey->user->name }}"/></li>
                            <li class="journey-author"> <a href="{{ route("frontend.user", $journey->user->username) }}">{{ $journey->user->name }}</a></li>
                           
                         
                        </ul>
                    </div>
                    <div class="journey-single-description">
                        {!! $journey->description !!}
                    </div>    
                                   
                                            <ul>
                                            <li>                      
                                            </li>
                                            </ul>
                                         
                                            
                        
                    </div>
                    @include("frontend.journey.inc.author")
                </div>
            </div>
        </div>
    </div>
</section>
{{ $journies->links() }}
@endsection
