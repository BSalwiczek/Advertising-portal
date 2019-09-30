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

Route::post('/getUsers','ApiController@getUsers');


Route::group(['middleware' => 'auth:api'], function(){
	Route::post('details', 'UsersApiController@details')->middleware('verified');
}); // will work only when user has verified the email

Route::get('email/verify/{id}', 'VerificationApiController@verify')->name('verificationapi.verify');
Route::post('email/resend', 'VerificationApiController@resend')->name('verificationapi.resend');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/klient/profil','ClientController@index');
Route::post('/masazysta/profil','MasseurController@index');
Route::get('/masazysta/profil','MasseurController@index');
Route::get('/get-ad-data','MasseurController@getAdData');


Route::get('/masazysci','MasseurNoticeController@index')->name('masazysci');
Route::get('/masazysci/{slug}','MasseurNoticeController@show');

Route::get('masazysta/dodaj-nowe-ogloszenie','MasseurNoticeController@create');
Route::post('masazysta/dodaj-nowe-ogloszenie','MasseurNoticeController@store');
Route::post('masazysta/zmien-ogloszenie','MasseurNoticeController@update');
Route::post('/dodano-nowe-ogloszenie','MasseurNoticeController@gotoads');

Route::post('/getCities','ApiController@getCities');

Route::post('/zapisz-ustawienia-uzytkownika-masazysty','EducoexpController@update');

Route::get('/get-user-and-educoexp','EducoexpController@index');

Route::post('/saveMessage','MessagesController@store');
Route::post('/getMessages','MessagesController@index');
Route::post('/seen-last-msg','MessagesController@seenLast');
Route::post('/get-unseen-messages','MessagesController@getUnseen');
// Route::post('/save-last-activity','MessagesController@seenLast');
Route::get('/getFriends','MessagesController@getFriends');

Route::post('/new-opinion','OpinionsController@store');
Route::get('/get-opinions','OpinionsController@index');
Route::post('/get-your-opinion','OpinionsController@getYourOpinion');


// 'MasseurController@gohome'
