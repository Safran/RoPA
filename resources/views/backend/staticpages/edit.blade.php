@extends('backend.staticpages._form')
@section('form-title')
    @lang('admin/staticpages.pages-edit')
@stop

@section('open-form')
    {{ bs()->openForm('put', route('admin.staticpages.update', [$staticpage])) }}
@endsection