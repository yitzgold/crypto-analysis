<?php
return[

    'coins' => [
        'BTC', 'LTC', 'ETH'
    ],
    'auth' => [
        'oauth_access_token' => env('TWITTER_ACCESS_TOKEN'),
        'oauth_access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),
        'consumer_key' => env('TWITTER_CONSUMER_KEY'),
        'consumer_secret' => env('TWITTER_CONSUMER_SECRET')
    ],
    'url' => 'https://api.twitter.com/1.1/search/tweets.json',
    'requestMethod' => 'GET',
];