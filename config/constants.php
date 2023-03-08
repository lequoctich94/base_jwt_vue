<?php

return [
    'authenticate' => [
        'token_type' => 'Bearer',
        'minimum_num_admins' => 1,
        'master_admin_id' => 1,
        'roles' => [
            'admin' => 1,               // quản trị hệ thống
            'board_member' => 2,        // thành viên ban quản trị
            'director' => 8,
            'deputy_director' => 9,
            'head_office' => 7,        
            'center_manager' => 4,      // trưởng/phó các chi nhánh trung tâm
            'sale' => 6,                // nhân viên sale
            'staff' => 5,               // nhân viên
            'general_manager' => 3,     // tổng vụ (nhân sự, account, ...)
        ],
        'titles' => [
            '1' => 'admin',
            '2' => 'board_member',
            '4' => 'center_manager',
            '9' => 'deputy_center',
            '3' => 'general_manager',
            '6' => 'sale',
            '5' => 'staff',
            // '3' => 'general_management',
            '7' => 'head_office',
            '8' => 'director',
        ],
        'guards' => [
            'default' => null,
            //...
        ],
        'internal' => [
            'type' => 1,
        ],
        'sso' => [
            'type' => 2,
            'services' => [
                'google' => 1,
                'facebook' => 2,
                'apple' => 3,
                'twitter' => 4
            ]
        ]
    ],

    'types' => [
        'm_clients' => [
            'client'  => 1,
            'payment' => 2,
            'partner' => 3,
        ],
        'm_fees' => [
            1 => '倉庫費',
            2 => '配送費',
            3 => '共通経費',
        ],
        'projects' => [
            'shipping' => 1,
            'warehouse' => 2
        ],
        'revenues' => [
            'shipping' => 1,
            'warehouse' => 2
        ],
        'shipping_projects' => [
            'periodically'  => 1,
            'increase'      => 2,
            'once'          => 3   
        ],
        
    ],

    'option_all_center' => 'all',

    //other config
    'time_life_reset_link' => env('TIME_LIFE_RESET_LINK', 30),  //min
    'password_min' => 6,
    'paginate' => env('PAGINATE_PER_PAGE', 50),
    'paginate_export' => 31,
    'regex' => [
        'num'       => '^\d{0,9}$|^\d{1,9}\.\d{1,2}$',
        'str_kana'  => '^[ァ-ヶーぁ-ん]+$',
        'time'      => '^[0-9]{2}:[0-9]{2}$'
    ],

    //type bank account
    'type_bank' => [1,2],

    'closing_date' => [
        'm_clients' => ['5','10','15','20','25','end_month'],
        'end_month' => 'end_month'
    ],
    'shipping_revernues' => [
        'is_billing' => 1,
        'is_non_billing' => 0,
        'is_status_on'=>1,
        'is_status_off'=> 0,
        'is_caculate_on' => 1,
        'is_caculate_off' => 0  ,
        'project_type_periodically' => 1,
        'date_to_shipping' => 1,
        'create_by_user' => 1,
        'create_by_batch' => 2,
        'project_is_confirmed' => 2,
        'project_is_cancel' => 3,
        'revenue_is_not_confirmed' => 0,
        'revenue_is_confirmed' => 1
    ],
    'warehouse_revernues' => [
        'project_is_confirmed' => 2,
        'type' => [
            'warehouse' => 1,
            'facility_handle_management' => 2,
            'operation' => 3,
            'nakamura' => 4
        ],
        'warehouse_type' => [
            'internal'  => 1,
            'client'      => 2,
        ],
        'period_type' => [
            'type_1' => 1,
            'type_2' => 2,
            'type_3' => 3,   
        ],
        'project_type' => [
            'periodically' => 1,
            'increase' => 2,
        ],
        'logictis_fees' => [
            'facility_fee' => 4,
            'handling_fee' => 5,
            'management_fee' => 6,
            'operation_checkbox' => 18,
        ],
    ],
    'type_cars' => [
        'client_car' => 2,
        'company_car' => 1
    ],
    'week_maps' => [
        0 => 'is_su',
        1 => 'is_mo',
        2 => 'is_tu',
        3 => 'is_we',
        4 => 'is_th',
        5 => 'is_fr',
        6 => 'is_sa',
    ],


    'import' => [
        'rows_a_time' => env('IMPORT_ROWS_A_TIME', 500)
    ],

    'warehouse_project' => [
        'is_billing' => 1,
        'is_non_billing' => 0,
        'is_status_on'=>1,
        'is_status_off'=> 0,
    ],

    'seed' => [
        'init_mode' => env('SEED_INIT', false),

        'env' => env('SEED_ENV', 'astro-demo'),
        
        //Can run by api
        'password'  => env('SEED_PASSWORD', 's_P4xe_OAxq3he_TVi1d_el2sk'),
        'class'     => [
            DatabaseSeeder::class,
            ClearOldCenter::class,
            LogisticsFee::class,
            ClientFeeCode::class,
            CarType::class,
            Center::class,
            Init::class,
            Screen::class,
        ]
    ],

    'type_senders' => [
        'target' => 1,
        'budget' => 2
    ],
    'payment_term' => [
        'end_this_month'         => 1,
        '20_month_later'         => 2,
        '25_month_later'         => 3,
        'end_month_later'        => 4,
        '15_two_month_later'     => 5,
        '20_two_month_later'     => 6,
        '25_two_month_later'     => 7,
        '5_three_month_later'    => 8
    ],
    'text_billing_export' => [
        'payment' => '振込手数料は貴社にてご負担お願いいたします'
    ],
    'summary' => [
        'format_number' => 1,
        'format_money' => 0
    ],
    'text_name_type_project' => [
        'shipping_non_periodic' => '3.臨時便',
        'shipping_periodic' => '2.定期便',
        'warehouse' => '4.入庫料・出庫料・保管料',
        'facility' => '5.施設使用料・発送手数料・事務管理費',
        'nakamura' => '6.定型業務（中村屋専用）',
        'operation' => '7.作業料'
    ],
    'folder_file_name_download_billing' => [
        'folder_name' => 'センターの請求書',
        'file_name_attachment' => '添付',
        'file_name_bill_info' => '1.送付状上紙'
    ],
    'payment_method' => [
        'transfer' => 1,
        'credit_card' => 2,
        'convenion_store' => 3,
        'periodically' => 4,
        'other' => 5
    ],
    'shipping_external_fee_code' => 530,
    'fee_cost_from_sales' => 1
];
