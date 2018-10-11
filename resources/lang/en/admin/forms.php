<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

return [
    'title' => 'Forms',
    'forms-list' => 'Form Versions',
    'headers' => [
        'id' => 'ID',
        'title' => 'Title',
        'author' => 'Author',
        'date' => 'Date',
        'validated' => 'Validated',
        'archived' => 'Archived',
        'inprogress' => 'In progress',
        'counts' => 'Counts',
        'status' => 'Status',
        'actions' => ''
    ],
    'types' => [
        'text' => 'Text field',
        'static' => 'Static html block',
        'model' => 'Choice of response model',
        'file' => 'Download file',
        'type' => 'Project type input',
        'username' => 'Username input',
        'company' => 'Company input',
        'country' => 'Country input',
        'textarea' => 'Long text field',
        'radiogroup' => 'Unique input group',
        'checkboxgroup' => 'Multiple input group',
        'datepicker' => 'Date input',
        'list' => 'Text list input',
        'range' => 'Number input'
    ],
    'fields' => [
        'title' => [
            'label' => 'Title'
        ],
        'headers' => [
            'ordering' => '',
            'name' => 'Name',
            'type' => 'Type',
            'page' => 'Page',
            'required' => 'Required',
            'cnil_required' => 'Legal',
            'date' => 'Date',
            'action' => ''
        ],
        'types' => [
            'text' => 'Text',
            'textarea' => 'Long text'
        ]
    ],
    'pages' => [
        'headers' => [
            'ordering' => '',
            'count' => 'Num',
            'title' => 'Title',
            'fields' => 'Fields',
            'date' => 'Date'
        ]
    ],
    'page' => [
        'title' => 'Page',
        'fields' => [
            'name' => [
                'label' => 'Name'
            ],
            'disclaimer' => [
                'label' => 'Warning'
            ]
        ]
    ],
    'forms' => [
        'modal' => [
            'body' => 'Are you sure you want to delete the draft form? This operation is irreversible!',
            'cancel' => 'Cancel',
            'confirm' => 'Clear',
            'title' => 'Delete draft',
        ],
    ],
    'publish-in-progress' => 'The form is being published...',
    'formpage' => [
        'modal' => [
            'body' => 'Are you sure you want to erase this page? This operation is irreversible and will erase all elements.',
            'cancel' => 'Cancel',
            'confirm' => 'Erase',
            'title' => 'Erase this page'
        ]
    ],
    'formelement' => [
        'modal' => [
            'body' => 'Are you sure you want to erase this field? The operation is irreversible',
            'cancel' => 'Cancel',
            'confirm' => 'Erase',
            'title' => 'Erase field'
        ],
        'choices' => [
            'headers' => [
                'label' => 'Heading',
                'value' => 'Value',
                'default' => 'By default'
            ],
            'add-choice-button' => 'Add a choice',
            'defaultvalue' => 'Default value'
        ],
        'countryspecial' => [
            'only_eea' => [
                'label' => 'Only for European countries',
                'help' => 'Indicate if you wish only European countries in the countries list or all countries'
            ],
            'except_france' => [
                'label' => 'Without France',
                'help' => 'Indicate if you wish France not to be part of the selection'
            ],
            'multiple' => [
                'label' => 'Multiple selection',
                'help' => 'Indicate if we can choose several countries'
            ]
        ],
        'datepickerspecial' => [
            'default_to_now' => [
                'label' => 'Now',
                'help' => 'Indicate if you want the default date to be now, if not, empty.'
            ]
        ],
        'rules' => [
            'select-field' => '-- Choose field --',
            'add-rule-button' => 'Add a display rule',
            'title' => 'Display rules',
            'headers' => [
                'name' => 'Field name',
                'value' => 'Desired field value'
            ]
        ],
        'requirements' => 'Requested field?',
        'special-warning' => 'You must save a first time before managing the choices',
        'special-warning-editor' => 'You must save a first time before managing the static elements'
    ],
    'element' => [
        'title' => 'Field',
        'fields' => [
            'name' => [
                'label' => 'Name',
                'help' => 'Indicate an unique field name'
            ],
            'page' => [
                'label' => 'Page',
                'help' => 'Indicate the page where the field will be displayed'
            ],
            'type' => [
                'label' => 'Type',
                'help' => 'Indicate the field type'
            ],
            'label' => [
                'label' => 'Label',
                'help' => 'Indicate the field label'
            ],
            'tips' => [
                'label' => 'Help',
                'help' => 'Indicate a short text to fill the field'
            ],
            'placeholder' => [
                'label' => 'Placeholder',
                'help' => 'Indicate a short text to fill the field that does not contain value'
            ],
            'default' => [
                'label' => 'Default value',
                'help' => 'Indique the default value'
            ],
            'special' => [
                'label' => 'Complements',
                'help' => 'Indicate additional information'
            ],
            'required' => [
                'label' => 'Mandatory',
                'help' => 'Indicate if this field is mandatory to save the analysis'
            ],
            'cnil_required' => [
                'label' => 'Mandatory for the CNIL',
                'help' => 'Indicate if this field is mandatory to validate the analysis'
            ],
            'show_if_element_id' => [
                'label' => 'Displayed if',
                'help' => 'Indicate a field that must have a given value for it to be displayed',
                'always-show' => 'Always display'
            ],
            'show_if_element_value' => [
                'label' => 'Show if element value',
                'help' => 'Indicate the required field value '
            ],
            'static' => [
                'label' => 'Content'
            ]
        ]
    ],
    'create-button' => 'New version',
    'forms-create' => 'New form version',
    'forms-edit' => 'Edit form',
    'pages-create' => 'New page',
    'pages-edit' => 'Edit page',
    'pages-title' => 'Pages',
    'elements-create' => 'New filed',
    'elements-edit' => 'Field editing',
    'elements-title' => 'Fields',
    'fields-title' => 'Fields',
    'disclaimer' => 'Warning',
    'add-field-modal-title' => 'New field',
    'add-page-modal-title' => 'New page',
    'published-successful' => 'The form version has been correctly published. It will be used as the current version.',
    'published_infos' => 'Published the :date by :publisher',
    'published-error' => 'Impossible to publish this form version',
    'created-successful' => 'New version in draft mode effective', 
    'deleted-successful' => 'Draft of the form correctly deleted'
];

?>
