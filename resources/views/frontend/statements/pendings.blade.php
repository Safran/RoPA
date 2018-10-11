@extends('layouts.frontend')

@section('title')
    @lang('locale.pendings-statements-page-title') @parent
@stop

@section('pageclass', 'declarations-ip-page container')

@section('content')
    <h1>@lang('statements.pendings.title')</h1>
    <p>@lang('statements.pendings.disclaimer.'.auth()->user()->role)</p>
    @statementtable(['type' => 'pendings', 'datas' => $pendings, 'onlytable' => true, 'hasProgressBar' => false, 'companies' => $companies, 'countries' => $countries, 'hasProgressBar' => true])
    @endstatementtable
@stop
