@if(!isset($nofieldset) || !$nofieldset)
<fieldset class="form-group border p-2" id="fieldset{{ $name }}">
    @else
        <div id="fieldset{{ $name }}text">
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
                @php $value =  old($name);
                if($value)
                {
                    $value = $value[$locale];
                } else {
                    $value = isset($model) ? $model->getTranslation($name, $locale):'';
                }
                @endphp
                <input type="text" class="form-control" id="{{ $name.'_'.$locale }}" name="{{ $name }}[{{$locale}}]"
                       value="{{ $value }}"
                       @if ($required) required @endif>
            </div>
        </div>
    @endforeach
@if(!isset($nofieldset) || !$nofieldset)
</fieldset>
@else
</div>
@endif