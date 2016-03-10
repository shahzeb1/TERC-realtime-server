<?php


Route::group(['middleware' => ['web']], function () {

	/**
	 * Show these routes when user is logged out:
	 */
	Route::get('/', 'HomeController@showHome')->name('home');
	Route::post('/loginNewUser', 'HomeController@login')->name('login');
	Route::get('/logoutThisUser', 'HomeController@logout')->name('logout');

});

/**
 * Show these routes when user is logged in:
 */
Route::group(['as' => 'dash::'], function () {
    Route::get('/dashboard', 'DashController@showDash')->name('dashboard');
    Route::get('/settings', 'DashController@showSettings')->name('settings');
});

Route::group(['as' => 'docs::'], function () {
    Route::get('/realtime', 'Realtime@showRealtime')->name('realtime');
    Route::get('/realtime/{name}', 'Realtime@showRealtimeFor')->name('showRealtime');
    Route::get('/historic', 'Historic@showRealtime')->name('historic');
    Route::get('/historic/{name}', 'Historic@showRealtimeFor')->name('showHistoric');
});

/**
 * API routes:
 */
Route::group(['as' => 'api::'], function () {
    Route::get('/api/v1/realtime/{name}', 'API@showRealtime')->name('realtimeAPI');
    Route::get('/api/v1/historic/{name}', 'API@showRealtime')->name('realtimeAPI');
});