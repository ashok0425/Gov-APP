<div>
    @if ($errors->any())
        <div class="alert alert-danger  alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show p-3" role="alert">
        {{ session('error') }}
    </div>
@endif
</div>
