<?php

Route::group (['middleware' => ['web']], function () {

    Route::group (
        ['prefix' => 'admin', 'middleware' => 'auth.admin'], function () {


            Route::any('banners/banners_all',  array(
                    'as' => 'banners_all',
                    'uses' => 'Vis\Banners\Controllers\BannersController@fetchIndex')
            );

            Route::any('banners/area',  array(
                    'as' => 'ploshadki_all',
                    'uses' => 'Vis\Banners\Controllers\PlatformsController@fetchIndex')
            );

            if (Request::ajax()) {

                Route::post('banners/area/create_pop', array(
                        'as' => 'created_area',
                        'uses' => 'Vis\Banners\Controllers\PlatformsController@fetchCreateArea')
                );

                Route::post('banners/banner/create_pop', array(
                        'as' => 'created_banner',
                        'uses' => 'Vis\Banners\Controllers\BannersController@fetchCreateBanner')
                );

                Route::post('banners/area/add_record', array(
                        'as' => 'add_record',
                        'uses' => 'Vis\Banners\Controllers\PlatformsController@doSaveArea')
                );

                Route::post('banners/banner/add_record', array(
                        'as' => 'add_record',
                        'uses' => 'Vis\Banners\Controllers\BannersController@doSaveBanner')
                );

                Route::post('banners/area/edit_record', array(
                        'as' => 'edit_record',
                        'uses' => 'Vis\Banners\Controllers\PlatformsController@fetchEditArea')
                );

                Route::post('banners/banner/edit_record', array(
                        'as' => 'edit_record',
                        'uses' => 'Vis\Banners\Controllers\BannersController@fetchEditBanner')
                );

                Route::post('banners/area/delete', array(
                        'as' => 'delete_area',
                        'uses' => 'Vis\Banners\Controllers\PlatformsController@doDeleteArea')
                );

                Route::post('banners/banner/delete', array(
                        'as' => 'delete_area',
                        'uses' => 'Vis\Banners\Controllers\BannersController@doDeleteBanner')
                );
            }
    });
});
if (Request::ajax()) {
    Route::post('/banner_stat', array(
            'uses' => 'Vis\Banners\Controllers\BannersController@doIncrementClickCount')
    );
}
