<?php

/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

return [
    'login-title' => 'Log-in !',
    'title' => 'Identification',
    'fields' => [
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter in your email'
        ],
        'username' => [
            'label' => 'User ID',
            'placeholder' => 'Enter your user ID'
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Enter your password'
        ]
    ],
    'login-button' => 'Connection',
    'not-allowed' => 'You are not allowed to fulfill this task',
    'failed' => 'These identifiers do not match our records',
    'throttle' => 'Connection attempts are excessive. Please try again in :seconds seconds.'
];

?>