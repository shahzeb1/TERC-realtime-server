<?php


Route::group(['middleware' => ['web']], function () {

	/**
	 * Show these routes when user is logged out:
	 */
	Route::get('/', 'HomeController@showHome')->name('home');
	Route::post('/loginNewUser', 'HomeController@login')->name('login');
	Route::get('/logoutThisUser', 'HomeController@logout')->name('logout');
    Route::get('/newUser', 'HomeController@newUser')->name('newUser');

});

/**
 * Show these routes when user is logged in:
 */
Route::group(['as' => 'dash::', 'middleware' => 'auth'], function () {
    Route::get('/dashboard', 'DashController@showDash')->name('dashboard');
    Route::get('/settings', 'DashController@showSettings')->name('settings');
});

Route::group(['as' => 'docs::', 'middleware' => 'auth'], function () {
    Route::get('/realtime', 'Realtime@showRealtime')->name('realtime');
    Route::get('/realtime/{name}', 'Realtime@showRealtimeFor')->name('showRealtime');
    Route::get('/historic', 'Historic@showOptions')->name('historic');
    Route::get('/historic/{name}', 'Historic@showHistoricFor')->name('showHistoric');
    Route::get('/app', 'App@showOptions')->name('app');
    Route::get('/app/{name}', 'App@showApp')->name('showApp');
    Route::get('/homewood/', 'Historic@showHomewood')->name('showHomewood');
    Route::get('/nasa/', 'Historic@showNASA')->name('showNASA');
});

/**
 * API routes:
 */
Route::group(['as' => 'api::', 'middleware' => 'cors'], function () {
    Route::get('/api/v1/realtime/{name}', 'API@showRealtime')->name('realtimeAPI');
    Route::get('/api/v1/historic/{name}', 'API@showHistoric')->name('historicAPI');
    Route::get('/api/v1/app/users', 'API@showParseUser')->name('appAPIuser');
    Route::get('/api/v1/app/{type}', 'API@showParseData')->name('appAPIdata');
    Route::get('/api/v1/homewood/', 'API@showHomewood')->name('homewood');
    Route::get('/api/v1/nasa/', 'API@showNASA')->name('nasa');
});