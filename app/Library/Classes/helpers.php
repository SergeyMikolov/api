<?php

use Illuminate\Support\Collection;

/**
 * @param string $string
 * @return string
 */
function slugIt (string $string) : string
{
	return strtoupper(str_slug($string, '_'));
}

/**
 * @param string $imagePath
 * @return string
 */
function imgUrl (string $imagePath) : string
{
	return url('images/' . $imagePath);
}

/**
 * @param $data
 * @return array
 */
function makeArray ($data) : array
{
	if (   $data instanceof \Illuminate\Support\Collection
		OR $data instanceof \Illuminate\Database\Eloquent\Collection
		OR $data instanceof \Illuminate\Database\Eloquent\Model     )
		return $data->toArray();
	else
		return (array)$data;
}

/**
 * @param      $items
 * @param bool $itemsToObject
 * @return Collection
 */
function mixedToCollection ($items, $itemsToObject = false) : Collection
	{
		if ($itemsToObject) {
			$json  = json_encode($items);
			$items = json_decode($json);
		}

		if (! $items instanceof Collection || ! $items instanceof \Illuminate\Database\Eloquent\Collection)
			$items = collect($items);

		$items->each(function($item, $key) use ($items) {
			if (\is_array($item)) {
				$collection = self::mixedToCollection($item);
				$items->put($key, $collection);
			}
		});
		return $items;
	}