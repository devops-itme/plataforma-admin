<?php

return [
    'states' => [
        1 => [
            'name' => 'Activo',
            'color' => 'success'
        ],
        0 => [
            'name' => 'Inactivo',
            'color' => 'warning'
        ],
    ],
    'roles' => [
        1 => 'Admin',
        2 => 'Operador',
        3 => 'Mensajero',
        4 => 'Cliente',
    ],
    'modules' => [
        'dashboard' => [
            'name' => 'Dashboard', 'reference' => 'dashboard', 'icon' => '', 'position' => '1',
            'actions' => '6',
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
            'actions' => '6,7,8,9,10,11,12,13,17',
            'children' => [],
            'permission' => [
                'Admin' =>  ['role_id' => 1, 'actions' => '6,7,8,9,10,11,12,13,17'],
                'Operador' => ['role_id' => 2, 'actions' => '6'],
                'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                'Cliente' => ['role_id' => 4, 'actions' => '6'],
            ]
        ],
        'internationalOrders' => [
            'name' => 'Ordenes Internacionales', 'reference' => 'internationalOrders', 'icon' => '', 'position' => '2',
            'actions' => '6,7,8,9,10,11,12,13,17',
            'children' => [
                'shipments' => [
                    'name' => 'Envíos', 'reference' => 'shipments', 'icon' => '', 'position' => '1',
                    'actions' => '6,7,8,9,10,11,12,13,17',
                    'children' => [],
                    'permission' => [
                        'Admin' =>  ['role_id' => 1, 'actions' => '6,7,8,9,10,11,12,13,15,17'],
                        'Operador' => ['role_id' => 2, 'actions' => '6'],
                        'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                        'Cliente' => ['role_id' => 4, 'actions' => '6'],
                    ]
                ],
            ],
            'permission' => [
                'Admin' =>  ['role_id' => 1, 'actions' => '6,7,8,9,10,11,12,13,15,17'],
                'Operador' => ['role_id' => 2, 'actions' => '6'],
                'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                'Cliente' => ['role_id' => 4, 'actions' => '6'],
            ]
        ],
        'customers' => [
            'name' => 'Clientes', 'reference' => 'customers', 'icon' => '', 'position' => '3',
            'actions' => '6,7,8,9,10,11,12,13',
            'children' => [
                'bankUsers' => [
                    'name' => 'Usuario banco', 'reference' => 'bankUsers', 'icon' => '', 'position' => '1',
                    'actions' => '6,7,8,9,10,11,12,13',
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
                    'actions' => '6,7,8,9,10,11,12,13',
                    'children' => [
                        'departments' => [
                            'name' => 'Departamentos', 'reference' => 'departments', 'icon' => '', 'position' => '1',
                            'actions' => '6,7,8,9,10,11,12,13',
                            'children' => [],
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

            ],
            'permission' => [
                'Admin' =>  ['role_id' => 1, 'actions' => '6,7,8,9,10,11,12,13'],
                'Operador' => ['role_id' => 2, 'actions' => '6'],
                'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                'Cliente' => ['role_id' => 4, 'actions' => '6'],
            ]
        ],
        'addresses' => [
            'name' => 'Direcciones', 'reference' => 'addresses', 'icon' => '', 'position' => '2',
            'actions' => '6,7,8,9,10,11,12,13',
            'children' => [],
            'permission' => [
                'Admin' =>  ['role_id' => 1, 'actions' => '6,7,8,9,10,11,12,13'],
                'Operador' => ['role_id' => 2, 'actions' => '6'],
                'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                'Cliente' => ['role_id' => 4, 'actions' => '6'],
            ]
        ],
        'messengers' => [
            'name' => 'Mensajeros', 'reference' => 'messengers', 'icon' => '', 'position' => '4',
            'actions' => '6,7,8,9,10,11,12,13',
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
            'actions' => '6,7,8,9,10,11,12,13',
            'children' => [],
            'permission' => [
                'Admin' =>  ['role_id' => 1, 'actions' => '6,7,8,9,10,11,12,13'],
                'Operador' => ['role_id' => 2, 'actions' => '6'],
                'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                'Cliente' => ['role_id' => 4, 'actions' => '6'],
            ]
        ],
        'parameters' => [
            'name' => 'Parámetros', 'reference' => 'parameters', 'icon' => '', 'position' => '6',
            'actions' => '6,7,8,9,10,11,12,13',
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
            'actions' => '6,7,8,9,10,11,12,13',
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
            'actions' => '6,7,8,9,10,11,12,13',
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
            'actions' => '6,7,8,9,10,11,12,13',
            'children' => [],
            'permission' => [
                'Admin' =>  ['role_id' => 1, 'actions' => '6,7,8,9,10,11,12,13'],
                'Operador' => ['role_id' => 2, 'actions' => '6'],
                'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                'Cliente' => ['role_id' => 4, 'actions' => '6'],
            ]
        ],
        'statusMatrix' => [
            'name' => 'Matriz de estados', 'reference' => 'reports', 'icon' => '', 'position' => '10',
            'actions' => '6',
            'children' => [],
            'permission' => [
                'Admin' =>  ['role_id' => 1, 'actions' => '6'],
                'Operador' => ['role_id' => 2, 'actions' => '6'],
                'Mensajero' => ['role_id' => 3, 'actions' => '6'],
                'Cliente' => ['role_id' => 4, 'actions' => '6'],
            ]
        ],
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
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
    ],
    'editable_parameters' => [
        'document_type',
        'payment_period',
        'payment_method',
        'use_mode',
        'plans',
        'customer_document_type',
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
            'assign',
            'import',
            'export',
            'record'
        ],
        'permissions' => [],
        'branch_office_types' => [
            'Interna',
            'Externa'
        ],
        'contract_type' => [
            'contrato indefinido',
            'contrato prestación de servicio'
        ],
        'payment_period' => [
            'Semanal',
            'Quincenal',
            'Mensual'
        ],
        'payment_method' => [
            'Crédito',
            'Plan'
        ],
        'use_mode' => [
            'Saldo',
            'Crédito',
            'Contado',
            'Cantidad',
            'Saldo a favor'
        ],
        'order_states' => [
            'Por despachar',
            'Despachados',
            'Completados'
        ],
        'order_types' => [
            'Ondemand',
            'Packaging',
            'International'
        ],
        'transport_type' => [
            'Moto',
            'Auto'
        ],
        'plans' => [
            'Cantidad a favor',
            'Cantidad básico',
            'Diamond',
            'Diamond plus',
            'Gold',
            'Ondemand',
            'Platinum',
            'Platinum plus',
            'Saldo a favor',
            'Silver con retiro',
            'Silver sin retiro',
            'Special'
        ],
        'customer_document_type' => [
            'Cheque',
            'Tarjeta',
            'Delivery'
        ],
        'scopes' => [
            'creation',
            'pickup',
            'delivery'
        ],
        'issues' => [
            'ENTREGADO',
            'NO ENTREGADO- DIRECCIÓN EQUIVOCADA',
            'NO ENTREGADO AUSENTE',
            'OTROS'
        ],
        'days' => [
            'Domingo',
            'Lunes',
            'Martes',
            'Miércoles',
            'Jueves',
            'Viernes',
            'Sábado',
        ],
        'package_type' => [
            'Tipo A',
            'Tipo B'
        ],
        'guide_document_type' => [
            'signature',
            'evidence',
            'package_picture',
        ]
    ],
    'system_status' => [
        'creation'/*_scope*/ => [
            'CREADO',
            'X EDITAR'
        ],
        'pickup'/*_scope*/ => [
            'POR DESPACHAR',
            'DESPACHADO',
            'INCIDENCIA',
            'RECOGIDO'
        ],
        'delivery'/*_scope*/ => [
            'POR DESPACHAR',
            'DESPACHADO',
            'INCIDENCIA',
            'ENTREGADO'
        ]
    ],

];
