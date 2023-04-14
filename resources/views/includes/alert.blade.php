@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
    {{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors as $error)
                <li>
                    @if(is_array($error))
                        {{$error[0]}}
                    @else
                        {{ $error }}
                    @endif 
                </li>
            @endforeach
        </ul>
    </div>
@endif

@if ($message = Session::get('sucess'))
    <div class="alert alert-success" role="alert">
        {{ $message }}
    </div>
@endif