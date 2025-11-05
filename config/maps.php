<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Maps Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Google Maps integration in the cultural heritage system
    |
    */

    'api_key' => env('GOOGLE_MAPS_API_KEY', ''),
    
    'default_coordinates' => [
        'latitude' => 13.7563,
        'longitude' => 100.5018,
    ],
    
    'map_defaults' => [
        'zoom' => 12,
        'center' => [
            'lat' => 13.7563,
            'lng' => 100.5018,
        ],
    ],
    
    'marker_options' => [
        'draggable' => true,
        'animation' => 'DROP',
    ],
];