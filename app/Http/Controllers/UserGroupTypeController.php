<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserGroupType\UserGroupTypeRequest;
use App\Models\GroupType;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UserGroupTypeController
 * @package App\Http\Controllers
 */
class UserGroupTypeController extends Controller
{
	public function list ()
	{
		$groupTypes = GroupType::all();
		$users      = User::whereHas('trainerInfo')->get();

		$usersGroupTypes = $users->map(function (User $user) use ($groupTypes) {
			return [
				'full_name'   => $user->full_name,
				'name'        => $user->name,
				'group_types' => $groupTypes->map(function ($groupType) use ($user) {
					$groupType->has_group_type = $user->groupTypes->contains($groupType->id);

					return $groupType;
				}),
			];
		});

		return $this->sendResponse($usersGroupTypes);
	}

	/**
	 * @param User                 $user
	 * @param UserGroupTypeRequest $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function sync (User $user, UserGroupTypeRequest $request)
	{
		/** @var Collection $userGroupTypes */
		$userGroupTypes = GroupType::whereIn('slug', $request->user_group_types)
		                           ->get();

		if ($userGroupTypes->isNotEmpty())
			$userGroupTypes = $userGroupTypes->pluck('id');

		$user->groupTypes()->sync($userGroupTypes->toArray());

		return $this->list();
	}
}
