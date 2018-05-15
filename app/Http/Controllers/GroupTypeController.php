<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupType\CreateGroupTypeRequest;
use App\Models\GroupType;


class GroupTypeController extends Controller
{
	public function create (CreateGroupTypeRequest $request)
	{
		/** @noinspection PhpDynamicAsStaticMethodCallInspection */
		$groupType = GroupType::orderBy('display_order', 'DESC')->first();
		if (is_null($groupType))
			$displayOrder = 1;
		else
			$displayOrder = $groupType->display_order + 1;

		$path = $request->img->store('/img/groupTypes');

		GroupType::create([
			'slug'          => slugIt($request->display),
			'description'   => $request->description,
			'img'           => $path,
			'display'       => $request->display,
			'display_order' => $displayOrder,
		]);
	}
}
