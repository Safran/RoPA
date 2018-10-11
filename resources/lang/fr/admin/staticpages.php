<?php

/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

return [
    'title' => 'Pages statiques',
    'staticpages-list' => 'Liste des pages statiques',
    'add-page' => 'Ajouter une nouvelle page',
    'headers' => [
        'id' => 'ID',
        'slug' => 'Slug',
        'title' => 'Titre',
        'date' => 'Date',
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
        ],
        'body' => [
            'label' => 'Corps'
        ]
    ],
    'pages-create' => 'Création de page statique',
    'pages-edit' => 'Edition de page statique',
    'modal' => [
        'body' => 'Etes-vous sur de vouloir effacer cette page statique ? Cette opération est irreversible !',
        'cancel' => 'Annuler',
        'confirm' => 'Effacer',
        'title' => 'Effacer cette page statique'
    ]
];

?>