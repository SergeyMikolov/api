<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrainerInfo\CreateTrainerInfoRequest;
use App\Http\Requests\TrainerInfo\SaveOrderAdDisplayRequest;
use App\Http\Requests\TrainerInfo\UpdateTrainerInfoRequest;
use App\Models\Role;
use App\Models\TrainerInfo;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TrainerController
 * @package App\Http\Controllers
 */
class TrainerController extends Controller
{
	/**
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function getTrainers ()
	{
		$trainers = User::whereHas('roles', function (Builder $role) {
			/** @noinspection PhpUndefinedMethodInspection */
			$role->whereSlug(Role::TRAINER);
		})
		                ->whereDoesntHave('trainerInfo')
		                ->get();

		$trainers->transform(function (User $trainer) {
			$data            = new \stdClass();
			$data->name      = $trainer->name;
			$data->full_name = $trainer->full_name;

			return $data;
		});

		return $this->sendResponse($trainers);
	}

	/**
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function getTrainersInfo ()
	{
		$trainersInfo = User::whereHas('trainerInfo')
		                    ->with('trainerInfo')
		                    ->get();

		$trainersInfo->transform(function (User $trainerInfo) {
			$info                = new \stdClass();
			$info->full_name     = $trainerInfo->full_name;
			$info->display       = $trainerInfo->trainerInfo->display;
			$info->display_order = $trainerInfo->trainerInfo->display_order;
			$info->img           = $trainerInfo->trainerInfo->img;
			$info->description   = $trainerInfo->trainerInfo->description;
			$info->img_url       = $trainerInfo->trainerInfo->getImageUrl();
			$info->name          = $trainerInfo->name;

			return $info;
		});

		return $this->sendResponse($trainersInfo->sortBy('display_order')->values());
	}

	/**
	 * @param User                     $trainer
	 * @param CreateTrainerInfoRequest $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function create (User $trainer, CreateTrainerInfoRequest $request)
	{
		\DB::beginTransaction();

		if ($trainer->trainerInfo !== null)
			return $this->sendBadResponse([], 'User already has trainer info!');

		$fileName = slugIt($trainer->full_name);

		$lastTrainerInfo = TrainerInfo::orderBy('display_order', 'DESC')->first();
		if (null === $lastTrainerInfo)
			$displayOrder = 1;
		else
			$displayOrder = $lastTrainerInfo->display_order + 1;

		$filePath = TrainerInfo::IMG_FOLDER . $fileName . '.png';

		/** @var TrainerInfo $trainerInfo */
		$trainerInfo = $trainer->trainerInfo()
		                       ->create([
			                       'description'   => $request->description,
			                       'img'           => $filePath,
			                       'display_order' => $displayOrder,
		                       ]);

		$imagePath = $trainerInfo->getRealImagePath();

		if (\File::exists($imagePath))
			\File::delete($imagePath);

		\Image::make($request->image)
		      ->encode('png', 50)
		      ->save($imagePath);

		\DB::commit();

		return $this->sendResponse($trainerInfo);
	}

	/**
	 * @param User                     $trainer
	 * @param UpdateTrainerInfoRequest $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function update (User $trainer, UpdateTrainerInfoRequest $request)
	{
		\DB::beginTransaction();

		$fileName     = slugIt($trainer->full_name);
		$oldImagePath = $trainer->trainerInfo->getRealImagePath();
		$filePath     = TrainerInfo::IMG_FOLDER . $fileName . '.png';

		if (null !== $request->image) {

			if (\File::exists($oldImagePath))
				\File::delete($oldImagePath);

			$trainer->trainerInfo->img = $filePath;
			\Image::make($request->image)
			      ->encode('png', 50)
			      ->save($oldImagePath);
		}

		$trainer->trainerInfo->description = $request->description;
		$trainer->trainerInfo->save();

		\DB::commit();

		$trainer->trainerInfo->fresh();

		return $this->sendResponse($trainer->trainerInfo);
	}

	/**
	 * @param User $trainer
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function delete (User $trainer)
	{
		$trainer->trainerInfo->delete();

		if (\File::exists($imagePath = $trainer->trainerInfo->getRealImagePath()))
			\File::delete($imagePath);

		return $this->sendResponse();
	}

	/**
	 * @param SaveOrderAdDisplayRequest $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function saveOrderAndDisplay (SaveOrderAdDisplayRequest $request)
	{
		collect($request->trainers_info)->each(function ($trainerInfo) {
			/** @var User $trainer */
			$trainer = User::whereName($trainerInfo[ 'name' ])
			               ->first();

			$trainer->trainerInfo->display       = $trainerInfo[ 'display' ];
			$trainer->trainerInfo->display_order = $trainerInfo[ 'display_order' ];
			$trainer->trainerInfo->save();

		});

		return $this->getTrainersInfo();
	}
}
