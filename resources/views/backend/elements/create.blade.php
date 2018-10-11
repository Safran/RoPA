@extends('backend.elements._form')

@section('form-title')
    @lang('admin/forms.elements-create')
@stop
@section('open-form')
    {{ bs()->openForm('post', route('admin.elements.store', [$form])) }}
@endsection