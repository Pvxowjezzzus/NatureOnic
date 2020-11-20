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
//    'vegies'=> [
//        'controller' => 'main',
//        'action' => 'vegies'
//    ],
//
//    'vegies/{page:\d+}'=> [
//        'controller' => 'main',
//        'action' => 'vegies'
//    ],
//    'nuts'=> [
//        'controller' => 'main',
//        'action' => 'nuts'
//    ],
//    'nuts/{page:\d+}'=> [
//        'controller' => 'main',
//        'action' => 'nuts'
//    ],
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