<?php


return [

    "contactus_type" => ['Service & Support', 'Vendor Registration', 'Career', 'Become Our Dealer', 'Contact Details'],

    "site_setting" => [
        "name" => "woodies",
        "logo" => env('APP_URL') . '/front/images/logo.png',
        "small_logo" => env('APP_URL') . '/front/images/logo.png',
        "fevicon" => env('APP_URL') . '/front/images/fevicon.png',
        "default_img" => env('APP_URL') . '/front/images/default_image.png'
    ],


    "footer" => [
        "logo" => env('APP_URL') . '/front/images/logo.png',
        'description' => 'Woodieo proudly offers some of the most popular and trusted wood products from Mahuva city, known for their superior quality and craftsmanship. Our locally sourced materials reflect the rich woodworking tradition of the region and are favored by builders, designers, and manufacturers alike.',
        "contact" => [
            "address" => "13, Harbhole, B/H Ramji temple, bhavani Temple Road, Khargate, Mahuva, Gujarat 364290",
            "contact" => '8306426026',
            "email" => 'woodieo@gmail.com',
            "map" => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d943.3080403723825!2d71.772304611687!3d21.083915262972695!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be22508a0064fd5%3A0xa46df4ef460e20e4!2sJagannath%20mandir!5e0!3m2!1sen!2sin!4v1752309958454!5m2!1sen!2sin',
        ],
    ],

    'legal_page_type' => ['PrivacyPolicy', 'TermsAndCondition', 'CopyRight', 'AboutUs', 'RefundPolicy', 'ReturnPolicy', 'ShippingPolicy', 'CancellationPolicy'],

    'rezorpayEnv'=> 'test', //live, test
    'rezorpayTestKey'=> 'rzp_test_s4XMd4dlQEaapr',
    'rezorpayLiveKey'=> 'rzp_live_o5pyYyWhYdR1hN',
];
