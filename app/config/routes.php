<?php
return [
    ''=> [
    'controller' => 'main',
    'action' => 'index'
    ],
    'fruits'=> [
        'controller' => 'main',
        'action' => 'fruits'
    ],
    'fruits/{page:\d+}'=> [
        'controller' => 'main',
        'action' => 'fruits'
    ],
    'vegies'=> [
        'controller' => 'main',
        'action' => 'vegies'
    ],
    'nuts'=> [
        'controller' => 'main',
        'action' => 'nuts'
    ],
    'admin/login' => [
        'controller' => 'admin',
        'action' => 'auth'
    ],
    'admin/logout' => [
        'controller' => 'admin',
        'action' => 'logout',
    ],

    'admin-panel' => [
        'controller' => 'admin',
        'action' => 'admin'
    ],
    'admin/items' => [
        'controller' => 'admin',
        'action' => 'items',
    ],
    'admin/items/add' => [
        'controller' => 'admin',
        'action' => 'itemAdd',
    ],
    'admin/items/delete/{cat:\w+}/{id:\d+}' => [
        'controller' => 'admin',
        'action' => 'itemDelete',
    ]
];