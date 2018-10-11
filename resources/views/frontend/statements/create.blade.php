@extends('layouts.frontend')

@section('title')
    @lang('locale.create-statement-page-title') @parent
@stop

@section('pageclass', 'new-declaration small-container')

@section('content')
    <new-declaration
            url="{{ route('frontend.statements.form') }}"
            role="{{ auth()->user()->role }}"
            locale="{{ locale() }}"
            userid="{{ auth()->user()->id }}"
            companyid="{{ auth()->user()->company_id }}"
    ></new-declaration>
@stop
