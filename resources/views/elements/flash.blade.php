@foreach (['primary', 'danger', 'warning', 'success', 'info'] as $type)
    @if(Session::has($type))
        <div class="alert alert-{{ $type }} alert-dismissible text-xs-center fixed-top" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            @if($type == "danger")
                <i class="fa fa-exclamation" aria-hidden="true"></i>
            @elseif ($type == "success")
                <i class="fa fa-check" aria-hidden="true"></i>
            @endif
            {!! Session::get($type) !!}
        </div>
    @endif
@endforeach
