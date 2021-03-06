<?php

class LoginController extends \BaseController {

	public function __construct() {

		$this->beforeFilter('guest');

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('server.login.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$credentials = array(
			'username' => Input::get('username'),
			'password' => Input::get('password')
		);

		$rules = array(
			'username' => 'required',
			'password' => 'required'
		);

		$validator = Validator::make($credentials, $rules);

		if(!$validator->fails()) {

			if(Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password')))) {

				if(Input::get('route')) {
					return Redirect::to(Input::get('route'));
				}
				else {
					return Redirect::to('dashboard');
				}

			}
			else {

				return Redirect::to('login')->withInput(Input::except('password'))->with('error', 'Invalid credentials.');

			}

		}
		else {

			return Redirect::to('login')->withInput(Input::except('password'))->withErrors($validator);

		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}