<?php

return [
    'plans' => [
        'basic' => [
            'name' => 'الخطة الأساسية',
            'price' => 2000,
            'currency' => 'TL',
            'product_limit' => 20,
            'duration_days' => 30,
            'features' => [
                'إضافة حتى 20 منتج',
                'لوحة تحكم أساسية',
                'دعم فني عبر البريد',
                'تقارير مبيعات أساسية'
            ]
        ],
        'medium' => [
            'name' => 'الخطة المتوسطة',
            'price' => 4000,
            'currency' => 'TL',
            'product_limit' => 40,
            'duration_days' => 30,
            'features' => [
                'إضافة حتى 40 منتج',
                'لوحة تحكم متقدمة',
                'دعم فني هاتفي',
                'تقارير مبيعات متقدمة',
                'تحليلات متقدمة',
                'أولوية في الدعم'
            ]
        ],
        'premium' => [
            'name' => 'الخطة المميزة',
            'price' => 6000,
            'currency' => 'TL',
            'product_limit' => 9999,
            'duration_days' => 30,
            'features' => [
                'عدد غير محدود من المنتجات',
                'جميع الميزات المتقدمة',
                'دعم فني مميز 24/7',
                'تقارير وتحليلات شاملة',
                'أولوية في الظهور',
                'ميزات حصرية',
                'تخصيص متقدم'
            ]
        ]
    ],

    'gateways' => [
        'stripe' => [
            'enabled' => true,
            'name' => 'Stripe',
            'test_mode' => env('STRIPE_TEST_MODE', true),
            'public_key' => env('STRIPE_PUBLIC_KEY'),
            'secret_key' => env('STRIPE_SECRET_KEY')
        ],
        'paypal' => [
            'enabled' => true,
            'name' => 'PayPal',
            'test_mode' => env('PAYPAL_TEST_MODE', true),
            'client_id' => env('PAYPAL_CLIENT_ID'),
            'secret' => env('PAYPAL_SECRET')
        ],
        'moyasar' => [
            'enabled' => true,
            'name' => 'Moyasar',
            'test_mode' => env('MOYASAR_TEST_MODE', true),
            'publishable_key' => env('MOYASAR_PUBLISHABLE_KEY'),
            'secret_key' => env('MOYASAR_SECRET_KEY')
        ]
    ]
];
