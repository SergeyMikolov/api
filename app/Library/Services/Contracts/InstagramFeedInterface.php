<?php

interface InstagramFeedInterface
{
	public function getUserData();

	public function login();

	public function getUserFeed($instagram);

	public function makeFeedCollection($apiResponse);
}