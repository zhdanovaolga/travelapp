@extends('dashboard.master')
@section('title', 'All Journies')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">All Journies</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">All Journies</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Journies</h3>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                @foreach ($errors->all() as $error)
                                <p class="m-0">{{ $error }}</p>
                                @endforeach
                            </div>
                            @endif
                            @if (session("success"))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Success!</h5>
                                <p class="m-0">{{ session("success") }}</p>
                            </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Author</th>
                                            <th>
                                            
                                            <th class="text-center">Views</th>
                                            <th class="text-center">Action</th>
                                            <th class="text-center">Information</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                        @forelse ($journies as $journey)
                                        <tr>
                                            <td class="text-center">{{ $loop->index + $journies->firstItem() }}</td>
                                            <td class="text-center">{{ $journey->user->name }}</td>
                                            


                                            <td class="text-center"><a href="{{ route("dashboard.journies.status", $journey->id) }}"></a></td>
                                            <td class="text-center">{{ $journey->views }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <a target="_blank" href="{{route("frontend.journey", $journey->id)}}" class="btn btn-success mr-1">View</a> 
 
                                                    <a href="{{ route("dashboard.journies.edit", $journey->id) }}" class="btn btn-warning mr-1">Edit</a>

                                                    <a href="{{ route("dashboard.locations.add", $journey->id) }}" class="btn btn-warning mr-1">Add Location</a>

                                                    <a href="{{ route("dashboard.expenses.add", $journey->id) }}" class="btn btn-warning mr-1">Add Expense</a>

                                                    <a href="{{ route("dashboard.places.add", $journey->id) }}" class="btn btn-warning mr-1">Add Place</a>
                                                    

                                                    <form action="{{ route("dashboard.journies.destroy", $journey->id) }}" method="POST">
                                                        @method("DELETE")
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger deletebtn">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                                
                                        @empty
                                        <tr>
                                            <td colspan="11" class="text-center">No journies found!</td>
                                        </tr>
                                        @endforelse
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if(isset($journies))
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                            {{ $journies->links() }}
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section("script")
<script src="{{ asset("assets/dashboard/plugins/sweetalert2/sweetalert2.all.js") }}"></script>
<script>
$('.deletebtn').on('click',function(e){
    e.preventDefault();
    var form = $(this).parents('form');
    Swal.fire({
        title: 'Are you sure?',
        type: 'warning',
        icon: 'warning',
        text: 'All comments of this post will delete!',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            form.submit();
        }
    });
});
</script>
@endsection
