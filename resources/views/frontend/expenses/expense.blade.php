<div class="journey-single-expense">
    <div class="expense-info">
        <div class="card mb-3" style="max-width: 540px;">
            <div class="row g-0">
                
                <div class="col-md-8">
                    <div class="card-body">
                        <p class="card-text">
                        <h5 class="card-title">{{ $expense->description }}</h5>
                        <p class="row">{{ $expense->cost }}</p>
                        <p class="row">{{ $expense->event->toArray()['event_date'] }} </p>
                        @if ($isOwner)
                        <div class="row">
                            <a href="{{ route("dashboard.expenses.edit", $expense->id) }}"
                                class="btn btn-warning mr-1">Edit</a>

                            <form action="{{ route("dashboard.expenses.destroy", $expense->id) }}" method="POST">
                                @method("DELETE")
                                @csrf
                                <button type="submit" 
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
</div>