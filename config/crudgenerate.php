<?php

return [

    'paths' => [
        'models'      => 'Models' . DIRECTORY_SEPARATOR, 
        'controllers' => 'Http'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR,
        'views'       => 'resources'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR,
        'routes'      => 'resources'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'router'.DIRECTORY_SEPARATOR.'index.js',
        'apis'        => 'routes'.DIRECTORY_SEPARATOR.'api.php',
        'templates'   => 'resources'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR
    ],

    'cols' => [
        'createdAt'   => '',
        'updatedAt'   => '',
        'hiddenCols'  => ['created_at', 'updated_at']
    ],

    'actions' => [
        'index', 'show', 'store', 'edit', 'update', 'destroy'
    ]
];