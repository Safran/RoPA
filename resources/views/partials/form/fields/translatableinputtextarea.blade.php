@if(!isset($nofieldset) || !$nofieldset)
<fieldset class="form-group border p-2" id="fieldset{{ $name }}">
@else
    <div id="fieldset{{ $name }}textarea{{ (isset($suffix) && $suffix) ? $suffix : '' }}">
@endif
    @isset($label)
        <legend class="border p-1">{{ $label }}</legend>
    @endisset
    @foreach(locales() as $locale)
        <div class="form-group {{ $errors->has($name) ? 'has-error' : '' }}">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text __locale_text">{{ $locale }}</span>
                </div>
                <div class="form-control">
                <textarea class="atxeditor{{ (isset($noeditor) && $noeditor) ? 'noeditor' : ''  }}" id="{{ $name.'_'.$locale }}" name="{{ $name }}[{{$locale}}]"
                          @if ($required) required @endif @if(isset($noeditor) && $noeditor)  rows="10" cols="50" @endif>{{ old($name.'['.$locale.']', isset($model) ? ($model->isTranslatableAttribute($name) ? $model->getTranslation($name, $locale) : ((is_object($value) && isset($value->{$locale})) ? $value->{$locale} : $value)):'') }}</textarea>
                </div>
            </div>
        </div>
    @endforeach
@if(!isset($nofieldset) || !$nofieldset)
</fieldset>
@else
</div>
@endif