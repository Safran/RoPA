<div class="modal-header">
    <h5 class="modal-title" id="{{$model}}_updaterole_confirm_title">@lang('admin/'.$model.'.updaterole.modal.title')</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    @if($error)
        <div>{!! $error !!}</div>
    @else
        @lang('admin/'.$model.'.updaterole.modal.body', ['fullname' => $user->full_name,'role' => $role])
    @endif
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('admin/'.$model.'.updaterole.modal.cancel')</button>
    @if(!$error)
        {{ bs()->openForm('put', $confirm_route) }}
        <input type="hidden" name="role" id="change_user_role" value=""/>
        {{ bs()->hidden('role', $role) }}
        {{ bs()->button(__('admin/'.$model.'.updaterole.modal.confirm'), 'danger')->type('submit')->class('btn btn-danger') }}
        {{ bs()->closeForm() }}
    @endif
</div>

