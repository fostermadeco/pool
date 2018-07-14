<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Segment Write Key
    |--------------------------------------------------------------------------
    |
    | It will be assumed that Auth::user()
    |
    */

    'secret' => env('SEGMENT_WRITE_KEY', null),

    /*
    |--------------------------------------------------------------------------
    | Segment Consumer Options
    |--------------------------------------------------------------------------
    |
    | Options for making Segment calls. These vary by the Segment Consumer.
    | This array can be added to or removed from.
    |
    */

    'options' => [
        // Used by all Consumers
        'consumer' => env('SEGMENT_CONSUMER', null),
        'debug' => env('SEGMENT_DEBUG', false),
        'ssl' => env('SEGMENT_SSL', true),
        'error_handler' => null,

        // File Consumer
        'filename' => null,

        // Queue Consumer
        'batch_size' => null,
        'max_queue_size' => null,

        // Socket Consumer
        'timeout' => null,
        'host' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | User Identification
    |--------------------------------------------------------------------------
    |
    | Configure the default way users will be identified. Using 'key' will use
    | the Model's key. For anything else, it will be assumed this is referring
    | to an attribute on the model and use that
    |
    | Examples: "key", "uuid", "email" (not recommended), "username" (again,
    | not recommended), "SSN" (don't actually use this)
    |
    */

    'user_id' => 'key',

    /*
    |--------------------------------------------------------------------------
    | Integrations
    |--------------------------------------------------------------------------
    |
    | The default destinations a message will be sent to.
    |
    */

    'integrations' => [],

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    |
    | Segment has reserved properties and traits it suggests be set in certain
    | formats. Setting this value to boolean true will throw exceptions if the
    | data in the message does not match the suggested format.
    |
    */

    'validate' => env('SEGMENT_VALIDATE', true),
];