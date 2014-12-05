<?php
return array(
    'settings' => array(
        'gen_name'            => '',
        'gen_email'           => '',
        'gen_phone'           => '00391122334455',
        'gen_address'         => 'Main Street 123',
        'gen_timetable'       => '',
        'soc_facebook'        => 'http://www.facebook.com',
        'soc_twitter'         => 'http://www.twitter.com',
        'soc_google'          => 'www.google.it',
        'booking'             => true,
        'thankyou'            => true,
        'available_0'         => false,
        'available_1'         => true,
        'available_2'         => true,
        'available_3'         => true,
        'available_4'         => true,
        'available_5'         => true,
        'available_6'         => false,
        'available_from'      => '09:00',
        'available_to'        => '18:00',
        'pay_currency'        => 'USD',
        'pay_paypal_email'    => 'test@test.com',
        'pay_paypal_api_key'  => 'TEST',
        'confirmation'        => true,
        'pay_enabled'         => true,
        'pay_cash'            => true
    ),
    'posts'    => array(
        array(
            'post' => array(
                'post_title'   => 'Manicure',
                'post_content' => 'manicure',
                'post_status'  => 'publish',
                'post_type'    => 'sln_service'
            ),
            'meta' => array(
                '_sln_service_price' => 15,
                '_sln_service_unit'  => 3
            )
        ),
        array(
            'post' => array(
                'post_title'   => 'Nails styling',
                'post_content' => 'nails styling',
                'post_status'  => 'publish',
                'post_type'    => 'sln_service',
            ),
            'meta' => array(
                '_sln_service_price'      => 10.11,
                '_sln_service_unit'       => 2,
                '_sln_service_duration'   => '00:30',
                '_sln_service_secondary'  => true,
                '_sln_service_notav_from' => '11',
                '_sln_service_notav_to'   => '15'
            )
        ),
        array(
            'post' => array(
                'post_title'   => 'Massage',
                'post_content' => 'massage',
                'post_status'  => 'publish',
                'post_type'    => 'sln_service',
            ),
            'meta' => array(
                '_sln_service_price'      => 29.99,
                '_sln_service_unit'       => 2,
                '_sln_service_duration'   => '00:30',
                '_sln_service_secondary'  => true,
                '_sln_service_notav_from' => '11',
                '_sln_service_notav_to'   => '15'
            )
        ),
        'booking' => array(
            'post' => array(
                'post_title'   => 'Booking',
                'post_content' => '[saloon]',
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'comment_status' => 'closed',
                'ping_status'    => 'closed',
            ),
            'meta' => array()
        ),
        'thankyou' => array(
            'post' => array(
                'post_title'   => 'Thank you for booking',
                'post_content' => '[saloon]',
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'comment_status' => 'closed',
                'ping_status'    => 'closed',
            ),
            'meta' => array()
        )
    )
);