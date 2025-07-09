@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li style="list-style: disc !important">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<ul class="alert alert-danger msg form_error" style="display:none;">
</ul>

<ul class="alert alert-success msg form_success" style="display:none;">
</ul>

@foreach (['danger', 'warning', 'success', 'info'] as $key)
    @if(Session::has($key))
        <p class="flashMsg alert alert-{{ $key }}">{{ Session::get($key) }}</p>
    @endif
@endforeach