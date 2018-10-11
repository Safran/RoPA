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

    <link rel="stylesheet" href="{{ asset('css/material-design-iconic-font.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/animsition.min.css') }}"/>

    <link rel="stylesheet" href="{{ asset('css/backend.css') }}"/>
    @yield('header_styles')

    <!--[if lt IE 9]>
    <script src="{{ asset('/js/html5shiv.js') }}"></script>
    <script src="{{ asset('/js/respond.min.js') }}"></script>
    <![endif]-->
    <script src="{{ asset('/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('/js/pace.min.js') }}"></script>
    <script src="{{ asset('/js/polyfill.min.js') }}"></script>

    @yield('header_scripts')
    <script>
        window.App = {!! json_encode([
            'csrfToken' => csrf_token(),
            'user'      => auth()->user(),
            'signedIn'  => auth()->check()
        ]) !!};
    </script>
</head>
<body class="animsition">
<div id="app">
    @include('layouts.backend.header-title')
    <div>
    @include('layouts.backend.header-menu')
    </div>
    <div class="@yield('pageclass', 'maincontainer')">
        @include('layouts.common._alerts')
        @yield('content')
        @include('layouts.backend.footer')
        <div>@version</div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/jquery-1.12.4.js') }}"></script>
<script src="{{ asset('js/animsition.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/backend.js') }}"></script>
<script>
    window.changeLang = function()
    {
        var selector = document.getElementById('langswitch');
        var value = selector[selector.selectedIndex].value;
        window.location.href = value;
    };
</script>
@yield('footer_scripts')
</body>
</html>