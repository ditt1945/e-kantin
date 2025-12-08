<?php

return [
    'EKANTIN10' => [
        'type' => 'percent',
        'value' => 10,
        'max_discount' => 20000,
        'min_order' => 50000,
        'description' => 'Diskon 10% hingga Rp20.000'
    ],
    'HEMAT5K' => [
        'type' => 'flat',
        'value' => 5000,
        'min_order' => 20000,
        'description' => 'Potongan langsung Rp5.000'
    ],
    'GRATISONGKIR' => [
        'type' => 'flat',
        'value' => 10000,
        'min_order' => 0,
        'description' => 'Diskon ongkir Rp10.000'
    ],
];
