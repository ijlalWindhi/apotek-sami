<?php

return [
    'MENU_ITEMS' => [
        [
            'title' => 'Dashboard',
            'path' => '/inventory',
            'icon' => '<i class="fa-solid fa-gauge"></i>',
            'badge' => null
        ],
        [
            'title' => 'Apotek',
            'path' => '#',
            'icon' => '<i class="fa-solid fa-mortar-pestle"></i>',
            'isDropdown' => true,
            'submenu' => [
                ['title' => 'Data Apotek', 'path' => '/inventory/pharmacy/pharmacy'],
                ['title' => 'Data Pegawai', 'path' => '/inventory/pharmacy/employee'],
                ['title' => 'Data Pelanggan', 'path' => '/inventory/pharmacy/customer'],
                ['title' => 'Data Produk', 'path' => '/inventory/pharmacy/product'],
                ['title' => 'Data Resep', 'path' => '/inventory/pharmacy/recipe'],
            ]
        ],
        [
            'title' => 'Master',
            'path' => '#',
            'icon' => '<i class="fa-solid fa-table"></i>',
            'isDropdown' => true,
            'submenu' => [
                ['title' => 'Pajak', 'path' => '/inventory/master/tax'],
                ['title' => 'Unit Satuan', 'path' => '/inventory/master/unit'],
                ['title' => 'Tipe Pembayaran', 'path' => '/inventory/master/payment-type'],
                ['title' => 'Supplier', 'path' => '/inventory/master/supplier'],
            ]
        ],
        [
            'title' => 'Transaksi',
            'path' => '/inventory/transaction',
            'icon' => '<i class="fa-solid fa-cart-shopping"></i>',
            'badge' => ['text' => 'Pro', 'type' => 'gray']
        ],
    ],
    'MENU_USER' => [
        [
            'title' => 'Ubah Profile',
        ],
        [
            'title' => 'Keluar',
        ]
    ]
];
