@extends('layouts.frontend')

@section('title')
    {{$staticpage->title}} @parent
@stop

@section('pageclass', '')

@section('content')
    <div class="disclaimer-page small-container">
        <aside class="sidebar-component" v-if="!getTablet">
            <img class="cloud cloud-1 cloud-l" src="{{ asset('images/general/cloud.svg') }}"
                 alt="@lang('locale.cloud')">
            <img class="plane" src="{{ asset('images/general/plane.svg') }}" alt="@lang('locale.plane_alt')">
        </aside>
        <div class="disclaimer-page__text">
            <a class="return-home" href="{{ route('frontend.home') }}">@lang('locale.welcome.back-button')</a>

            <h1>{{$staticpage->title}}</h1>
            <div class="disclaimer-page__text-item">
                {!! clean($staticpage->body) !!}
            </div>
        </div>
    </div>
@stop
