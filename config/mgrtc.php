<?php

return [

    'port'            => 8080,
    'debug'           => false,
    'allowedOrigins'  => null,
    'IpBlackList'     => null,
    'authAdapter'     => 'MgRTC\Session\AuthSimple',
    'facebook'        => [
        'appId'  => '251017698383358',
        'secret' => '0ee6bd094ef97478417ef9602232524d'
    ],
    'simple'          => [
        'allowAnonim' => true,
        'members'     => [
            array('id' => 11, 'username' => 'operator1', 'password' => 'operator1', 'name' => 'Tech Support')
        ]
    ],
    'operators'       => null,
    'allowDuplicates' => true,
    'rooms'           => [
        1         => [
            'authAdapter'  => 'MgRTC\Session\AuthSimple',
            'disableVideo' => false,
            'disableAudio' => false
        ],
        2         => [
            'authAdapter' => 'MgRTC\Session\AuthFacebook', //use AuthFacebook2 for facebook api 2
        ],
        3         => [
            'authAdapter' => 'MgRTC\Session\AuthWordpress',
        ],
        4         => [
            'authAdapter' => 'MgRTC\Session\AuthSimple',
            'operators'   => [11]
        ],
        5         => [
            'authAdapter' => 'MgRTC\Session\AuthSimple',
            'group'       => true,
            'limit'       => 3
        ],
        6         => [
            'authAdapter' => 'MgRTC\Session\AuthSimple',
            'roulette'    => true
        ],
        7         => [
            'file'        => true,
            'authAdapter' => 'MgRTC\Session\AuthSimple'
        ],
        8         => [
            'authAdapter'  => 'MgRTC\Session\AuthSimple',
            'desktopShare' => true
        ],
        9         => [
            'authAdapter' => 'MgRTC\Session\AuthArmy'
        ],
        'group_%' => [
            'authAdapter' => 'MgRTC\Session\AuthSimple',
            'group'       => true,
            'limit'       => 3
        ]
    ]
];
