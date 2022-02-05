<?php

return [
    'roles' => [
        1 => 'Admin',
        2 => 'Operador',
        3 => 'Mensajero',
        4 => 'Cliente',
    ],
    'modules' => [
        'Dashboard' => [
            'name' => 'Dashboard', 'reference' => 'dashboard', 'icon' => '', 'position' => '1', 'children' => [],
        ],
        'Orders' => [
            'name' => 'Ordenes', 'reference' => 'orders', 'icon' => '', 'position' => '2', 'children' => [],
        ],
        'Customers' => [
            'name' => 'Clientes', 'reference' => 'customers', 'icon' => '', 'position' => '3',
            'children' => [
                'userBanks' => [
                    'name' => 'Usuario banco', 'reference' => 'userBanks', 'icon' => '', 'position' => '1', 'children' => [],
                ]
            ],
        ],
        'Messengers' => [
            'name' => 'Mensajeros', 'reference' => 'messengers', 'icon' => '', 'position' => '4', 'children' => [],
        ],
        'Users' => [
            'name' => 'Usuarios', 'reference' => 'users', 'icon' => '', 'position' => '5', 'children' => [],
        ],
        'Parameters' => [
            'name' => 'Parametros', 'reference' => 'parameters', 'icon' => '', 'position' => '6', 'children' => [],
        ],
        'Rates' => [
            'name' => 'Tarifas', 'reference' => 'rates', 'icon' => '', 'position' => '7', 'children' => [],
        ],
        'Zones' => [
            'name' => 'Zonas', 'reference' => 'zones', 'icon' => '', 'position' => '8', 'children' => [],
        ],
        'Reports' => [
            'name' => 'Informes', 'reference' => 'reports', 'icon' => '', 'position' => '9', 'children' => [],
        ],


        // 1 => 'Dashboard',
        // 2 => 'Ordenes',
        // 3 => 'Mensajeros',
        // 4 => 'Clientes',
        // 5 => 'Tarifas',
        // 6 => '',
    ],
    'months' => [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre',
    ],
    'days' => [
        0 => 'Domingo',
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miercoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sabado',
    ],
    'parameters' => [
        'document_type' => [
            'C.C',
            'C.E',
            'P.P',
            'RUC'
        ],
        'action' => [
            'all',
            'index',
            'create',
            'store',
            'show',
            'delete',
            'update',
            'edit',
            'assignate',
            'import',
            'export'
        ]
    ]

];
