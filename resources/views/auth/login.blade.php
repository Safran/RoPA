<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>
        @lang('auth.title') | {{ config('app.name', 'Laravel') }}
    </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('css/site.css') }}"/>
    @yield('header_scripts')
    <script>
        window.App = {!! json_encode([
            'csrfToken' => csrf_token(),
            'locale'    => locale(),
            'baseURL'   => url('/'),
        ]) !!};
    </script>
</head>
<body>
<div id="app">
    @include('layouts.frontend.header-title')
    <div class="login-page">
        <img class="logo" src="{{ asset('images/general/logo.svg') }}" alt="@lang('locale.logo_alt')">
        <div class="login-page__content">
            <div class="login-page__content-item login-page__content-images">
                <img class="cloud cloud-1 cloud-s" src="{{ asset('images/general/cloud.svg') }}"
                     alt="@lang('locale.cloud_alt')">
                <img class="cloud cloud-2 cloud-m" src="{{ asset('images/general/cloud.svg') }}"
                     alt="@lang('locale.cloud_alt')">
                <img class="cloud cloud-3 cloud-xs" src="{{ asset('images/general/cloud.svg') }}"
                     alt="@lang('locale.cloud_alt')">
                <img class="cloud cloud-4 cloud-s" src="{{ asset('images/general/cloud.svg') }}"
                     alt="@lang('locale.cloud_alt')">
                <img class="cloud cloud-5 cloud-l" src="{{ asset('images/general/cloud.svg') }}"
                     alt="@lang('locale.cloud_alt')">
                <img class="plane" src="{{ asset('images/general/plane.svg') }}" alt="@lang('locale.plane_alt')">
            </div>

            <div class="login-page__content-item login-page__content-form">
                <div class="login-page__content-form__container">
                    <h1>@lang('auth.login-title')</h1>
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username"
                                   class="col-md-4 control-label">@lang('auth.fields.username.label')</label>

                            <div class="col-md-6">
                                <input id="username" type="username"
                                       placeholder="@lang('auth.fields.username.placeholder')" class="form-control"
                                       name="username" value="{{ old('username') }}" required autofocus>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password"
                                   class="col-md-4 control-label">@lang('auth.fields.password.label')</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                       placeholder="@lang('auth.fields.password.placeholder')" class="form-control"
                                       name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="submit-button btn-primary">
                            @lang('auth.login-button')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ mix('js/main.js') }}"></script>
</body>
</html>