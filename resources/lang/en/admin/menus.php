<?php

/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

return [
    'title' => 'Menu',
    'menus-list' => 'Menu list',
    'add-page' => 'Add a menu',
    'headers' => [
        'id' => 'ID',
        'title' => 'Title',
        'slug' => 'Slug',
        'date' => 'Date',
        'enabled' => 'Active',
        'disabled' => 'Deactivated',
        'created_by' => 'Authot',
        'delete' => ''
    ],
    'fields' => [
        'slug' => [
            'label' => 'Slug',
            'help' => 'Indicate an unique name without space or special character'
        ],
        'title' => [
            'label' => 'Title'
        ]
    ],
    'menus-create' => 'Menu creation',
    'menus-edit' => 'Menu edition',
    'modal' => [
        'body' => 'Are you sure you want to erase this menu ? The operation is irreversible !',
        'cancel' => 'Cancel',
        'confirm' => 'Erase',
        'title' => 'Erase this menu'
    ]
];

?>