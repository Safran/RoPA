<?php

/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

return [
    'title' => 'Menus',
    'menuitems-list' => 'Liste des liens de menu',
    'add-page' => 'Ajouter un liens de menu',
    'headers' => [
        'id' => 'ID',
        'ordering' => '',
        'title' => 'Titre',
        'slug' => 'Slug',
        'date' => 'Date',
        'active' => 'Activé',
        'role' => 'Rôle',
        'created_by' => 'Auteur',
        'delete' => ''
    ],
    'fields' => [
        'path' => [
            'label' => 'Url',
            'help' => 'Indiquer une url relative unique'
        ],
        'title' => [
            'label' => 'Titre'
        ],
        'active' => [
            'label' => 'Activé',
            'help' => 'Indiquer si le menu doit s\'afficher'
        ],
        'role' => [
            'label' => 'Rôle',
            'select-all' => 'Publique',
            'help' => 'Indiquer le role minimu à avoir pour que le lien soit affiché'
        ],
        'prefix' => [
            'label' => 'Prefix',
            'help' => 'Indiquer un prefix de lien'
        ]
    ],
    'menuitems-create' => 'Création d\'un liens de menu',
    'menuitems-edit' => 'Edition d\'un liens de menu',
    'modal' => [
        'body' => 'Etes-vous sur de vouloir effacer ce lien de menu? Cette opération est irreversible !',
        'cancel' => 'Annuler',
        'confirm' => 'Effacer',
        'title' => 'Effacer ce lien de menu'
    ]
];

?>