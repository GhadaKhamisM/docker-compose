<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Messages Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used for
    | The following language lines contain the default error messages used for
    | response message.
    |
    */
    'services' => [
        'errors' => [
            'delete' => 'لا يمكن حذف هذه الخدمة، هناك أطباء يقدمونها'
        ],
        'success' => [
            'delete' => 'تم حذف الخدمة بنجاح',
            'created' => 'تم حفظ الخدمة بنجاح',
            'updated' => 'تم تعديل الخدمة بنجاح'
        ]
    ],
    'doctors' => [
        'success' => [
            'delete' => 'تم حذف الطبيب بنجاح',
            'created' => 'تم حفظ الطبيب بنجاح',
            'updated' => 'تم تعديل الطبيب بنجاح'
        ],
        'errors' => [
            'date' => 'ليس متاح الحجز فى هذا التاريخ',
            'booking' => 'ليس هناك مواعيد متاحة فى هذا التاريخ'
        ]
    ],
    'login' => [
        'errors' => [
            'wrong_data' => 'البريد الإلكترونى أو كلمة المرور خاطئة',
            'token' => 'رمز التحقق غير موجود',
            'authorization' => 'ليس لديك صلاحية',
            'user_not_found' => 'المستخدم غير موجود',
        ]
    ],
    'booking' => [
        'success' => [
            'accept' => 'تم تأكيد الحجز بنجاح',
            'cancel' => 'تم ألغاء الحجز بنجاح',
            'created' => 'تم حفظ الحجز بنجاح',
        ],
        'errors' => [
            'status' => 'لا يمكن تغيير حالة الحجز',
            'not_available' => 'لا يمكن الحجز في هذه الفترة'
        ]
    ],
    'reviews' => [
        'success' => [
            'created' => 'تم حفظ التقييم بنجاح',
        ], 
        'errors' => [
            'created' => 'لا يمكنك إضافه تقييم',
            'exist' => 'لقد قمت بالتقييم من قبل ',
        ]
    ]
];