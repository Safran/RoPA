<?php

/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

return [
    'accepted' => 'The field :attribute must be accepted',
    'active_url' => 'The field :attribute is not a valid URL.',
    'after' => 'The field :attribute must be a later date than au :date.',
    'after_or_equal' => 'The field :attribute must be an equal or later date than :date.',
    'alpha' => 'The field :attribute must contain only letters.',
    'alpha_dash' => 'The field :attribute must contain only letters, numbers and dashes.',
    'alpha_num' => 'The field :attribute must contain only letters and numbers.',
    'array' => 'The field :attribute must be a table.',
    'before' => 'The field :attribute must be a date prior to :date.',
    'before_or_equal' => 'The field :attribute must be a date equal or prior to :date.',
    'between' => [
        'numeric' => 'The value of :attribute must be within :min and :max.',
        'file' => 'The size of the :attribute file must be from :min to :max kilo-octets.',
        'string' => 'The text :attribute must contain from :min to :max characters.',
        'array' => 'The table :attribute must contain from :min to :max elements.'
    ],
    'boolean' => 'The field :attribute must be true or false.',
    'confirmed' => 'The confirmation field :attribute does not match.',
    'date' => 'The field :attribute is not a valid date.',
    'date_format' => 'The field :attribute does not match the :format format.',
    'different' => 'The fields :attribute and :other must be different.',
    'digits' => 'The field :attribute must contain :digits numbers.',
    'digits_between' => 'The field :attribute must contain from :min to :max numbers.',
    'dimensions' => 'The picture size :attribute is not consistent.',
    'distinct' => 'The field :attribute has a doubled value.',
    'email' => 'The field :attribute must be a valid email address.',
    'exists' => 'The selected field :attribute is not valid.',
    'file' => 'The field :attribute must be a file.',
    'filled' => 'The field :attribute must have a value.',
    'image' => 'The field :attribute must be a picture.',
    'in' => 'The field :attribute is not valid.',
    'in_array' => 'The field :attribute does not exist in :other.',
    'integer' => 'The field :attribute mus be whole.',
    'ip' => 'The field :attribute must be a valid IP.',
    'ipv4' => 'The field :attribute must be a valid IPv4.',
    'ipv6' => 'The field :attribute must be a valid IPv6.',
    'json' => 'The field :attribute must be a valid JSON document.',
    'max' => [
        'numeric' => 'The value of :attribute cannot be superior to :max.',
        'file' => 'The file size :attribute cannot be more than :max kilo-octets.',
        'string' => 'Le texte de :attribute cannot contain more than :max characters.',
        'array' => 'Le tableau :attribute cannot contain more than :max elements.'
    ],
    'mimes' => 'The field :attribute must be a : :values file type.',
    'mimetypes' => 'The field :attribute must be a : :values file type.',
    'min' => [
        'numeric' => 'The value of :attribute must be equal or superior to :min.',
        'file' => 'The file size of :attribute must be superior to :min kilo-octets.',
        'string' => 'The text :attribute must contain at least :min characters.',
        'array' => 'The table :attribute must contain at least :min elements.'
    ],
    'not_in' => 'The selected :attribute field is not valid.',
    'numeric' => 'The field :attribute must contain a number.',
    'present' => 'The field :attribute must be present.',
    'regex' => 'The field format :attribute is not valid.',
    'required' => 'The field :attribute is mandatory.',
    'required_if' => 'The field :attribute is mandatory when the value of :other is :value.',
    'required_unless' => 'The field :attribute is mandatory except if :other is :values.',
    'required_with' => 'The field :attribute is mandatory when :values is present.',
    'required_with_all' => 'The field :attribute is mandatory when :values is present.',
    'required_without' => 'The field :attribute is mandatory when :values is not present.',
    'required_without_all' => 'The field :attribute is requested when none of :values is present.',
    'same' => 'The fields :attribute and :other must be identical.',
    'size' => [
        'numeric' => 'The value of :attribute must be :size.',
        'file' => 'The file size of :attribute must be of :size kilo-octets.',
        'string' => 'The text of :attribute must contain :size caractères.',
        'array' => 'The table :attribute must contain :size elements.'
    ],
    'string' => 'The field :attribute must be a character string.',
    'timezone' => 'The field :attribute must be a valid time zone.',
    'unique' => 'The value of the :attribute field is already used.',
    'uploaded' => 'The field file of :attribute could not be downloaded.',
    'url' => 'The URL format of :attribute is not valid.',
    'uripath' => 'The file path format of :attribute is not valid.',
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message'
        ],
        'attachment' => [
            'mimes' => 'The attached file must be in the following format : :values.',
            'mimetypes' => 'The attached file must be in the following format : :values.'
        ]
    ],
    'attributes' => [
        'name' => 'Name',
        'username' => 'Username',
        'email' => 'Email',
        'first_name' => 'First name',
        'last_name' => 'Last name',
        'password' => 'Password',
        'password_confirmation' => 'Password confirmation',
        'city' => 'City',
        'country' => 'Country',
        'address' => 'Address',
        'phone' => 'Phone number',
        'mobile' => 'Mobilephone number',
        'age' => 'Age',
        'sex' => 'Sexe',
        'gender' => 'Gender',
        'day' => 'Day',
        'month' => 'Month',
        'year' => 'Year',
        'hour' => 'Hour',
        'minute' => 'Minute',
        'second' => 'Second',
        'title' => 'Title',
        'content' => 'Content',
        'description' => 'Description',
        'excerpt' => 'Extract',
        'date' => 'Date',
        'time' => 'Hour',
        'available' => 'Available',
        'size' => 'Size'
    ]
];

?>