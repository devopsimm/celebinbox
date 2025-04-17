<?php

return [
    'ai' => [
        'key' => env('AI_KEY'),
    ],
    'placeholderImg'=>'website/img/logo.png',
    'placeholderImgFull'=>'https://www.celebinbox.com/website/img/ci-700x390.jpg',
    'placeholderImg370'=>'https://www.celebinbox.com/website/img/ci-370x222.jpg',
    'placeholderImg100'=>'https://www.celebinbox.com/website/img/ci-100x60.jpg',
    'placeholderImg467'=>'https://www.celebinbox.com/website/img/ci-370x222.jpg',
    'preAssetUrl'=> env('APP_URL').'/assets/uploads/updates/',
    'cacheExpiry'=> '86400', // 2hrs
    'allowedExt'=> ['jpg','png','gif','bmp','webp'],
    'postMetaCheckBoxes'=>[
        'show_live_icon'=>'Show live icon',
        'no_follow'=>'No Follow',
    ],
    'postMetaInputs'=>[
        'meta_title'=>'Meta Title',
        'meta_description'=>'Mete Description'
    ],
    'publishingStatus'=>[
        '0'=>'Draft',
        '1'=>'Published',
        '2'=>'Deleted',
        '3'=>'Scheduled',
    ],

    'socialSharing'=>[
//        '1'=>'Fb Share',
//        '2'=>'Tweet Share',
//        '3'=>'Sports Tweet Share',
    ],
    'postSourceType'=>[
        '2'=>'Web Desk',
        '3'=>'Reporter',
        '1'=>'News Agency',
    ],
    'catIdsForHomePage'=>[
        '11'=>['title'=>'world','count'=>'4'],
        '12'=>['title'=>'sports','count'=>'4'],
        '13'=>['title'=>'health','count'=>'4'],
        '14'=>['title'=>'entertainment','count'=>'10'],

        ],
    'catIdsForSideBar'=>[
        '15'=>['title'=>'royal','count'=>'5'],
        ],

    'thumbnails'=>[
        'postThumbnails'=>[
            [700,390],[350,200],[100,70]
        ],
    ],
    ];
