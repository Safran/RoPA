<?php

/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

return [
    'widgets' => [
        'pending' => [
            'title' => 'Analyses en attente',
            'disclaimer' => 'Retrouvez ici toutes les analyses en attente de prise en charge par le DPO'
        ],
        'inprogress' => [
            'title' => 'Analyses en cours',
            'disclaimer' => 'Finalisez vos analyses en échangeant avec le DPO'
        ],
        'history' => [
            'title' => 'Historique des analyses',
            'disclaimer' => 'Retrouvez l\'ensemble des analyses'
        ]
    ],
    'pendings' => [
        'title' => 'Gestion des analyses',
        'disclaimer' => [
            'employee' => 'N\\\/A',
            'lawyer' => 'Retrouvez toutes les analyses en attente. Aidez les salariés à les renseigner en échangeant avec eux, directement sur l\'outil',
            'admin' => 'Retrouvez toutes les analyses en attente. Aidez les salariés à les renseigner en échangeant avec eux, directement sur l\'outil'
        ],
        'empty' => 'Vous n\'avez pas d\'analyse dans cette section',
        'learn-more' => 'En savoir + sur la protection des données personnelles'
    ],
    'inprogress' => [
        'title' => 'Gestion des analyses',
        'disclaimer' => [
            'employee' => 'Retrouvez toutes les analyses en cours.',
            'lawyer' => 'Retrouvez toutes les analyses en cours. Aidez les salariés à les renseigner en échangeant avec eux, directement sur l\'outil',
            'admin' => 'Retrouvez toutes les analyses en cours. Aidez les salariés à les renseigner en échangeant avec eux, directement sur l\'outil'
        ],
        'empty' => 'Vous n\'avez pas d\'analyse dans cette section',
        'learn-more' => 'En savoir + sur la protection des données personnelles'
    ],
    'finished' => [
        'title' => 'Gestion des analyses',
        'disclaimer' => [
            'employee' => 'Retrouvez toutes les analyses terminée.',
            'lawyer' => 'Retrouvez toutes les analyses terminée. Aidez les salariés à les renseigner en échangeant avec eux, directement sur l\'outil',
            'admin' => 'Retrouvez toutes les analyses terminée. Aidez les salariés à les renseigner en échangeant avec eux, directement sur l\'outil'
        ],
        'empty' => 'Vous n\'avez pas d\'analyse dans cette section',
        'learn-more' => 'En savoir + sur la protection des données personnelles'
    ],
    'save-button' => 'Enregistrer',
    'edit-button' => 'Voir l\'analyse',
    'saved' => 'Votre analyse a été correctement sauvegardée',
    'answer' => [
        'validated' => 'Validé',
        'notvalidated' => 'Non Validé',
        'comment' => 'Commentaire',
        'comment-button' => 'Répondre'
    ],
    'want-to-supervise-button' => 'Superviser cette analyse',
    'supervised' => 'Vous êtes désormais le superviseur de cette analyse',
    'supervised_by' => 'Pris en charge par :supervisor',
    'select-all-statements' => '-- Toutes les analyses --',
    'select-only-mine' => 'Mes analyses',
    'select-all-status' => '-- Toutes les états --',
    'select-only-archived' => 'Archivées',
    'select-only-validated' => 'Validées',
    'select-all-companies' => '-- Toutes les sociétés --',
    'select-all-countries' => '-- Tous les pays --',
    'duplicated' => 'L\'analyse a correctement été dupliquée',
    'filters' => [
        'ownerfilter' => 'Analyses',
        'statusfilter' => 'Etat',
        'companyfilter' => 'Société',
        'countryfilter' => 'Pays'
    ],
    'field-required' => 'Ce champ est obligatoire.',
    'upgraded' => 'Votre analyse a été mise à jour'
];

?>