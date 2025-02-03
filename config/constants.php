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
                ['title' => 'Data Pegawai', 'path' => '/inventory/pharmacy/employee'],
                ['title' => 'Data Produk', 'path' => '/inventory/pharmacy/product'],
                ['title' => 'Data Resep', 'path' => '/inventory/pharmacy/recipe'],
            ]
        ],
        [
            'title' => 'Transaksi',
            'path' => '#',
            'icon' => '<i class="fa-solid fa-cart-shopping"></i>',
            'isDropdown' => true,
            'submenu' => [
                ['title' => 'Faktur Pembelian', 'path' => '/inventory/transaction/purchase-order'],
                ['title' => 'Transaksi Penjualan', 'path' => '/inventory/transaction/sales-transaction'],
                ['title' => 'Laporan', 'path' => '/inventory/transaction/report'],
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
