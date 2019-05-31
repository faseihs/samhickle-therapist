@if (session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <i class="fa fa-check-circle"></i> {{session('success')}}
    </div>
@endif

@if (session('primary'))
    <div class="alert alert-primary alert-dismissible" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <i class="fa fa-check-square-o"></i> {{session('primary')}}

    </div>
@endif

@if (session('deleted'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <i class="fa fa-close"></i> {{session('deleted')}}
    </div>
@endif