<img id="img{{$key}}" src="{{$value}}" alt="" class="img-responsive thumbnail">
<div class="input-group">
    <div class="input-group-btn">
        <a href="" class="popup_selector btn btn-primary"
           data-inputid="{{$key}}">@lang('admin/settings.types.file.select')</a>
    </div>
    {{ bs()->text('settings['.$key.']', old('settings['.$key.']', ''))->id($key) }}
</div>