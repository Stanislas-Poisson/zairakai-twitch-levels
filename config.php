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
            'kholoh',
            'charly_bell',
            'el_girafon',
            'lhyx__',
        ],
        'vips_honoraires'      => [
            'bluestardust_',
            'deafmute',
            'gunter423_',
            'crazymeal',
        ],
        'vips_trimestre_sound' => [
            'saltythom',
            'spawer88',
            'chiragi_lauvel',
            'mariepepin',
            'tonton_flingueur_',
        ],
        'vips_trimestre'       => [
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
        ],
        'artistes'             => [
            'bluestardust_',
            'dessinsamelie',
            'maiko_ema',
            'mariepepin',
        ],
        'subs'                 => [
            'pi314413',
            'langousteam',
            'nao_mynn',
            'sirlink__',
            'saltythom',
            'flora5912',
            'hyperion__rl',
            'bonjour',
            'Ore_Sama18',
            'el_girafon',
            'dame_ophelie'
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
        0   => 0
    ],

    'xp_rates' => [
        'per_minute'     => 35,
        'per_10_minutes' => 300
    ]
];
