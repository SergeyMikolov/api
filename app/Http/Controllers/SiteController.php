<?php

namespace App\Http\Controllers;

use App\Models\GroupType;
use Illuminate\Http\Request;

class SiteController extends Controller
{
	public function getTrainings ()
	{
		$groupTypes = GroupType::whereDisplay(true)
							   ->orderBy('display_order')
							   ->get();

		return response([
			'status' => 'success',
			'data'   => $groupTypes,
		]);
	}
}
