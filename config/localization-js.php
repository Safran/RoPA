<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






return [

    /*
     * Set the names of files you want to add to generated javascript.
     * Otherwise all the files will be included.
     *
     * 'messages' => [
     *     'validation',
     *     'forum/thread',
     * ],
     */
    'messages' => [
		'locale',
	    'validation',
    ],

    /*
     * The default path to use for the generated javascript.
     */
    //'path' => resource_path('assets/js/messages.js'),
    'path' => public_path('js/messages.json'),
];
