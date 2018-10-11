@extends('layouts.frontend')

@section('title')
    @lang('locale.finished-statements-page-title') @parent
@stop

@section('pageclass', 'declarations-ip-page container')

@section('content')
    <h1>@lang('statements.finished.title')</h1>
    <p>@lang('statements.finished.disclaimer.'.auth()->user()->role)</p>
    @statementtable(['type' => 'finished', 'datas' => $finished, 'onlytable' => true, 'companies' => $companies, 'countries' => $countries, 'hasProgressBar' => true])
    @endstatementtable
@stop
