@extends('layouts.backend')

@section('title')
    @lang('admin/forms.title') @parent
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}"/>
@stop
@section('content')
    <form>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    @lang('admin/forms.forms-create')
                </h4>
                <div class="float-right">
                    <div class="btn-group">
                        <input type="submit" class="my-1 btn btn-success" value="@lang('admin/commons.save-button')"/>
                        <a href="{{route('admin.forms')}}"
                           class="my-1 btn btn-danger">@lang('admin/commons.cancel-button')</a>
                    </div>
                </div>
            </div>
            <br/>
            <div class="card-body">
                <div class="container">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                               aria-controls="home" aria-selected="true">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                               aria-controls="profile" aria-selected="false">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                               aria-controls="contact" aria-selected="false">Contact</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">1
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">2</div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">3</div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('footer_scripts')

@endsection