<?php

/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

return [
    'widgets' => [
        'pending' => [
            'title' => 'Pending analyses',
            'disclaimer' => 'Find here all pending analyses to be evaluated by the DPO'
        ],
        'inprogress' => [
            'title' => 'Ongoing analyses',
            'disclaimer' => 'Complete your analyses by contacting the DPO'
        ],
        'history' => [
            'title' => 'History of analyses',
            'disclaimer' => 'Find all analyses'
        ]
    ],
    'pendings' => [
        'title' => 'Manage the analyses',
        'disclaimer' => [
            'employee' => 'N/A',
            'lawyer' => 'Find all pending analyses. Help the employees to fill-in the form by exchanging with them, directly on the tool.',
            'admin' => 'Find all pending analyses. Help the employees to fill-in the form by exchanging with them, directly on the tool.'
        ],
        'empty' => 'You have no analysis in this section',
        'learn-more' => 'Know more about personal data protection'
    ],
    'inprogress' => [
        'title' => 'Management of analyses',
        'disclaimer' => [
            'employee' => 'Find all ongoing analyses',
            'lawyer' => 'Find all ongoing analyses. Help the employees to fill-in the form by exchanging with them, directly on the tool.',
            'admin' => 'Find all ongoing analyses. Help the employees to fill-in the form by exchanging with them, directly on the tool.'
        ],
        'empty' => 'You have no analysis in this section',
        'learn-more' => 'Know more about personal data protection'
    ],
    'finished' => [
        'title' => 'Analyses management',
        'disclaimer' => [
            'employee' => 'Find all finalised analyses',
            'lawyer' => 'Find all finalised analyses. Help the employees to fill-in the form by exchanging with them, directly on the tool.',
            'admin' => 'Find all finalised analyses. Help the employees to fill-in the form by exchanging with them, directly on the tool.'
        ],
        'empty' => 'You have no analysis in this section',
        'learn-more' => 'Know more about personal data protection'
    ],
    'save-button' => 'Save',
    'edit-button' => 'See the analysis',
    'saved' => 'Your analysis has been correctly saved.',
    'answer' => [
        'validated' => 'Validated',
        'notvalidated' => 'Not validated',
        'comment' => 'Comment',
        'comment-button' => 'Answer'
    ],
    'want-to-supervise-button' => 'Supervise this analysis',
    'supervised' => 'Your are now the supervisor of this analysis',
    'supervised_by' => 'Supervised by :supervisor',
    'select-all-statements' => '-- All analyses --',
    'select-only-mine' => 'My analyses',
    'select-all-status' => '-- All status --',
    'select-only-archived' => 'Archived',
    'select-only-validated' => 'Validated',
    'select-all-companies' => '-- All companies --',
    'select-all-countries' => '-- all countries --',
    'duplicated' => 'The analysis has been successfully duplicated',
    'filters' => [
        'ownerfilter' => 'Analyses',
        'statusfilter' => 'Status',
        'companyfilter' => 'Company',
        'countryfilter' => 'Country'
    ],
    'field-required' => 'This field is mandatory',
    'upgraded' => 'Your analysis has been updated'
];

?>