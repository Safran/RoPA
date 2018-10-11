<form onsubmit="return massAssign()">
    <div class="modal-header">
        <h5 class="modal-title" id="mass_assign_confirm_title">@lang('admin/users.mass-assign.modal.title')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        @if($error)
            <div>{!! $error !!}</div>
        @else
            @lang('admin/users.mass-assign.modal.body', ['fullname' => $user->full_name])
        @endif
        {{ bs()->select('to', \App\Models\User::where('role', 'employee')->where('id', '<>', $user->id)->get()->pluck('fullname', 'id')->prepend(__('admin/users.mass-assign.modal.select-new-user'), ''), '')->id('userto') }}

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default"
                data-dismiss="modal">@lang('admin/users.mass-assign.modal.cancel')</button>
        @if(!$error)
            {{ bs()->button(__('admin/users.mass-assign.modal.confirm'), 'danger')->type('submit')->class('btn btn-danger') }}
        @endif
    </div>
</form>
<script>
    function massAssign() {
        let to = $('#userto').val();
        if (to != '') {
            axios.put('/{{ locale() }}/admin/users/{{ $user->id }}/mass-assign',
            {
                'to': to
            }).then(response => {
                window.location.href = '/{{ locale() }}/admin/users';
            });
        }
        return false;
    }
</script>


