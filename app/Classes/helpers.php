<?php

function slugIt(string $string)
{
	return strtoupper(str_slug($string, '_'));
}