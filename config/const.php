<?php

use App\Permission;

return [
    'roles' => [
        1 => 'Admin',
        2 => 'Operador',
        3 => 'Mensajero',
        4 => 'Cliente',
    ],
    'modules' => [
        'dashboard' => [
            'name' => 'Dashboard', 'reference' => 'dashboard', 'icon' => '', 'position' => '1',
            'children' => [],
            'permission' => [
                'Admin' =>  ['role_id' => 1, 'actions' => '6'],
                'Operador' => ['role_id' => 2, 'actions' => '6'],
                'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                'Cliente' => ['role_id' => 4, 'actions' => '6'],
            ],
        ],
        'orders' => [
            'name' => 'Ordenes', 'reference' => 'orders', 'icon' => '', 'position' => '2',
            'children' => [],
            'permission' => [
                'Admin' =>  ['role_id' => 1, 'actions' => '6,7,8,9,10,11,12,13'],
                'Operador' => ['role_id' => 2, 'actions' => '6'],
                'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                'Cliente' => ['role_id' => 4, 'actions' => '6'],
            ]
        ],
        'customers' => [
            'name' => 'Clientes', 'reference' => 'customers', 'icon' => '', 'position' => '3',
            'children' => [
                'bankUsers' => [
                    'name' => 'Usuario banco', 'reference' => 'bankUsers', 'icon' => '', 'position' => '1',
                    'children' => [],
                    'permission' => [
                        'Admin' =>  ['role_id' => 1, 'actions' => '6,7,8,9,10,11,12,13'],
                        'Operador' => ['role_id' => 2, 'actions' => '6'],
                        'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                        'Cliente' => ['role_id' => 4, 'actions' => '6'],
                    ]
                ],
                'branchOffices' => [
                    'name' => 'Sucursales', 'reference' => 'branchOffices', 'icon' => '', 'position' => '1',
                    'children' => [
                        'departments' => [
                            'name' => 'Departamentos', 'reference' => 'departments', 'icon' => '', 'position' => '1',
                            'children' => [],
                            'permission' => [
                                'Admin' =>  ['role_id' => 1, 'actions' => '6,7,8,9,10,11,12,13'],
                                'Operador' => ['role_id' => 2, 'actions' => '6'],
                                'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                                'Cliente' => ['role_id' => 4, 'actions' => '6'],
                            ]
                        ]
                    ],
                    'permission' => [
                        'Admin' =>  ['role_id' => 1, 'actions' => '6,7,8,9,10,11,12,13'],
                        'Operador' => ['role_id' => 2, 'actions' => '6'],
                        'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                        'Cliente' => ['role_id' => 4, 'actions' => '6'],
                    ]
                ],

            ],
            'permission' => [
                'Admin' =>  ['role_id' => 1, 'actions' => '6,7,8,9,10,11,12,13'],
                'Operador' => ['role_id' => 2, 'actions' => '6'],
                'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                'Cliente' => ['role_id' => 4, 'actions' => '6'],
            ]
        ],
        'messengers' => [
            'name' => 'Mensajeros', 'reference' => 'messengers', 'icon' => '', 'position' => '4',
            'children' => [],
            'permission' => [
                'Admin' =>  ['role_id' => 1, 'actions' => '6,7,8,9,10,11,12,13'],
                'Operador' => ['role_id' => 2, 'actions' => '6'],
                'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                'Cliente' => ['role_id' => 4, 'actions' => '6'],
            ]
        ],
        'users' => [
            'name' => 'Usuarios', 'reference' => 'users', 'icon' => '', 'position' => '5',
            'children' => [],
            'permission' => [
                'Admin' =>  ['role_id' => 1, 'actions' => '6,7,8,9,10,11,12,13'],
                'Operador' => ['role_id' => 2, 'actions' => '6'],
                'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                'Cliente' => ['role_id' => 4, 'actions' => '6'],
            ]
        ],
        'parameters' => [
            'name' => 'Parametros', 'reference' => 'parameters', 'icon' => '', 'position' => '6',
            'children' => [],
            'permission' => [
                'Admin' =>  ['role_id' => 1, 'actions' => '6,7,8,9,10,11,12,13'],
                'Operador' => ['role_id' => 2, 'actions' => '6'],
                'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                'Cliente' => ['role_id' => 4, 'actions' => '6'],
            ]
        ],
        'rates' => [
            'name' => 'Tarifas', 'reference' => 'rates', 'icon' => '', 'position' => '7',
            'children' => [],
            'permission' => [
                'Admin' =>  ['role_id' => 1, 'actions' => '6,7,8,9,10,11,12,13'],
                'Operador' => ['role_id' => 2, 'actions' => '6'],
                'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                'Cliente' => ['role_id' => 4, 'actions' => '6'],
            ]
        ],
        'zones' => [
            'name' => 'Zonas', 'reference' => 'zones', 'icon' => '', 'position' => '8',
            'children' => [],
            'permission' => [
                'Admin' =>  ['role_id' => 1, 'actions' => '6,7,8,9,10,11,12,13'],
                'Operador' => ['role_id' => 2, 'actions' => '6'],
                'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                'Cliente' => ['role_id' => 4, 'actions' => '6'],
            ]
        ],
        'reports' => [
            'name' => 'Informes', 'reference' => 'reports', 'icon' => '', 'position' => '9',
            'children' => [],
            'permission' => [
                'Admin' =>  ['role_id' => 1, 'actions' => '6,7,8,9,10,11,12,13'],
                'Operador' => ['role_id' => 2, 'actions' => '6'],
                'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                'Cliente' => ['role_id' => 4, 'actions' => '6'],
            ]
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
            'destroy',
            'delete',
            'update',
            'edit',
            'assignate',
            'import',
            'export'
        ],

        'Permissions' => [],
        'branch_office_types' => [
            'Interna',
            'Externa'
        ],
        'contract_type'=>[
            'contrato indefinido',
            'contrato prestación de servicio'
        ],
        'payment_period' => [
            'Semanal',
            'Quincenal',
            'Mensual'
        ],
        'payment_method' => [
            'Credito',
            'Plan'
        ],
        'branch_office_type' => [
            'Interna',
            'Externa'
        ],
        'use_mode' => [
            'Saldo',
            'Credito',
            'Contado',
            'Cantidad',
            'Saldo a favor'
        ]
    ]

];
