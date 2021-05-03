<?php

Route::post('login', 'LoginController@login');
Route::get('user/info', 'LoginController@info');
Route::post('user/logout', 'LoginController@info');

Route::group([
    'middleware' => ['auth:admin', 'role:admin|super'],
], function () {
    Route::post('img/upload', 'CommonController@uploadImage');

    Route::get('grade/rank', 'GradeController@rank');
    Route::get('grade/download', 'GradeController@download');
    Route::get('grade/classDownload', 'GradeController@classDownload');
    Route::delete('grade/clean', 'GradeController@truncate');
});

// 管理员专属
Route::group([
    'middleware' => ['auth:admin', 'role:super'],
], function () {

    Route::get('admin/log', 'AdminController@logList');
    Route::get('admin/list', 'AdminController@index');
    Route::post('admin', 'AdminController@store');
    Route::get('admin', 'AdminController@edit');
    Route::put('admin', 'AdminController@update');
    Route::delete('admin', 'AdminController@destroy');
});