<div class="journey-single-author">
    <div class="authors-info">
        <div class="image">
            <a href="{{ route("frontend.user", $journey->user->username) }}" class="image">
                <img src="{{ asset("uploads/author/".($journey->user->profile ?? "default.webp")) }}" alt="{{ $journey->user->name }}"/>
            </a>
        </div>
        <div class="content">
            <a href="{{ route("frontend.user", $journey->user->username) }}"><h4>{{ $journey->user->name }}</h4></a>
         
            <p>{{ $journey->user->about }}</p>
            
            
        </div>
    </div>
</div>
