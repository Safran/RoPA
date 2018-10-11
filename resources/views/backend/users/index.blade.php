@extends('layouts.backend')

@section('title')
    @lang('admin/users.title') @parent
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
                @lang('admin/users.users-list', ['role' => $selectedRole])
            </h4>
            <div class="float-right">
                <div class="btn-group">
                    <a href="{{ route('admin.users.csv') }}" class="my-1 btn btn-info btn-sm">@lang('admin/users.export-button')</a>
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
                                <th>@lang('admin/users.headers.key')</th>
                                <th>@lang('admin/users.headers.username')</th>
                                <th>@lang('admin/users.headers.role')</th>
                                <th>@lang('admin/users.headers.email')</th>
                                <th>@lang('admin/users.headers.fullname')</th>
                                <th>@lang('admin/users.headers.last_activity')</th>
                                <th>@lang('admin/users.headers.statements')</th>
                                <th>@lang('admin/users.headers.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <ul class="list-group">
                <li class="list-group-item"><span class="zmdi zmdi-archive pull-left"> @lang('admin/users.legend.archived')</li>
                <li class="list-group-item"><span class="zmdi zmdi-assignment-check pull-left"> @lang('admin/users.legend.validated')</li>
                <li class="list-group-item"><span class="zmdi zmdi-assignment-o pull-left"> @lang('admin/users.legend.inprogress')</li>
                <li class="list-group-item"><span class="zmdi zmdi-assignment-account pull-left"> @lang('admin/users.legend.supervised')</li>
            </ul>
        </div>
    </div>
    <div id="roleselector" style="display: none;">
        <div class="input-group">
            <select class="custom-select" id="role-select">
                <option value="">@lang('admin/users.all-roles')</option>
                @foreach(\App\Models\User::roles() as $role => $name)
                    <option value="{{ $role }}"
                            @if(isset($selectedRole) && $role == $selectedRole) selected @endif>{{ $name }}</option>

                @endforeach
            </select>
        </div>
    </div>
@stop

@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#table').DataTable({
                iDisplayLength: 50,
                language: {
                    url: '{{ asset('js/dataTables/'.App::getLocale().'.json') }}'
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'username',
                        name: 'username',
                    },
                    {
                        data: 'role_manager',
                        name: 'role',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'last_connexion',
                        name: 'last_connexion',
                    },
                    {
                        data: 'statistics',
                        name: 'statistics',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                    },
                ],
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.users.datas') }}',
                    data:function(params) {
                        params.role = document.getElementById('role-select').value;
                    },
                },
                dom: '<"btn-toolbar">frtip',
                fnInitComplete: function () {
                    $('div.btn-toolbar').html($('#roleselector').html());

                    $('#role-select').on('change', function () {
                        $('#table').DataTable().ajax.reload();
                     });
                }
            });
        });
    </script>
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

    <div class="modal fade" id="assign_confirm" tabindex="-1" role="dialog" aria-labelledby="user_assign_confirm_title"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <script>
        jQuery(function () {
            jQuery('body').on('click', '[data-toggle="modal"]', function () {
                jQuery(jQuery(this).data("target") + ' .modal-content').load(jQuery(this).data("remote"));
            });
            jQuery('body').on('hidden.bs.modal', '.modal', function () {
                jQuery(this).removeData('bs.modal');
            });
        });
    </script>
@stop