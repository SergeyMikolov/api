<?php

namespace App\Http\Controllers;

use App\Models\GroupType;
use App\Models\User;

/**
 * Class SiteController
 * @package App\Http\Controllers
 */
class SiteController extends Controller
{
	/**
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function getTrainings ()
	{
		$groupTypes = GroupType::whereDisplay(true)
		                       ->orderBy('display_order')
		                       ->get();

		return $this->sendResponse($groupTypes);
	}

	/**
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function getTrainers ()
	{
		$trainersInfo = User::whereHas('trainerInfo')
		                    ->with('trainerInfo')
		                    ->get();

		$trainersInfo = $trainersInfo->map(function (User $trainerInfo) {
			$info              = new \stdClass();
			$info->full_name   = $trainerInfo->full_name;
			$info->img_url     = $trainerInfo->trainerInfo->getImageUrl();
			$info->description = $trainerInfo->trainerInfo->description;

			return $info;
		})
		                             ->sortBy('display_order')
		                             ->values();

		return $this->sendResponse($trainersInfo);
	}
}
