<?php
?>
@extends('layouts.frontend')

@section('title')
    @lang('locale.upgrade-statement-page-title', ['project' => $statement->get('name')]) @parent
@stop

@section('pageclass', 'show-declaration')

@section('content')
    UPGRADING ....
@stop
