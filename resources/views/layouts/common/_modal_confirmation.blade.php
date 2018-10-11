<div class="modal-header">
    <h5 class="modal-title" id="{{$model}}_delete_confirm_title">@lang('admin/'.$model.'.modal.title')</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    @if($error)
        <div>{!! $error !!}</div>
    @else
        @lang('admin/'.$model.'.modal.body')
    @endif
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('admin/'.$model.'.modal.cancel')</button>
    @if(!$error)
        <a href="{{ $confirm_route }}" type="button" class="btn btn-danger">@lang('admin/'.$model.'.modal.confirm')</a>
    @endif
</div>

