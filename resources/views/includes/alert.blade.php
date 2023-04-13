@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
    {{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if ($message = Session::get('sucess'))
    <div class="alert alert-success" role="alert">
        {{ $message }}
    </div>
@endif