<?php

/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

return [
    'title' => 'Utilisateurs',
    'users-list' => 'Liste des utilisateurs',
    'all-roles' => 'Tous les rôles',
    'roles' => [
        'employee' => 'Salarié',
        'lawyer' => 'Juridique/DPO',
        'admin' => 'Administrateur'
    ],
    'headers' => [
        'key' => 'ID',
        'username' => 'Identifiant',
        'email' => 'Courriel',
        'role' => 'Rôle',
        'fullname' => 'Nom',
        'last_activity' => 'Dernière connexion',
        'statements' => 'Analyses',
        'actions' => ''
    ],
    'never-connected' => 'Jamais',
    'modal' => [
        'body' => 'Êtes-vous sur de vouloir effacer cet utilisateur ? Cette opération est irréversible ! Cela effacera toutes les informations de cet utilisateur, ainsi que les analyses qu\'il aurait effectuées !',
        'cancel' => 'Annuler',
        'confirm' => 'Effacer',
        'title' => 'Effacer cet utilisateur'
    ],
    'updaterole' => [
        'modal' => [
            'body' => 'Etes-vous sur de vouloir modifier le rôle de :fullname en :role ? Cette opération est irréversible !',
            'cancel' => 'Annuler',
            'confirm' => 'Modifier',
            'title' => 'Modifier le rôle'
        ]
    ],
    'export-button' => 'CSV', 
    'mass-assign'     => [
        'modal' => [
            'title' => 'Ré-assignation des analyses en masse',
            'body' => 'Vous êtes sur le point de ré-assigner toutes les analyses concernant l\'utilisateur :fullname, qu\'il en soit le déclarant ou l\'éditeur !',
            'select-new-user' => '- Indiquez le nouvel utilisateur -',
            'cancel'  => 'Annuler',
            'confirm' => 'Ré-assigner',
        ],
    ],
    'legend' => [
        'archived' => 'Nombre d\'analyses archivées pour cet utilisateur',
        'validated' => 'Nombre d\'analyses validées pour cet utilisateur',
        'inprogress' => 'Nombre d\'analyses en cours pour cet utilisateur',
        'supervised' => 'Nombre d\'analyses que cet utilisateur supervise',
    ],
];

?>