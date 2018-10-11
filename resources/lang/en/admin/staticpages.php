<?php

/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

return [
    'title' => 'Static pages',
    'staticpages-list' => 'Static pages list',
    'add-page' => 'Add a new page',
    'headers' => [
        'id' => 'ID',
        'slug' => 'Slug',
        'title' => 'Title',
        'date' => 'Date',
        'created_by' => 'Author',
        'delete' => ''
    ],
    'fields' => [
        'slug' => [
            'label' => 'Slug',
            'help' => 'Indicate an unique name without space or special character'
        ],
        'title' => [
            'label' => 'Title'
        ],
        'body' => [
            'label' => 'Body'
        ]
    ],
    'pages-create' => 'Creation of a static page',
    'pages-edit' => 'Edit a static page',
    'modal' => [
        'body' => 'Are you sure you want to delete this static page ? The operation is irreversible !',
        'cancel' => 'Cancel',
        'confirm' => 'Delete',
        'title' => 'Delete static page'
    ]
];

?>