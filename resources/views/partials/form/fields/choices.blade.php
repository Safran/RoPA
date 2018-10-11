<table id="choices-table" width="100%" class="table table-striped table-responsive">
    <thead>
    <tr>
        <th width="10%">@lang('admin/forms.formelement.choices.headers.value')</th>
        @foreach(locales() as $locale)
            <th width="{{ 85 / locales()->count() }}%">@lang('admin/forms.formelement.choices.headers.label') {{ $locale }}</th>
        @endforeach
        @if(!isset($hasDefault) || $hasDefault)
        <th width="5%">@lang('admin/forms.formelement.choices.headers.default')</th>
       @endif
        <th></th>
    </tr>
    </thead>
    <tbody>
	<?php $i = 0;?>
    @if(! empty($choices))
    @foreach($choices as $choice)
        <tr id="tr_{{ $i }}" data-index="{{ $i }}">
            <td>
                <input name="special{{ "[$i][value]" }}" type="text"
                       value="{{ $choice->value }}" class="form-control"/>
            </td>
            @foreach(locales() as $locale)
            <td>
                <input name="special{{ "[$i][label][$locale]" }}" type="text"
                       value="{{ $choice->label->{$locale} }}" class="form-control"/>
            </td>
            @endforeach
            @if(!isset($hasDefault) || $hasDefault)
            <td>
                <input name="special_default" value="{{ $choice->value }}" type="radio" class="form-control" @if($choice->value == $default) checked @endif/>
            </td>
            @endif
            <td>
                <button type="button" class="btn btn-danger remove-choice"
                        data-index="{{ $i }}"><i class="zmdi zmdi-delete"></i>
                </button>
            </td>
        </tr>
		<?php $i++;?>
    @endforeach
    @endif
    </tbody>
</table>
<div class="">
    <button type="button" class="btn btn-success" id="add-choice"><i
                class="zmdi zmdi-plus"></i>
    </button>
    <span class="help-block">@lang('admin/forms.formelement.choices.add-choice-button')</span>
</div>
<script>
    jQuery(document).ready(function () {
        if ($("#choices-table").length > 0) {
            $(document).on('click', '#add-choice', function () {
                var index = $('#choices-table tr:last').data('index');
                if (isNaN(index)) {
                    index = 0;
                } else {
                    index++;
                }
                var newvalue = 0;
                $('#choices-table tr td:first-child').each(function() {
                    var value = parseInt($(this).find("input").val());
                    newvalue = (value > newvalue) ? value : newvalue;
                });
                newvalue++;

                $('#choices-table tr:last').after('<tr id="tr_' + index + '" data-index="' + index + '"><td>' +
                    '<input name="special[' + index + '][value]" type="text"' + 'value="'+newvalue+'" class="form-control"/></td>'
                @foreach(locales() as $locale)
                    + '<td><input name="special[' + index + '][label][{{$locale}}]" type="text"' + 'value="" class="form-control"/></td>'
                 @endforeach
@if(!isset($hasDefault) || $hasDefault)
                    + '<td><input name="special_default" type="radio" class="form-control" /></td>'
@endif
                    + '<td><button type="button" class="btn btn-danger remove-value" data-index="' + index + '">'
                    + '<i class="zmdi zmdi-delete"></i></button></td>' +
                    '</tr>');
            });
            $(document).on('click', '.remove-choice', function () {
                var index = $(this).data('index');
                $("#tr_" + index).remove();
            });
        }
    });
</script>