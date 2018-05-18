<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupType\CreateGroupTypeRequest;
use App\Models\GroupType;

/**
 * Class GroupTypeController
 * @package App\Http\Controllers
 */
class GroupTypeController extends Controller
{
	/**
	 * @param CreateGroupTypeRequest $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function create (CreateGroupTypeRequest $request)
	{
		\DB::beginTransaction();

		$fileName = slugIt($request->display_name);

		$lastGroupType = GroupType::orderBy('display_order', 'DESC')->first();
		if (is_null($lastGroupType))
			$displayOrder = 1;
		else
			$displayOrder = $lastGroupType->display_order + 1;

		$filePath = 'groups/' . $fileName . '.png';

		$groupType = GroupType::create([
			'slug'          => $fileName,
			'display_name'  => $request->display_name,
			'requirements'  => $request->requirements,
			'duration'      => $request->duration,
			'description'   => $request->description,
			'img'           => $filePath,
			'display_order' => $displayOrder,
		]);

		$imagePath = $groupType->getRealImagePath();

		if (\File::exists($imagePath))
			\File::delete($imagePath);

		\Image::make(( $request->image ))
			  ->encode('png', 50)
			  ->save($imagePath);

		\DB::commit();

		return response([
			'status' => 'success',
			'data'   => $groupType,
		]);
	}

	/**
	 * @param GroupType $groupType
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function delete (GroupType $groupType)
	{
		$groupType->delete();

		if (\File::exists($imagePath = $groupType->getRealImagePath()))
			\File::delete($imagePath);

		return response([
			'status' => 'success',
		]);
	}

	/**
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function get ()
	{
		$groupTypes = GroupType::orderBy('display_order')
							   ->get()
		->map(function($groupType){
			/** @var GroupType $groupType */
			$groupType->img_url = $groupType->getImageUrl();
			return $groupType;
		});

		return response([
			'status' => 'success',
			'data'   => $groupTypes->toArray(),
		]);
	}
}