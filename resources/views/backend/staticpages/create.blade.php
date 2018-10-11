@extends('backend.staticpages._form')

@section('form-title')
    @lang('admin/staticpages.pages-create')
@stop
@section('open-form')
    {{ bs()->openForm('post', route('admin.staticpages.store')) }}
@endsection