@extends('layouts.backend')

@section('title')
    @lang('admin/staticpages.title') @parent
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}"/>
    <style>
    </style>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                @lang('admin/staticpages.staticpages-list')
            </h4>
            <div class="float-right">
                <div class="btn-group">
                    <a href="{{route('admin.staticpages.create')}}"
                       class="my-1 btn btn-success">@lang('admin/staticpages.add-page')</a>
                </div>
            </div>
        </div>
        <br/>
        <div class="card-body">
            <div class="container">
                <div class="row my-2 ">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th>@lang('admin/staticpages.headers.id')</th>
                                <th>@lang('admin/staticpages.headers.slug')</th>
                                <th>@lang('admin/staticpages.headers.date')</th>
                                <th>@lang('admin/staticpages.headers.created_by')
                                <th>@lang('admin/staticpages.headers.delete')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($pages))
                                @foreach($pages as $page)
                                    <tr>
                                        <td>{{ $page->id }}</td>
                                        <td><a href="{{ route('admin.staticpages.edit', [$page]) }}">{{ $page->slug }}</a></td>
                                        <td>{{ $page->created_at }}</td>
                                        <td>{{ $page->editor->fullname }}</td>
                                        <td><a href="#" data-remote="{{ route('admin.staticpages.confirm-delete', [$page]) }}"
                                               data-toggle="modal"
                                               data-target="#delete_confirm"><i class="zmdi zmdi-delete"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#table').DataTable({
                language: {
                    url: '{{ asset('js/dataTables/'.App::getLocale().'.json') }}'
                },
            });
        });
    </script>
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="staticpage_delete_confirm_title"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <script>
        jQuery(function () {
            jQuery('body').on('click', '[data-toggle="modal"]', function(){
                jQuery(jQuery(this).data("target")+' .modal-content').load(jQuery(this).data("remote"));
            });
            jQuery('body').on('hidden.bs.modal', '.modal', function () {
                jQuery(this).removeData('bs.modal');
            });
        });
    </script>
@stop