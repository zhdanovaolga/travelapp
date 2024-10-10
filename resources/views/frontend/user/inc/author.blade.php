<section class="authors">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 ">
                    <div class="authors-info">
                    <div class="image">
                        <a href="{{ route("frontend.user", $user->username) }}" class="image">
                            <img src="{{ asset("uploads/author/".($user->profile ?? "default.webp")) }}" alt="{{ $user->name }}"/>
                        </a>
                    </div>
                    <div class="content">
                        <h4>{{ $user->name }}</h4>
                        @if ($user->about)
                        <p>{{ $user->about }}</p>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
