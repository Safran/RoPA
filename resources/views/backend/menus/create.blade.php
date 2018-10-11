@extends('backend.menus._form')

@section('form-title')
    @lang('admin/menus.pages-create')
@stop
@section('open-form')
    {{ bs()->openForm('post', route('admin.menus.store')) }}
@endsection