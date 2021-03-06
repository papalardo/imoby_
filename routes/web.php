<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth
Route::get('login')->name('login')->uses('Auth\LoginController@showLoginForm')->middleware('guest');
Route::post('login')->name('login.attempt')->uses('Auth\LoginController@login')->middleware('guest');
Route::post('logout')->name('logout')->uses('Auth\LoginController@logout');

// Dashboard
Route::get('/')->name('dashboard')->uses('DashboardController')->middleware('auth');

// Users
// Route::get('users')->name('users')->uses('UsersController@index')->middleware('remember', 'auth');
// Route::get('users/create')->name('users.create')->uses('UsersController@create')->middleware('auth');
// Route::post('users')->name('users.store')->uses('UsersController@store')->middleware('auth');
// Route::get('users/{user}/edit')->name('users.edit')->uses('UsersController@edit')->middleware('auth');
// Route::put('users/{user}')->name('users.update')->uses('UsersController@update')->middleware('auth');
// Route::delete('users/{user}')->name('users.destroy')->uses('UsersController@destroy')->middleware('auth');
// Route::put('users/{user}/restore')->name('users.restore')->uses('UsersController@restore')->middleware('auth');

// Images
Route::get('/img/{path}', 'ImagesController@show')->where('path', '.*');

// Organizations
// Route::get('organizations')->name('organizations')->uses('OrganizationsController@index')->middleware('remember', 'auth');
// Route::get('organizations/create')->name('organizations.create')->uses('OrganizationsController@create')->middleware('auth');
// Route::post('organizations')->name('organizations.store')->uses('OrganizationsController@store')->middleware('auth');
// Route::get('organizations/{organization}/edit')->name('organizations.edit')->uses('OrganizationsController@edit')->middleware('auth');
// Route::put('organizations/{organization}')->name('organizations.update')->uses('OrganizationsController@update')->middleware('auth');
// Route::delete('organizations/{organization}')->name('organizations.destroy')->uses('OrganizationsController@destroy')->middleware('auth');
// Route::put('organizations/{organization}/restore')->name('organizations.restore')->uses('OrganizationsController@restore')->middleware('auth');

// // Contacts
// Route::get('contacts')->name('contacts')->uses('ContactsController@index')->middleware('remember', 'auth');
// Route::get('contacts/create')->name('contacts.create')->uses('ContactsController@create')->middleware('auth');
// Route::post('contacts')->name('contacts.store')->uses('ContactsController@store')->middleware('auth');
// Route::get('contacts/{contact}/edit')->name('contacts.edit')->uses('ContactsController@edit')->middleware('auth');
// Route::put('contacts/{contact}')->name('contacts.update')->uses('ContactsController@update')->middleware('auth');
// Route::delete('contacts/{contact}')->name('contacts.destroy')->uses('ContactsController@destroy')->middleware('auth');
// Route::put('contacts/{contact}/restore')->name('contacts.restore')->uses('ContactsController@restore')->middleware('auth');

Route::get('properties', 'PropertiesController@index')->name('properties')->middleware('remember', 'auth');
Route::resource('properties', 'PropertiesController')->middleware('auth')->except('index');

Route::get('tenants', 'TenantsController@index')->name('tenants')->middleware('remember', 'auth');
Route::resource('tenants', 'TenantsController')->middleware('auth')->except('index');
Route::put('tenants/{tenant}/restore')->name('tenants.restore')->uses('TenantsController@restore')->middleware('auth');

Route::get('contracts', 'ContractsController@index')->name('contracts')->middleware('remember', 'auth');
Route::resource('contracts', 'ContractsController')->middleware('auth')->except('index');

Route::get('locators', 'PropertyOwnerController@index')->name('locators')->middleware('remember', 'auth');
Route::resource('locators', 'PropertyOwnerController')->middleware('auth')->except('index');
Route::put('locators/{locator}/restore')->name('locators.restore')->uses('PropertyOwnerController@restore')->middleware('auth');

Route::model('rental_payment', App\Models\RentalPayment::class);
Route::get('rental-payment')->name('rental_payment')->uses('RentalPaymentsController@index')->middleware('auth');
Route::get('rental-payment/{month}/{year}/{contract}')->name('rental_payment.create')->uses('RentalPaymentsController@create')->middleware('auth');
Route::post('rental-payment/{contract}')->name('rental_payment.store')->uses('RentalPaymentsController@store')->middleware('auth');
Route::put('rental-payment/{rental_payment}')->name('rental_payment.update')->uses('RentalPaymentsController@update')->middleware('auth');

// Reports
// Route::get('reports')->name('reports')->uses('ReportsController')->middleware('auth');

// 500 error
Route::get('500', function () {
    // Force debug mode for this endpoint in the demo environment
    if (App::environment('demo')) {
        Config::set('app.debug', true);
    }

    echo $fail;
});
