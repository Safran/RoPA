@extends('backend.elements._form')
@section('form-title')
    @lang('admin/forms.elements-edit')
@stop
@section('open-form')
    {{ bs()->openForm('put', route('admin.elements.update', [$form, $formElement])) }}
@endsection