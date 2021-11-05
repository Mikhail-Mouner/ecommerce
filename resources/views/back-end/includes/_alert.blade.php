@if(session()->has('mssg'))
    <div class="alert alert-{{ session()->get('mssg')['status'] }} alert-dismissible fade show" role="alert"
         id="alert-message">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        <strong class="text-capitalize">{{ session()->get('mssg')['data'] }} !</strong>
    </div>
@endif