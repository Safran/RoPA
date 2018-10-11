@extends('layouts.backend')

@section('title')
    @lang('admin/menuitems.title') @parent
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
                @lang('admin/menuitems.menuitems-list')
            </h4>
            <div class="float-right">
                <div class="btn-group">
                    <a href="{{route('admin.menus')}}"
                       class="my-1 btn btn-default">@lang('admin/menus.title')</a>
                    <a href="{{route('admin.menuitems.create', [$menu])}}"
                       class="my-1 btn btn-success">@lang('admin/menuitems.add-page')</a>
                </div>
            </div>
        </div>
        <br/>
        <div class="card-body">
            <div class="container">
                <div class="row my-2 ">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table"
                               data-sortable="{{ route('admin.menuitems.save_order') }}">
                            <thead>
                            <tr class="filters">
                                <th>@lang('admin/menuitems.headers.ordering')</th>
                                <th>@lang('admin/menuitems.headers.active')</th>
                                <th>@lang('admin/menuitems.headers.title')</th>
                                <th>@lang('admin/menuitems.headers.role')</th>
                                <th>@lang('admin/menuitems.headers.date')</th>
                                <th>@lang('admin/menuitems.headers.created_by')</th>
                                <th>@lang('admin/menuitems.headers.id')</th>
                                <th>@lang('admin/menuitems.headers.delete')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($menuitems))
                                @foreach($menuitems as $menuitem)
                                    <tr data-row-id="{{ $menuitem->id }}">
                                        <td><i class="zmdi zmdi-format-list-numbered"></i></td>
                                        <td>@if($menuitem->active) <i class="zmdi zmdi-check-circle text-success zmdi-hc-2x"></i> @else <i class="zmdi zmdi-close-circle text-danger zmdi-hc-2x"></i> @endif</td>
                                        <td><a href="{{ route('admin.menuitems.edit', [$menu, $menuitem]) }}">{{ $menuitem->title }}</a><div class="small"><i>{{ $menuitem->slug }}</i></div></td>
                                        <td>@if(!$menuitem->role) @lang('admin/menuitems.fields.role.select-all') @else {{ __('admin/users.roles.'.$menuitem->role) }} @endif</td>
                                        <td>{{ $menuitem->created_at }}</td>
                                        <td>{{ $menuitem->editor->fullname }}</td>
                                        <td>{{ $menuitem->id }}</td>
                                        <td><a href="#" data-remote="{{ route('admin.menuitems.confirm-delete', [$menuitem]) }}"
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
    <div id="activeselector" style="display: none;">
        <div class="input-group">
            <select class="custom-select" id="active-select">
                <option value="" @if(!isset($active)) selected @endif>@lang('admin/commons.all')</option>
                <option value="1" @if(isset($active) && (bool)$active) selected @endif>@lang('admin/menus.headers.enabled')</option>
                <option value="0" @if(isset($active) && !(bool)$active) selected @endif>@lang('admin/menus.headers.disabled')</option>
            </select>
        </div>
    </div>
    <div id="menuselector" style="display: none;">
        <div class="input-group">
            <select class="custom-select" id="menu-select">
                @foreach(\App\Models\Menu::all() as $selectmenu)
                    <option value="{{ route('admin.menuitems', [$selectmenu, 'active' => isset($active)?$active:'']) }}" @if($selectmenu->id == $menu->id) selected @endif>{{ $selectmenu->title }}</option>
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
                language: {
                    url: '{{ asset('js/dataTables/'.App::getLocale().'.json') }}'
                },
                dom: '<"btn-toolbar">frtip',
                fnInitComplete: function () {
                    $('div.btn-toolbar').html($('#activeselector').html()+$('#menuselector').html());

                    $('#active-select').on('change', function() {
                        let active = document.getElementById('active-select').value;
                        window.location.search = `active=${active}`;
                    });
                    $('#menu-select').on('change', function() {
                        window.location = document.getElementById('menu-select').value;
                    });
                },
            });
        });
    </script>
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="menuitem_delete_confirm_title"
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