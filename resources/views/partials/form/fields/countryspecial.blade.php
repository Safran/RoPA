{{ bs()->formGroup(bs()->checkBox('only_eea', __('admin/forms.formelement.countryspecial.only_eea.label'), old('required', ((isset($settings) && isset($settings->only_eea)) ? (bool)$settings->only_eea : false))))
->helpText(__('admin/forms.formelement.countryspecial.only_eea.help')) }}
{{ bs()->formGroup(bs()->checkBox('multiple', __('admin/forms.formelement.countryspecial.multiple.label'), old('required', ((isset($settings) && isset($settings->multiple)) ? (bool)$settings->multiple : false))))
->helpText(__('admin/forms.formelement.countryspecial.multiple.help')) }}