<?php

/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

return [
    'title' => 'Menus',
    'menus-list' => 'Liste des menus',
    'add-page' => 'Ajouter un menu',
    'headers' => [
        'id' => 'ID',
        'title' => 'Titre',
        'slug' => 'Slug',
        'date' => 'Date',
        'enabled' => 'Activé',
        'disabled' => 'Désactivé',
        'created_by' => 'Auteur',
        'delete' => ''
    ],
    'fields' => [
        'slug' => [
            'label' => 'Slug',
            'help' => 'Indiquer un nom unique sans espace ou caractères spéciaux'
        ],
        'title' => [
            'label' => 'Titre'
        ]
    ],
    'menus-create' => 'Création d\'un menu',
    'menus-edit' => 'Edition d\'un menu',
    'modal' => [
        'body' => 'Etes-vous sur de vouloir effacer ce menu ? Cette opération est irreversible !',
        'cancel' => 'Annuler',
        'confirm' => 'Effacer',
        'title' => 'Effacer ce menu'
    ]
];

?>