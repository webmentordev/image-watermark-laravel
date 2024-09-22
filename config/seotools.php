<?php
return [
    'meta' => [
        'defaults' => [
            'title'       => 'Unlimited Free Watermark Image Generator',
            'titleBefore' => false,
            'description' => 'Create Unlimited Free Watermark Images with Our Easy-to-Use Generator - Perfect for Branding and Personalization!',
            'separator'   => ' - ',
            'keywords'    => ['free watermarks', 'unlimited watermarks', 'watermark generator', 'branding images'],
            'canonical'   => null,
            'robots'      => 'all',
        ],
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        'defaults' => [
            'title'       => 'Unlimited Free Watermark Image Generator',
            'description' => 'Create Unlimited Free Watermark Images with Our Easy-to-Use Generator - Perfect for Branding and Personalization!',
            'url'         => null,
            'type'        => false,
            'site_name'   => false,
            'images'      => [
                config('app.url') . '/images/generate-free-unlimited-images-with-watermark.png'
            ],
        ],
    ],
    'twitter' => [
        'defaults' => [
            'card'        => 'large_summary',
            'site'        => '@grouphostmarker',
        ],
    ],
    'json-ld' => [
        'defaults' => [
            'title'       => 'Unlimited Free Watermark Image Generator',
            'description' => 'Create Unlimited Free Watermark Images with Our Easy-to-Use Generator - Perfect for Branding and Personalization!',
            'url'         => null,
            'type'        => 'SoftwareApplication',
            'images'      => [
                config('app.url') . '/images/generate-free-unlimited-images-with-watermark.png'
            ],
        ],
    ],
];
