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
                    <h1>{{ __('errors.error-403') }}</h1>
                    <p class="lead">{{ __('errors.error-403-info') }}</p>
                    <p class="lead">
                        <a href="{{ route('frontend.home') }}"
                           class="btn btn-default">@lang('locale.welcome.back-button')</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ mix('js/main.js') }}"></script>
</body>
</html>