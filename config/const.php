<?php


return [

    "contactus_type" => ['Service & Support', 'Vendor Registration', 'Career', 'Become Our Dealer', 'Contact Details'],

    "site_setting" => [
        "name" => "Qnex",
        "logo" => env('APP_URL') . '/front/images/logo.png',
        "small_logo" => env('APP_URL') . '/front/images/logo.png',
        "fevicon" => env('APP_URL') . '/front/images/fevicon.png',
        "default_img" => env('APP_URL') . '/front/images/default_image.png'
    ],


    "footer" => [
        "logo" => env('APP_URL') . '/front/images/logo.png',
        'description' => 'Qnex has been a leading Wholesaler, Manufacturer and Importer of high-quality air conditioner (AC) spare parts since 2012.',
        "contact" => [
            "address" => "Office No 3-4 (1st Floor) Madhav Park, Opp. Tirupati Balaji Complex, Near Maruti Chowk, L. H. Road, Hirabaugh, Surat, Gujarat 395006",
            "contact" => '9879877706',
            "email" => 'salesqnex@gmail.com',
            "map" => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3719.5198746527763!2d72.8639358!3d21.211223800000003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04f0d77f6ffff%3A0x6a0ca367a5d1d697!2sQnex!5e0!3m2!1sen!2sin!4v1739983636300!5m2!1sen!2sin',
        ],
    ],

    'legal_page_type' => ['PrivacyPolicy', 'TermsAndCondition', 'CopyRight', 'AboutUs', 'RefundPolicy', 'ReturnPolicy', 'ShippingPolicy', 'CancellationPolicy'],

    'rezorpayEnv'=> 'test', //live, test
    'rezorpayTestKey'=> 'rzp_test_s4XMd4dlQEaapr',
    'rezorpayLiveKey'=> 'rzp_live_o5pyYyWhYdR1hN',
];
