@extends('backend.menus._form')
@section('form-title')
    @lang('admin/menus.pages-edit')
@stop

@section('open-form')
    {{ bs()->openForm('put', route('admin.menus.update', [$menu])) }}
@endsection