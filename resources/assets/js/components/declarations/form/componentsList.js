/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


import Vue from 'vue'

import DatepickerField from './fields/DatepickerField'
import TextField from './fields/TextField'
import TypeField from './fields/TypeField'
import ModelField from './fields/ModelField'
import CompanyField from './fields/CompanyField'
import UsernameField from './fields/UsernameField'
import CountryField from './fields/CountryField'
import RadiogroupField from './fields/RadiogroupField'
import TextareaField from './fields/TextareaField'
import CheckboxgroupField from './fields/CheckboxgroupField'
import ListField from './fields/ListField'
import StaticField from './fields/StaticField'
import FileField from './fields/FileField'

export let componentsList = {
    DatepickerField: Vue.component('datepicker-field', DatepickerField),
    TextField: Vue.component('text-field', TextField),
    TypeField: Vue.component('type-field', TypeField),
    ModelField: Vue.component('model-field', ModelField),
    CompanyField: Vue.component('company-field', CompanyField),
    UsernameField: Vue.component('username-field', UsernameField),
    CountryField: Vue.component('country-field', CountryField),
    RadiogroupField: Vue.component('radiogroup-field', RadiogroupField),
    TextareaField: Vue.component('textarea-field', TextareaField),
    CheckboxgroupField: Vue.component('checkboxgroup-field', CheckboxgroupField),
    StaticField: Vue.component('static-field', StaticField),
    ListField: Vue.component('list-field', ListField),
    FileField: Vue.component('file-field', FileField),
};


export default {};
