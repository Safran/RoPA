<?php

/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

return [
    'title' => 'Administration Panel',
    'statements' => [
        'title' => 'Analyses',
        'headers' => [
            'id' => 'ID',
            'project' => 'Project',
            'status' => 'State',
            'author' => 'Author',
            'owner' => 'Person in charge',
            'supervisor' => 'Supervisor',
            'company' => 'Company',
            'state' => 'State',
            'date' => 'Date',
            'actions' => '...'
        ],
        'modal' => [
            'body' => 'Are you sure you want to erase this analysis? This operation is irreversible.',
            'cancel' => 'Cancel',
            'confirm' => 'Delete',
            'title' => 'Delete this analysis'
        ]
    ]
];

?>