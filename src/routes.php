<?php

Route::group(['namespace' => 'DivArt\FBReviews\Controllers', 'prefix' => 'fbreview'], function() {
    Route::get('/reviews', 'FbController@get');
    Route::get('/oauth', 'FbController@access_token');
});