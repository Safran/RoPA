@extends('backend.pages._form')
@section('form-title')
    @lang('admin/forms.pages-edit')
@stop
@section('open-form')
    {{ bs()->openForm('put', route('admin.pages.update', [$form, $formPage])) }}
@endsection