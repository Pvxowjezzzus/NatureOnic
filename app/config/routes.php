<?php
return [
    ''=> [
    'controller' => 'main',
    'action' => 'index'
    ],
    'request/send' => [
        'controller' => 'main',
        'action' => 'request'
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
    'admin/profile'=> [
    'controller' => 'admin',
    'action' => 'profile'
    ],
    'admin/requests' =>[
        'controller' => 'admin',
	    'action' => 'requests'
    ],
    'admin/items' => [
        'controller' => 'admin',
        'action' => 'items'
    ],
    'admin/items/add' => [
        'controller' => 'admin',
        'action' => 'itemAdd',
    ],
    'admin/items/types/add' => [
        'controller' => 'admin',
        'action' => 'typeAdd',
    ],
    'admin/items/delete/{id:\d+}' => [
        'controller' => 'admin',
        'action' => 'itemDelete',
    ],
    'admin/items/edit/{id:\d+}' => [
        'controller' => 'admin',
        'action' => 'itemEdit',
    ],
    'get-diagram' => [
        'controller' => 'admin',
        'action' => 'getDiagram'
    ],
    'admin/change/email' => [
        'controller' => 'admin',
        'action' => 'changeEmail',
    ],
    'admin/change/password' => [
        'controller' => 'admin',
        'action' => 'changePassword',
    ]

];
?>