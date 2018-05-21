<?php

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
	if ($data instanceof \Illuminate\Support\Collection OR $data instanceof \Illuminate\Database\Eloquent\Collection)
		return $data->toArray();
	else
		return (array)$data;
}