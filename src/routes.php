<?php
Route::group(
    ['prefix' => 'content', 'namespace' => 'Minhbang\LaravelContent'],
    function () {
        Route::get('{slug}', ['as' => 'content.show', 'uses' => 'ContentFrontendController@show']);
    }
);

Route::group(
    ['prefix' => 'backend', 'namespace' => 'Minhbang\LaravelContent'],
    function () {
        Route::get('content/data', ['as' => 'backend.content.data', 'uses' => 'ContentBackendController@data']);
        Route::get(
            'content/{content}/preview',
            ['as' => 'backend.content.preview', 'uses' => 'ContentBackendController@preview']
        );
        Route::post('content/{content}/quick_update', ['as' => 'backend.content.quick_update', 'uses' => 'ContentBackendController@quickUpdate']);
        Route::resource('content', 'ContentBackendController');
    }
);
