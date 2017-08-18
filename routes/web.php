<?php

Route::name('files')->get('/', 'FileController@index');
Route::name('open_directorie')->get('/file', 'FileController@open');
Route::name('store_directorie')->post('/file/store', 'FileController@store');
Route::name('upload_file')->post('/file/upload', 'FileController@upload');
Route::name('download_file')->post('/file/download', 'FileController@download');
Route::name('delete_filemanager')->post('/file/delete', 'FileController@delete');

// Route for login
Route::name('home_login')->get('/login', 'LoginController@index');
Route::name('login')->post('/login', 'LoginController@login')->middleware('access');
