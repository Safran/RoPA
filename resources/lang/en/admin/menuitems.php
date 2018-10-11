<?php

/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

return [
    'title' => 'Menus',
    'menuitems-list' => 'List of menu links',
    'add-page' => 'Add menu links',
    'headers' => [
        'id' => 'ID',
        'ordering' => '',
        'title' => 'Title',
        'slug' => 'Slug',
        'date' => 'Date',
        'active' => 'Active',
        'role' => 'Role',
        'created_by' => 'Authot',
        'delete' => ''
    ],
    'fields' => [
        'path' => [
            'label' => 'Url',
            'help' => 'Indicate a unique linked url'
        ],
        'title' => [
            'label' => 'Title'
        ],
        'active' => [
            'label' => 'Active',
            'help' => 'Indicate if the menu must be displayed'
        ],
        'role' => [
            'label' => 'Role',
            'select-all' => 'Public',
            'help' => 'Indicate the minimum role for the link to be displayed'
        ],
        'prefix' => [
            'label' => 'Prefix',
            'help' => 'Indicate a link prefix'
        ]
    ],
    'menuitems-create' => 'Creation of menu link',
    'menuitems-edit' => 'Edit menu link',
    'modal' => [
        'body' => 'Are you sure you want to the erase this menu link? The operation is irreversible !',
        'cancel' => 'Cancel',
        'confirm' => 'Erase',
        'title' => 'Erase menu link'
    ]
];

?>