<?php
return [
    ''=> [
    'controller' => 'main',
    'action' => 'index'
    ],
    'stuff/{cat:\w+}'=> [
        'controller' => 'main',
        'action' => 'stuff'
    ],
    'stuff/{cat:\w+}/{page:\d+}'=> [
        'controller' => 'main',
        'action' => 'stuff'
    ],
    'admin/login' => [
        'controller' => 'admin',
        'action' => 'auth'
    ],
    'admin/signup' => [
        'controller' => 'admin',
        'action' => 'signup'
    ],
    'admin/logout' => [
        'controller' => 'admin',
        'action' => 'logout',
    ],

    'admin' => [
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
    'admin/items/types/add' => [
        'controller' => 'admin',
        'action' => 'typeAdd',
    ],
    'admin/items/delete/{cat:\w+}/{id:\d+}' => [
        'controller' => 'admin',
        'action' => 'itemDelete',
    ],
    'admin/items/edit/{cat:\w+}/{id:\d+}' => [
        'controller' => 'admin',
        'action' => 'itemEdit',
    ]

];