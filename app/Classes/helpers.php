<?php

function slugIt(string $string)
{
	return strtoupper(str_slug($string, '_'));
}

function imgUrl(string $imagePath)
{
	return url('images/' . $imagePath);
}