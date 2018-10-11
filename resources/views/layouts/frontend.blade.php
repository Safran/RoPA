<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>
        @section('title')
            | {{ config('app.name', 'Laravel') }}
        @show
    </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <style>
        #app.loading {
            opacity: 0;
        }

        body.pace-running {
            background: #fff;
        }

        body.pace-running #app {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="{{ mix('css/site.css') }}">
    @yield('header_styles')
    <script src="{{ asset('js/pace.min.js') }}"></script>
    @yield('header_scripts')
    <script>
        window.App = {!! json_encode([
            'csrfToken' => csrf_token(),
            'user'      => auth()->user(),
            'signedIn'  => auth()->check(),
            'locale'    => locale(),
            'baseURL'   => url('/'),
            'messages'  => $messages,
        ]) !!};
    </script>
    
    <script src="{{ asset('/js/polyfill.min.js') }}"></script>
</head>
<body>
<div id="app" :class="classes">
    @include('layouts.frontend.header-title')
    <div v-if="!getTablet">@include('layouts.frontend.header-menu-desktop')</div>
    <menu-mobile v-else
                 :enable-shadow="enableShadow"
                 :notifications="{{ $notifications }}"
                 logout-link="{{ route('logout') }}">
        {!!  Menu::render('main-menu', ['class' => 'mobile-overlay__links']) !!}
    </menu-mobile>

    <div class="@yield('pageclass')">
        @include('layouts.common._alerts')
        <div><flash message="{{ session('flash') }}"></flash></div>
        @yield('content')
        @include('layouts.frontend.footer')
    </div>
</div>

@yield('footer_scripts')
<script src="{{ mix('js/main.js') }}"></script>
<script>
    window.changeLang = function()
    {
        var selector = document.getElementById('langswitch');
        var value = selector[selector.selectedIndex].value;
        window.location.href = value;
    };

    Pace.start({
        elements: {
            selectors: ['.declaration'],
        },
        ajax: {
            ignoreURLs: [/users/, /countries/, /companies/],
        }
    });
    @if ($message = Session::get('success'))
        flash('{{ $message }}');
    @endif
</script>
</body>
</html>