<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

return [
    'title' => 'Users',
    'users-list' => 'Users list',
    'all-roles' => 'All roles',
    'roles' => [
        'employee' => 'Employee',
        'lawyer' => 'Legal/DPO',
        'admin' => 'Administrator'
    ],
    'headers' => [
        'key' => 'ID',
        'username' => 'User ID',
        'email' => 'Email',
        'role' => 'Role',
        'fullname' => 'Name',
        'last_activity' => 'Last connection',
        'statements' => 'Analyses',
        'actions' => ''
    ],
    'never-connected' => 'Never',
    'modal' => [
        'body' => 'Are you sure you want to delete this user ? The operation is irreversible and will delete all user information and the analyses !',
        'cancel' => 'Cancel',
        'confirm' => 'Erase',
        'title' => 'Delete this user'
    ],
    'updaterole' => [
        'modal' => [
            'body' => 'Are you sure you want to modify the role of :fullname as :role ? This operation is irreversible !',
            'cancel' => 'Cancel',
            'confirm' => 'Modify',
            'title' => 'Modify role '
        ]
    ],
    'export-button' => 'CSV', 
    'mass-assign' => [
        'modal' => [
            'title' => 'Re-assign analyses in bulk',
            'body' => 'You are about to re-assign all the delcaration of :fullname, whether he is the declarant or the editor !',
            'select-new-user' => '- Indicate the new user -',
            'cancel' => 'Cancel',
            'confirm' => 'Re-assign'
        ]
    ],
    'legend' => [
        'archived' => 'Number of archived analyses of the user',
        'validated' => 'Number of validated analyses of the user',
        'inprogress' => 'Number of on-going analyses of the user',
        'supervised' => 'Number of analyses supervised by this user'
    ]
];

?>