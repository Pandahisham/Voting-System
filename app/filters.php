<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login')->with('error', 'Please login to visit the page.')->with('route', Route::getCurrentRoute()->getPath());
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('dashboard');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

Route::filter('role', function() {
	if(Auth::user()->usertype_id != 1) {
		return Redirect::to('dashboard');
	}
});

Route::filter('studentAuth', function()
{
	if (Session::has('id')) return Redirect::to('/home');
});

Route::filter('studentGuest', function() 
{
	if(!Session::has('id')) return Redirect::to('/');
});

Route::filter('checkIfVoted', function() {
	$isVoted = DB::table('students')->where('isVoted', '=', '1')
								->where('id', '=', Session::get('id'))
								->count();

	if($isVoted > 0)
	{
		Session::forget('id');
		return Redirect::to('/')->with('error', 'Already voted!');
	}
});

