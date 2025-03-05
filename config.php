<?php
date_default_timezone_set('Europe/Paris');

const BASE_PATH = 'C:\Users\poiss\AppData\Roaming\Firebot\v5\profiles\Main Profile';

return [
    'paths' => [
        'users_db'      => BASE_PATH . '\db\users.db',
        'ranks_json'    => BASE_PATH . '\ranks.json',
        'currency_json' => BASE_PATH . '\currency\currency.json',
    ],

    'user_groups' => [
        'excluded'             => [
            'zairakai',
            'zairakaibot',
            'streamelements',
            'nightbot',
            'streamlabs',
        ],
        'vips'                 => [
            'el_girafon',   // 2025-03-06
            'lhyx__',       // 2025-03-15
            'sirlink__',    // 2025-03-27
            'opale_maskhee',// 2025-03-26
            'AFKaaafe',     // 2025-04-05
        ],
        'vips_honoraires'      => [
            'bluestardust_',
            'deafmute',
            'gunter423_',
            'crazymeal',
            'saltythom',
            'mariepepin',
        ],
        'vips_trimestre_sound' => [
            'saltythom',
            'spawer88',
            'chiragi_lauvel',
            'mariepepin',
            'tonton_flingueur_',
        ],
        'vips_trimestre'       => [
            'saltythom',
            'spawer88',
            'chiragi_lauvel',
            'mariepepin',
            'tonton_flingueur_',
            'crazymeal',
            'hyperion__rl',
            'flora5912',
            'langousteam',
            'k4noya',
        ],
        'mods'                 => [
            'maiko_ema',
            'nao_mynn',
            'flora5912',
            'dame_ophelie',
        ],
        'artistes'             => [
            'bluestardust_',
            'dessinsamelie',
            'maiko_ema',
            'mariepepin',
        ],
        'subs'                 => [
            'dame_ophelie',
            'tayred06',
            'greve',
            'ore_sama18',
            'saltythom',
            'el_girafon',
            'flora5912',
        ],
    ],

    'xp_thresholds' => [
        500 => 3882749,
        355 => 1958889,
        251 => 980405,
        177 => 488342,
        124 => 240249,
        86  => 115970,
        58  => 53040,
        39  => 24179,
        25  => 10074,
        15  => 3719,
        0   => 0,
    ],

    'xp_rates' => [
        'per_minute'     => 35,
        'per_10_minutes' => 300,
    ],

    'top' => [
        'all'  => 50,
        'head' => 3,
        'vip'  => 5,
    ],
];
