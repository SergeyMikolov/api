<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterFormRequest;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
	public function register (RegisterFormRequest $request)
	{
		$user           = new User;
		$user->email    = $request->email;
		$user->name     = $request->name;
		$user->password = bcrypt($request->password);
		$user->save();

		return response([
			'status' => 'success',
			'data'   => $user,
		], 200);
	}


	public function login (Request $request)
	{
		$credentials = $request->only('email', 'password');
		/** @noinspection PhpDynamicAsStaticMethodCallInspection */
		if (! $token = JWTAuth::attempt($credentials)) {
			return response([
				'status' => 'error',
				'error'  => 'invalid.credentials',
				'msg'    => 'Invalid Credentials.',
			], 400);
		}

		return response([
			'status' => 'success',
			'token'  => $token,
		]);
	}


	public function user ()
	{
		/** @var User $user */
		$user = User::find(Auth::user()->id);
		$user->avatar = $user->profile->avatar;

		return response([
			'status' => 'success',
			'data'   => $user,
		]);
	}

	public function logout ()
	{
		JWTAuth::invalidate();

		return response([
			'status' => 'success',
			'msg'    => 'Logged out Successfully.',
		], 200);
	}

	public function refresh ()
	{
		return response([
			'status' => 'success',
		]);
	}
}
