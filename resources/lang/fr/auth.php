<?php

/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

return [
    'login-title' => 'Connectez-vous !',
    'title' => 'Identification',
    'fields' => [
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Entrez votre email'
        ],
        'username' => [
            'label' => 'Identifiant',
            'placeholder' => 'Entrez votre identifiant'
        ],
        'password' => [
            'label' => 'Mot de passe',
            'placeholder' => 'Entrez votre mot de passe'
        ]
    ],
    'login-button' => 'Connexion',
    'not-allowed' => 'Vous n\'avez pas l\'autorisation d\'effectuer cette tâche.',
    'failed' => 'Ces identifiants ne correspondent pas à nos enregistrements',
    'throttle' => 'Tentatives de connexion trop nombreuses. Veuillez essayer de nouveau dans :seconds secondes.'
];

?>