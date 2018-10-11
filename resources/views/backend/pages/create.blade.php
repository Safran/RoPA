@extends('backend.pages._form')

@section('form-title')
    @lang('admin/forms.pages-create')
@stop
@section('open-form')
    {{ bs()->openForm('post', route('admin.pages.store', [$form])) }}
@endsection