@extends('layouts.backend')

@section('title')
    @lang('admin/companies.title') @parent
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/dataTables.bootstrap4.min.css') }}"/>
    <style>
        #lawyer {
            height: calc(1.88125rem + 2px);
        }

        #table_length .custom-select-sm {
            height: calc(1.88125rem + 2px); !important;
        }
    </style>
@stop


@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                @lang('admin/companies.companies-list')
            </h4>
        </div>
    </div>
    <br/>
    <div class="card-body">
        <div class="container">
            <div class="row my-2 ">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" style="width:100%" id="table">
                        <thead>
                        <tr class="filters">
                            <th>@lang('admin/companies.headers.key')</th>
                            <th>@lang('admin/companies.headers.name')</th>
                            <th>@lang('admin/companies.headers.users')</th>
                            <th>@lang('admin/companies.headers.lawyers')</th>
                            <th>@lang('admin/companies.headers.statements')</th>
                            <th>@lang('admin/companies.headers.lawyer')</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('/js/jquery.dataTables.min.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(function () {
            $('#table').DataTable({
                iDisplayLength: 50,
                language: {
                    url: '{{ asset('/js/dataTables/'.App::getLocale().'.json') }}',
                },
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.companies.data') !!}',
                columns: [
                    {data: 'id', name: 'id', searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'users', name: 'users', searchable: false},
                    {data: 'lawyers', name: 'lawyers', searchable: false},
                    {data: 'statements', name: 'statements', searchable: false},
                    {data: 'lawyer', name: 'lawyer', sortable:false, searchable: false},
                ]
            });

            $('#table').on('change', '.changelawyer', function (event) {
                console.log(this.value);
                console.log($(this).attr('data-key'));

                axios.post(
                    '/{{ locale() }}/admin/companies/' + $(this).attr('data-key') + '/lawyer',
                    {
                        user: this.value,
                    }
                ).then(response => {
                    //console.log(response);
                    //flash('OK');
                });
            });
        });
    </script>
@stop