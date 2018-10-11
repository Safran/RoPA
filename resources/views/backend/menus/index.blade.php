@extends('layouts.backend')

@section('title')
    @lang('admin/menus.title') @parent
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}"/>
    <style>
        .small, small {
            font-size: .8rem;
        }
    </style>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                @lang('admin/menus.menus-list')
            </h4>
            <div class="float-right">
                <div class="btn-group">
                    <a href="{{route('admin.menus.create')}}"
                       class="my-1 btn btn-success">@lang('admin/menus.add-page')</a>
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
                                <th>@lang('admin/menus.headers.id')</th>
                                <th>@lang('admin/menus.headers.title')</th>
                                <th>@lang('admin/menus.headers.enabled')</th>
                                <th>@lang('admin/menus.headers.disabled')</th>
                                <th>@lang('admin/menus.headers.date')</th>
                                <th>@lang('admin/menus.headers.created_by')</th>
                                <th>@lang('admin/menus.headers.delete')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($menus))
                                @foreach($menus as $menu)
                                    <tr>
                                        <td>{{ $menu->id }}</td>
                                        <td><a href="{{ route('admin.menus.edit', [$menu]) }}">{{ $menu->title }}</a> <div class="small"><i>{{ $menu->slug }}</i></div></td>
                                        <td><a class="badge badge-success" href="{{ route('admin.menuitems', [$menu, 'active' => 1]) }}">{{ $menu->items->filter(function($item) {
                                        return $item->active;
                                        })->count() }}</a></td>
                                        <td><a class="badge badge-secondary" href="{{ route('admin.menuitems', [$menu, 'active' => 0]) }}">{{ $menu->items->filter(function($item) {
                                        return !$item->active;
                                        })->count() }}</a></td>
                                        <td>{{ $menu->created_at }}</td>
                                        <td>{{ $menu->editor->fullname }}</td>
                                        <td>
                                            @can('delete', $menu)
                                            <a href="#" data-remote="{{ route('admin.menus.confirm-delete', [$menu]) }}"
                                               data-toggle="modal"
                                               data-target="#delete_confirm"><i class="zmdi zmdi-delete"></i></a>
                                            @else
                                                <span class="zmdi-hc-stack"><i
                                                            class="zmdi zmdi-delete zmdi-hc-stack-1x"></i> <i
                                                            class="zmdi zmdi-block zmdi-hc-stack-2x text-danger"></i> </span>

                                            @endcan
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
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="menu_delete_confirm_title"
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