<div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-alert-dismissible mb-0 pb-0">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Error:</strong> {{ $message }}
        </div>
    @endif

    @if ($message = Session::get('warning'))
        <div class="alert alert-warning alert-dismissible mb-0 pb-0">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Warning:</strong> {{ $message }}
        </div>
    @endif

    @if ($message = Session::get('info'))
        <div class="alert alert-info alert-dismissible mb-0 pb-0">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Info:</strong> {{ $message }}
        </div>
    @endif

    @foreach (session('flash', collect())->toArray() as $message)
        <div class="alert alert-{{ $message['level'] }} {{ $message['important'] ? 'alert-important' : '' }}" role="alert">
            @if ($message['important'])
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            @endif
            {!! $message['message'] !!}
        </div>
    @endforeach
    {{ session()->forget('flash') }}
</div>