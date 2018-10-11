@extends('layouts.backend')

@section('title')
    @lang('admin/dashboard.title') @parent
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}"/>
    <style>
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('admin/dashboard.statements.title')</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="table">
                        <thead>
                            <th>@lang('admin/dashboard.statements.headers.id')</th>
                            <th>@lang('admin/dashboard.statements.headers.project')</th>
                            <th>@lang('admin/dashboard.statements.headers.status')</th>
                            <th>@lang('admin/dashboard.statements.headers.author')</th>
                            <th>@lang('admin/dashboard.statements.headers.owner')</th>
                            <th>@lang('admin/dashboard.statements.headers.supervisor')</th>
                            <th>@lang('admin/dashboard.statements.headers.company')</th>
                            <th>@lang('admin/dashboard.statements.headers.date')</th>
                            <th>@lang('admin/dashboard.statements.headers.actions')</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@stop
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('js/jquery.peity.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#table').DataTable({
                language: {
                    url: '{{ asset('js/dataTables/'.App::getLocale().'.json') }}'
                },
                processing: true,
                serverSide: true,
                "ajax": '{{ route('admin.statements.data') }}',
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'project',
                        name: 'project'
                    },
                    {
                        data: 'progress',
                        name: 'progress',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, full, meta) {
                            return '<span class="pie">' +data['global']+ '/100</span>';
                        },
                    },
                    {
                        data: 'author',
                        name: 'author',
                    },
                    {
                        data: 'owner',
                        name: 'owner',
                    },
                    {
                        data: 'supervisor',
                        name: 'supervisor',
                    },
                    {
                        data: 'company',
                        name: 'company'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'id',
                        name: 'action',
                        render: function (data, type, full, meta) {
                            return '<a href="#" data-remote="/{{ locale() }}/admin/statements/'+data+'/confirm-delete"'
                            + 'data-toggle="modal"'
                            + 'data-target="#delete_confirm"><i class="zmdi zmdi-delete"></i></a>';
                        },
                    },
                ],
                order: [[0, 'asc']],
                drawCallback: function( settings ) {
                    $("span.pie").peity("pie",  {
                        delimiter: null,
                        fill: [
                            '#388e3c',
                            '#ef5350',
                            '#ef9a9a'
                        ],
                        height: null,
                        radius: 11,
                        width: null,
                    });
                },
                initComplete: function (settings, json) {
                    $("span.pie").peity("pie",  {
                        delimiter: null,
                        fill: [
                            '#388e3c',
                            '#ef5350',
                            '#ef9a9a'
                        ],
                        height: null,
                        radius: 11,
                        width: null,
                    });
                },
            });
        });
    </script>
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="form_delete_confirm_title"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            jQuery('body').on('click', '[data-toggle="modal"]', function () {
                jQuery(jQuery(this).data("target") + ' .modal-content').load(jQuery(this).data("remote"));
            });
            jQuery('body').on('hidden.bs.modal', '.modal', function () {
                jQuery(this).removeData('bs.modal');
            });
        });
    </script>
@stop