<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterFormRequest;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
	/**
	 * @param RegisterFormRequest $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function register (RegisterFormRequest $request)
	{
		return response([
			'status' => 'success',
			'data'   => User::create([
							'email'    => $request->email,
							'name'     => $request->name,
							'password' => $request->password,
						]),
		], 200);
	}


	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function login (Request $request)
	{
		$credentials = $request->only('email', 'password');

		if (! $token = JWTAuth::attempt($credentials))
			return response([
				'status' => 'error',
				'error'  => 'invalid.credentials',
				'msg'    => 'Invalid Credentials.',
			], 400);

		return response([
			'status' => 'success',
			'token'  => $token,
		]);
	}


	/**
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function user ()
	{
		/** @var User $user */
		$user         = User::findOrFail(Auth::user()->id);
		$user->avatar = $user->profile->avatar;

		return response([
			'status' => 'success',
			'data'   => $user,
		]);
	}

	/**
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function logout ()
	{
		JWTAuth::invalidate();

		return response([
			'status' => 'success',
			'msg'    => 'Logged out Successfully.',
		], 200);
	}

	/**
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function refresh ()
	{
		return response([
			'status' => 'success',
		]);
	}
}
