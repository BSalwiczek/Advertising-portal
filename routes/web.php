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

Route::get('/', function () {
    return view('home');
});

Auth::routes(['verify'=>true]);

Route::post('register', 'UsersApiController@register');


Route::group(['middleware' => 'auth:api'], function(){
	Route::post('details', 'UsersApiController@details')->middleware('verified');
}); // will work only when user has verified the email

Route::get('email/verify/{id}', 'VerificationApiController@verify')->name('verificationapi.verify');
Route::post('email/resend', 'VerificationApiController@resend')->name('verificationapi.resend');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/klient/profil','ClientController@index');
Route::get('/masazysta/profil','MasseurController@index');

Route::get('/masazysci','MasseurNoticeController@index')->name('masazysci');
Route::get('/masazysci/{slug}','MasseurNoticeController@show');

Route::get('masazysta/dodaj-nowe-ogloszenie','MasseurNoticeController@create');
Route::post('masazysta/dodaj-nowe-ogloszenie','MasseurNoticeController@store');
Route::post('/dodano-nowe-ogloszenie','MasseurNoticeController@gotoads');

// 'MasseurController@gohome'



