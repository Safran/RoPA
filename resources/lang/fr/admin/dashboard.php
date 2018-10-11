<?php

/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

return [
    'title' => 'Panneau d\'administration',
    'statements' => [
        'title' => 'Analyses',
        'headers' => [
            'id' => 'ID',
            'project' => 'Projet',
            'status' => 'Etat',
            'author' => 'Auteur',
            'owner' => 'Responsable',
            'supervisor' => 'Superviseur',
            'company' => 'Société',
            'state' => 'Etat',
            'date' => 'Date',
            'actions' => '...'
        ],
        'modal' => [
            'body' => 'Etes-vous sur de vouloir effacer cette analyse ? Cette opération est irréversible.',
            'cancel' => 'Annuler',
            'confirm' => 'Effacer',
            'title' => 'Effacer cette analyse'
        ]
    ]
];

?>