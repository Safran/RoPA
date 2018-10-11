<?php

/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

return [
    'title' => 'Formulaires',
    'forms-list' => 'Versions du formulaire',
    'headers' => [
        'id' => 'ID',
        'title' => 'Titre',
        'author' => 'Auteur',
        'date' => 'Date',
        'validated' => 'Validée',
        'archived' => 'Archivée',
        'inprogress' => 'En cours',
        'counts' => 'Comptes',
        'status' => 'Etat',
        'actions' => ''
    ],
    'types' => [
        'text' => 'Champ texte',
        'static' => 'Bloc html statique',
        'model' => 'Choix du modèle de réponses',
        'file' => 'Téléchargement fichier',
        'type' => 'Saisie du type de projet',
        'username' => 'Saisie d\' un utilisateur',
        'company' => 'Saisie d\'une société',
        'country' => 'Saisie d\'un pays',
        'textarea' => 'Champ texte long',
        'radiogroup' => 'Groupe de saisie unique',
        'checkboxgroup' => 'Groupe de saisie multiple',
        'datepicker' => 'Saisie d\'une date',
        'list' => 'Saisie d\'une liste de texte',
        'range' => 'Saisie d\'un nombre'
    ],
    'fields' => [
        'title' => [
            'label' => 'Titre'
        ],
        'headers' => [
            'ordering' => '',
            'name' => 'Nom',
            'type' => 'Type',
            'page' => 'Page',
            'required' => 'Requis',
            'cnil_required' => 'Légal',
            'date' => 'Date',
            'action' => ''
        ],
        'types' => [
            'text' => 'Texte',
            'textarea' => 'Texte long'
        ]
    ],
    'pages' => [
        'headers' => [
            'ordering' => '',
            'count' => 'Num',
            'title' => 'Titre',
            'fields' => 'Champs',
            'date' => 'Date'
        ]
    ],
    'page' => [
        'title' => 'Page',
        'fields' => [
            'name' => [
                'label' => 'Nom'
            ],
            'disclaimer' => [
                'label' => 'Avertissement'
            ]
        ]
    ],
    'form' => [
        'modal' => [
            'body'    => 'Etes-vous sûr de vouloir effacer le brouillon de formulaire ? Cette opération est irréversible !',
            'cancel'  => 'Annuler',
            'confirm' => 'Effacer',
            'title'   => 'Effacer le brouillon',
        ],
    ],
    'publish-in-progress' => 'Le formulaire est en cours de publication...',
    'formpage' => [
        'modal' => [
            'body' => 'Etes-vous sur de vouloir effacer cette page ? Cette opération est irréversible et effacera les éléments qui la composent.',
            'cancel' => 'Annuler',
            'confirm' => 'Effacer',
            'title' => 'Effacer cette page'
        ]
    ],
    'formelement' => [
        'modal' => [
            'body' => 'Etes-vous sur de vouloir effacer ce champ ? Cette opération est irréversible !',
            'cancel' => 'Annuler',
            'confirm' => 'Effacer',
            'title' => 'Effacer ce champ'
        ],
        'choices' => [
            'headers' => [
                'label' => 'Intitulé',
                'value' => 'Valeur',
                'default' => 'Par défaut'
            ],
            'add-choice-button' => 'Ajouter un choix',
            'defaultvalue' => 'Valeur par défaut'
        ],
        'countryspecial' => [
            'only_eea' => [
                'label' => 'Uniquement les pays Européens',
                'help' => 'Indiquez si vous ne désirez que les pays européens dans la liste des pays ou tous les pays du monde'
            ],
            'except_france' => [
                'label' => 'Sans la france',
                'help' => 'Indiquez si vous désirez que la France ne fasse pas partie de la sélection'
            ],
            'multiple' => [
                'label' => 'Sélection multiple',
                'help' => 'Indiquez si l\'on peut choisir plusieurs pays.'
            ]
        ],
        'datepickerspecial' => [
            'default_to_now' => [
                'label' => 'Maintenant',
                'help' => 'Indiquez si vous désirez que la date par défaut soit à maintenant, sinon vide.'
            ]
        ],
        'rules' => [
            'select-field' => '-- Sélectionnez le champ --',
            'add-rule-button' => 'Ajouter une règle d\'affichage',
            'title' => 'Règle(s) d\'affichage',
            'headers' => [
                'name' => 'Nom du champ',
                'value' => 'Valeur souhaité du champ'
            ]
        ],
        'requirements' => 'Champs requis ?',
        'special-warning' => 'Vous devez sauvegarder une première fois pour gérer les choix',
        'special-warning-editor' => 'Vous devez sauvegarder une première fois avant de gérer votre élément statique'
    ],
    'element' => [
        'title' => 'Champ',
        'fields' => [
            'name' => [
                'label' => 'Nom',
                'help' => 'Indiquer un nom undique de champ'
            ],
            'page' => [
                'label' => 'Page',
                'help' => 'Indiquer la page où apparaitra ce champ'
            ],
            'type' => [
                'label' => 'Type',
                'help' => 'Indiquer le type de champ'
            ],
            'label' => [
                'label' => 'Etiquette',
                'help' => 'Indiquer l\'étiquette du champ'
            ],
            'tips' => [
                'label' => 'Aide',
                'help' => 'Indiquer un court texte d\'aide pour remplir le champ'
            ],
            'placeholder' => [
                'label' => 'Placeholder',
                'help' => 'Indiquer un court texte qui remplira le champ s\'il ne contient pas de valeur'
            ],
            'default' => [
                'label' => 'Valeur par défaut',
                'help' => 'Indiquer la valeur par défaut'
            ],
            'special' => [
                'label' => 'Compléments',
                'help' => 'Indiquer les informations complémentaires'
            ],
            'required' => [
                'label' => 'Obligatoire',
                'help' => 'Indiquer si ce champ est obligatoire pour sauvegarder l\'analyse'
            ],
            'cnil_required' => [
                'label' => 'Obligatoire pour la CNIL',
                'help' => 'Indiquer si ce champ est obligatoire pour valider l\'analyse'
            ],
            'show_if_element_id' => [
                'label' => 'S\'affiche si ',
                'help' => 'Indiquer un champ qui doit avoir une certaine valeur pour que celui-ci s\'affiche',
                'always-show' => 'Toujours afficher'
            ],
            'show_if_element_value' => [
                'label' => 'à la valeur ',
                'help' => 'Indiquer la valeur que doit avoir le champ'
            ],
            'static' => [
                'label' => 'Contenu'
            ]
        ]
    ],
    'create-button' => 'Nouvelle version',
    'forms-create' => 'Nouvelle version de formulaire',
    'forms-edit' => 'Edition formulaire',
    'pages-create' => 'Nouvelle page',
    'pages-edit' => 'Edition page',
    'pages-title' => 'Pages',
    'elements-create' => 'Nouveau champ',
    'elements-edit' => 'Edition d\'un champ',
    'elements-title' => 'Champs',
    'fields-title' => 'Champs',
    'disclaimer' => 'Avertissements',
    'add-field-modal-title' => 'Nouveau champ',
    'add-page-modal-title' => 'Nouvelle page',
    'published-successful' => 'La version de formulaire a correctement été publiée. Elle sera utilisé comme version actuelle.',
    'published_infos' => 'Publiée le :date par :publisher',
    'published-error' => 'Impossible de publier cette version de formulaire',
    'created-successful' => 'Nouvelle version en mode brouillon effective', 
    'deleted-successful'    => 'Brouillon du formulaire correctement effacé',
];

?>
