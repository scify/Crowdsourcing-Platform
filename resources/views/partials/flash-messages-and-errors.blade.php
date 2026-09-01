@if(session('flash_message_success'))
    <div class="alert alert-success alert-dismissable alert-floating">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4><i class="icon fa fa-check"></i> {{ session('flash_message_success') }}</h4>
    </div>
@endif

@if(session('flash_message_error'))
    <div class="alert alert-danger alert-dismissable alert-floating">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4><i class="icon fa fa-ban"></i> {{ session('flash_message_error') }}</h4>
    </div>
@endif
@if (isset($errors) && count($errors) > 0 )
    <div class="alert alert-danger alert-dismissable alert-floating">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        @foreach ($errors->all() as $error)
            <h4><i class="icon fa fa-ban"></i> {{ $error }}</h4>
        @endforeach
    </div>
@endif
