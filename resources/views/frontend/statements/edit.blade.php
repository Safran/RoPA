@extends('layouts.frontend')

@section('title')
    @lang('locale.edit-statement-page-title', ['project' => $statement->get('name')]) @parent
@stop

@section('pageclass', 'show-declaration')

@section('content')
    <div class="small-container">
    <a  class="return-home" href="{{ route('frontend.home') }}">@lang('locale.welcome.back-button')</a>
    </div>
    <edit-declaration
            url="{{ route('frontend.statements.data', [$statement]) }}"
            role="{{ auth()->user()->role }}"
            locale="{{ locale() }}"
    ></edit-declaration>
@stop