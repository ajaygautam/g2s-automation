<?php

return [
    'peak_days' => [
        'Friday',
        'Saturday',
        'Sunday'
    ],
    'off_peak_days' => [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday'
    ],
    'holiday_dates'=>[
        '2019-07-04',
        '2019-09-13',
        '2019-09-14',
        '2019-09-15',
        '2019-09-16',
        '2019-09-17',
        '2019-09-18',
        
    ],
    'tax' => 6.35,
    'keys' => include(base_path()."/keys.php"),
    'default_config_keys' =>[
        (object)['config_key'=>'Organization Name','config_value'=>''], 
        (object)['config_key'=>'Location Code','config_value'=>''], 
        (object)['config_key'=>'Address','config_value'=>''], 
        (object)['config_key'=>'Phone','config_value'=>''], 
        (object)['config_key'=>'Contact Person','config_value'=>''], 
        (object)['config_key'=>'Timezone','config_value'=>''], 
        (object)['config_key'=>'Peak Start Month','config_value'=>''], 
        (object)['config_key'=>'Off Peak Start Month','config_value'=>''], 
        (object)['config_key'=>'Currency','config_value'=>''], 
        (object)['config_key'=>'Tax','config_value'=>''], 
        
    ]
];
