<?php

return [
    'fb_api_key' => env('FACEBOOK_API_KEY'),
    'fb_secret_key' => env('FACEBOOK_SECRET_KEY'),
    'fb_daily_at' => env('FACEBOOK_DAILY_AT', '7:00'),
    'fb_timezone' => env('FACEBOOK_TIMEZONE', 'Europe/Kiev')
];