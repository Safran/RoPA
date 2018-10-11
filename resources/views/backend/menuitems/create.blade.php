@extends('backend.menuitems._form')

@section('form-title')
    @lang('admin/menuitems.menuitems-create')
@stop
@section('open-form')
    {{ bs()->openForm('post', route('admin.menuitems.store', [$menu])) }}
@endsection