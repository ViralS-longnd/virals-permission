<?php
Route::group(
    [
        'namespace'  => 'ViralsInfyom\ViralsPermission\Controllers',
        'middleware' => 'web',
        'prefix'     => 'admin',
        'as'       => 'admin.'
    ], function () {
    Route::get('permission', 'Admin\PermissionController@index')->name('permission.index');
    Route::post('permission', 'Admin\PermissionController@store')->name('permission.store');
    Route::delete('permission/{permissionId}', 'Admin\PermissionController@destroy')->name('permission.destroy');
    Route::resource('roles', 'Admin\RoleController');
    Route::get('users/roles/show', 'Admin\UserController@showPermission')->name('users.roles.permissions');
    Route::resource('users', 'Admin\UserController');
});