<?php

/**
 * Example
 * 
 * 'role_name' => [
 *      'prefix' => [
 *          'not_allow' => [],  // prefixs not allowed access
 *          'is_full' => true   // allowed full prefixs
 *      ],
 *      'method' => [
 *          'not_allow' => [],  // method not allowed access - strtolower
 *          'is_full' => true   // allowed full method
 *      ],
 *      'action_special' => [
 *          'not_allow' => [ 'prefix:action1,action2', ... ],  // action method not allowed access
 *      ],
 * ]
 */
return [
    'admin' => [
        'prefix' => [
            'not_allow' => [],
            'is_full' => true,
        ],
        'method' => [
            'not_allow' => [],
            'is_full' => true,
        ],
        'action_special' => [
            'not_allow' => [],
        ],
    ],

    'board_member' => [
        'prefix' => [
            'not_allow' => [],
            'is_full' => false,
        ],
        'method' => [
            'not_allow' => [],
            'is_full' => false,
        ],
        'action_special' => [
            'not_allow' => [
                'clients:store,update,delete',
                'cars:store,update,delete',
                'bank-accounts:store,update,delete',
                'locations:store,update,delete',
                'staffs:store,delete',
                'reports:store,update,delete',
                'shipping-projects:store,update',
                'warehouse-projects:store,update',

                'dashboard/shipping-sales:store,update,delete,confirm,includeCaculate,rejectConfirm',
                'dashboard/warehouse-sales:store,update,delete,confirm,includeCaculate,rejectConfirm',
                'dashboard/senders:upsert',
                'dashboard/fees:createFeeDetail,createFeeClientDetailCenter,upsert,updateFeeClientDetailCenter,deleteFeeDetailCenter',
                'dashboard/budgets:upsert',
                'dashboard/billings:export,uploadFiles,deleteFileUpload',
                'dashboard/reports:store',
                'dashboard/routes:store,update,delete',
            ],
        ],
    ],

    'director' => [
        'prefix' => [
            'not_allow' => [],
            'is_full' => false,
        ],
        'method' => [
            'not_allow' => [],
            'is_full' => false,
        ],
        'action_special' => [
            'not_allow' => [
                'clients:store,update,delete',
                'cars:store,update,delete',
                'bank-accounts:store,update,delete',
                'locations:store,update,delete',
                'staffs:store,delete',
                'reports:store,update,delete',
                'shipping-projects:store,update',
                'warehouse-projects:store,update',

                'dashboard/shipping-sales:store,update,delete,confirm,includeCaculate,rejectConfirm',
                'dashboard/warehouse-sales:store,update,delete,confirm,includeCaculate,rejectConfirm',
                'dashboard/senders:upsert',
                'dashboard/fees:createFeeDetail,createFeeClientDetailCenter,upsert,updateFeeClientDetailCenter,deleteFeeDetailCenter',
                'dashboard/budgets:upsert',
                'dashboard/billings:export,uploadFiles,deleteFileUpload',
                'dashboard/reports:store',
                'dashboard/routes:store,update,delete',
            ],
        ],
    ],

    'general_manager' => [
        'prefix' => [
            'not_allow' => [],
            'is_full' => true,
        ],
        'method' => [
            'not_allow' => [],
            'is_full' => false,
        ],
        'action_special' => [
            'not_allow' => [
                'staffs:store,delete',
                'shipping-projects:store,update,delete,approve,reject,cancelApproved',
                'warehouse-projects:store,update,delete,approve,reject,cancel',

                'dashboard/shipping-sales:store,update,delete,confirm,includeCaculate,rejectConfirm',
                'dashboard/warehouse-sales:store,update,delete,confirm,includeCaculate,rejectConfirm',
                'dashboard/senders:upsert',
                'dashboard/reports:store',
            ],
        ],
    ],

    'deputy_director' => [
        'prefix' => [
            'not_allow' => [],
            'is_full' => false,
        ],
        'method' => [
            'not_allow' => [],
            'is_full' => false,
        ],
        'action_special' => [
            'not_allow' => [
                'staffs:store,delete',
                'bank-accounts:store,update,delete',
                'reports:store,update,delete',
                //Không được approve projects cho xe định kỳ - xử lý ở controller - repo

                'dashboard/fees:createFeeDetail,createFeeClientDetailCenter,upsert,updateFeeClientDetailCenter,deleteFeeDetailCenter',
            ],
        ],
    ],

    'head_office' => [
        'prefix' => [
            'not_allow' => [],
            'is_full' => false,
        ],
        'method' => [
            'not_allow' => [],
            'is_full' => false,
        ],
        'action_special' => [
            'not_allow' => [
                'staffs:store,delete',
                'bank-accounts:store,update,delete',
                'reports:store,update,delete',
                //Không được approve projects cho xe định kỳ - xử lý ở controller - repo

                'dashboard/fees:createFeeDetail,createFeeClientDetailCenter,upsert,updateFeeClientDetailCenter,deleteFeeDetailCenter',
            ],
        ],
    ],

    'center_manager' => [
        'prefix' => [
            'not_allow' => [],
            'is_full' => false,
        ],
        'method' => [
            'not_allow' => [],
            'is_full' => false,
        ],
        'action_special' => [
            'not_allow' => [
                'staffs:store,delete',
                'bank-accounts:store,update,delete',
                'reports:store,update,delete',
                //Không được approve projects cho xe định kỳ - xử lý ở controller - repo

                'dashboard/fees:createFeeDetail,createFeeClientDetailCenter,upsert,updateFeeClientDetailCenter,deleteFeeDetailCenter',
            ],
        ],
    ],
    
    'staff' => [
        'prefix' => [
            'not_allow' => [],
            'is_full' => false,
        ],
        'method' => [
            'not_allow' => [],
            'is_full' => false,
        ],
        'action_special' => [
            'not_allow' => [
                'bank-accounts:store,update,delete',
                'locations:store,update,delete',
                'staffs:store,delete',
                'reports:store,update,delete',
                'shipping-projects:approve,reject',//,cancelApproved',
                'warehouse-projects:approve,reject',//,cancel',
                //Không được đăng ký projects cho xe định kỳ - xử lý ở controller - repo

                'dashboard/shipping-sales:confirm,includeCaculate,rejectConfirm',
                'dashboard/warehouse-sales:confirm,includeCaculate,rejectConfirm',
                'dashboard/senders:upsert',
                'dashboard/fees:createFeeDetail,createFeeClientDetailCenter,upsert,updateFeeClientDetailCenter,deleteFeeDetailCenter',
                'dashboard/budgets:upsert',
                'dashboard/reports:store',
            ],
        ],
    ],
    
    'sale' => [
        'prefix' => [
            'not_allow' => [],
            'is_full' => false,
        ],
        'method' => [
            'not_allow' => [],
            'is_full' => false,
        ],
        'action_special' => [
            'not_allow' => [
                'bank-accounts:store,update,delete',
                'locations:store,update,delete',
                'staffs:store,delete',
                'reports:store,update,delete',
                //Không được approve projects cho xe định kỳ - xử lý ở controller - repo

                'dashboard/shipping-sales:confirm,includeCaculate,rejectConfirm',
                'dashboard/warehouse-sales:confirm,includeCaculate,rejectConfirm',
                'dashboard/senders:upsert',
                'dashboard/fees:createFeeDetail,createFeeClientDetailCenter,upsert,updateFeeClientDetailCenter,deleteFeeDetailCenter',
                'dashboard/budgets:upsert',
                'dashboard/reports:store',
            ],
        ],
    ],

];