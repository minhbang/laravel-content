<?php
Route::group(
    ['prefix' => 'content', 'namespace' => 'Minhbang\Content', 'middleware' => config('content.middlewares.frontend')],
    function () {
        Route::get('{slug}', ['as' => 'content.show', 'uses' => 'FrontendController@show']);
    }
);

Route::group(
    ['prefix' => 'backend', 'namespace' => 'Minhbang\Content', 'middleware' => config('content.middlewares.backend')],
    function () {
        Route::get('content/data', ['as' => 'backend.content.data', 'uses' => 'BackendController@data']);
        Route::get('content/{content}/preview', ['as' => 'backend.content.preview', 'uses' => 'BackendController@preview']);
        Route::post('content/{content}/quick_update', ['as' => 'backend.content.quick_update', 'uses' => 'BackendController@quickUpdate']);
        Route::resource('content', 'BackendController');
    }
);
