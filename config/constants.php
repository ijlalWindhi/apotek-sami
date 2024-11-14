<?php

return [
    'MENU_ITEMS' => [
        [
            'title' => 'Dashboard',
            'path' => '/inventory',
            'icon' => [
                'path' => 'M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z',
            ],
            'badge' => null
        ],
        [
            'title' => 'Master',
            'path' => '#',
            'icon' => [
                'path' => 'M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z',
            ],
            'isDropdown' => true,
            'submenu' => [
                ['title' => 'Pajak', 'path' => '/inventory/master/tax'],
                ['title' => 'Unit Satuan', 'path' => '/inventory/master/unit'],
                ['title' => 'Tipe Pembayaran', 'path' => '/inventory/master/payment-type'],
                ['title' => 'Tipe Penyesuaian', 'path' => '/inventory/master/adjustment-type'],
            ]
        ],
        [
            'title' => 'Transaksi',
            'path' => '/inventory/transaction',
            'icon' => [
                'path' => 'M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z',
            ],
            'badge' => ['text' => 'Pro', 'type' => 'gray']
        ],
    ],
    'MENU_USER' => [
        [
            'title' => 'Profile',
            'path' => '/profile',
        ],
        [
            'title' => 'Logout',
            'path' => '/logout',
        ]
    ]
];
