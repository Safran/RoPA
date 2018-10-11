@extends('layouts.frontend')

@section('pageclass', '')

@section('title')
    @lang('locale.disclaimer-page-title') @parent
@stop

@section('content')
    <div class="disclaimer-page small-container">
        <aside class="sidebar-component" v-if="!getTablet">
            <img class="cloud cloud-1 cloud-l" src="{{ asset('images/general/cloud.svg') }}"
                 alt="@lang('locale.cloud')">
            <img class="plane" src="{{ asset('images/general/plane.svg') }}" alt="@lang('locale.plane_alt')">
        </aside>
        <div class="disclaimer-page__text">
            <a class="return-home" href="{{ route('frontend.home') }}">@lang('locale.welcome.back-button')</a>

            <disclaimer-content :pages="{{ $pages }}"></disclaimer-content>
        </div>
    </div>
@stop
