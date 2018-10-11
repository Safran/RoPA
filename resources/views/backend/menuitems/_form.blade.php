@extends('layouts.backend')

@section('title')
    @yield('form-title') @parent
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}"/>
    <style>
        textarea {
            resize: vertical;
        }

        .__locale_text {
            display: inline-block;
            min-width: 2em;
            height: 2em;
            padding: 0 3px;
            color: #0056b3;
            background: #fff;
            border: 1px solid #bbbbbe;
            border-radius: 1em;
            -webkit-box-shadow: 0 3px rgba(34, 34, 34, .075);
            box-shadow: 0 3px rgba(34, 34, 34, .075);
            font-size: 12px;
            font-size: .75rem;
            font-weight: 700;
            line-height: 1.8;
            text-align: center;
            text-transform: uppercase;
        }
    </style>
@stop

@section('content')
    @yield('open-form')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                @yield('form-title')
            </h4>
            <div class="float-right">
                <div class="btn-group">
                    <input type="submit" class="my-1 btn btn-success" value="@lang('admin/commons.save-button')"/>
                    <a href="{{ route('admin.menuitems', [$menu])}}"
                       class="my-1 btn btn-danger">@lang('admin/commons.cancel-button')</a>
                </div>
            </div>
        </div>
        <br/>
        <div class="card-body">
            <div class="container">

                {{ bs()->formGroup(bs()->text('path', old('path', isset($menuItem) ? $menuItem->path : '')))
                 ->label(__('admin/menuitems.fields.path.label'))
                 ->helpText(__('admin/menuitems.fields.path.help'))
                 }}
                @include('partials.form.fields.translatableinputtext', [
                 'label' => __('admin/menuitems.fields.title.label'),
                 'name' => 'title',
                 'required' => true,
                 'model' => isset($menuItem) ? $menuItem : null,
             ])
                {{ bs()->formGroup(bs()->select('active', [1 => __('admin/commons.yes'), 0 => __('admin/commons.no')], old('active', isset($menuItem) ? $menuItem->active : null)))
                  ->label(__('admin/menuitems.fields.active.label'))
                 ->helpText(__('admin/menuitems.fields.active.help'))

                 }}

                {{ bs()->formGroup(bs()->select('role', \App\Models\User::roles()->prepend(__('admin/menuitems.fields.role.select-all'), ''), old('role', isset($menuItem) ? $menuItem->role : null)))
                  ->label(__('admin/menuitems.fields.role.label'))
                 ->helpText(__('admin/menuitems.fields.role.help'))

                 }}
            </div>
        </div>
    </div>
    {{ bs()->closeForm() }}

@stop


@section('footer_scripts')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script src="{{ asset('ckeditor/adapters/jquery.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.atxeditor').ckeditor({
                language: '{{ locale() }}',
                customConfig: '{{ asset('js/ckeditor.js') }}'
            });
        });
    </script>
@endsection