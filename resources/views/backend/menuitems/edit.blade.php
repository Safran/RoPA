@extends('backend.menuitems._form')
@section('form-title')
    @lang('admin/menuitems.menuitems-edit')
@stop

@section('open-form')
    {{ bs()->openForm('put', route('admin.menuitems.update', [$menu, $menuItem])) }}
@endsection