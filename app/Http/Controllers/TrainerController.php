<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TrainerController
 * @package App\Http\Controllers
 */
class TrainerController extends Controller
{
	public function getTrainers ()
	{
		$trainers = User::whereHas('roles', function (Builder $role) {
			$role->whereSlug(Role::TRAINER);
		})
		                ->select('name', 'first_name', 'last_name')
		                ->get();

		return $this->sendResponse($trainers);
	}

	public function create()
	{

	}
}
