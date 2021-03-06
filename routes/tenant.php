<?php

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider
| with the tenancy and web middleware groups. Good luck!
|
*/

Route::get('/app', function () {
    return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
});

Route::get('/', 'TenantController@index')->name('tenant.dashboard');
Route::get('dashboard', 'TenantController@index')->name('tenant.dashboard');
Route::get('tenant/create/{token}', 'TenantController@create')->name('tenant.create');

// Route::middleware('universal')->group(function(){
// 	Route::get('login', '\Laravel\Spark\Http\Controllers\Auth\LoginController@showLoginForm');
// });
