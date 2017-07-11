<?php

Route::name('files')->get('/', 'FileController@index');
Route::name('open_directorie')->post('/file', 'FileController@open');
Route::name('store_directorie')->post('/file/store', 'FileController@store');
Route::name('upload_file')->post('/file/upload', 'FileController@upload');
Route::name('delete_filemanager')->post('/file/delete', 'FileController@delete');