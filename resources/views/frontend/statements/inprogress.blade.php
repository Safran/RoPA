@extends('layouts.frontend')

@section('title')
    @lang('locale.inprogress-statements-page-title') @parent
@stop

@section('pageclass', 'declarations-ip-page container')

@section('content')
    <h1>@lang('statements.inprogress.title')</h1>
    <p>@lang('statements.inprogress.disclaimer.'.auth()->user()->role)</p>

    @statementtable(['type' => 'inprogress', 'datas' => $inprogress, 'onlytable' => true, 'companies' => $companies, 'countries' => $countries, 'hasProgressBar' => true])
    @endstatementtable
@stop
