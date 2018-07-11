<?php
declare( strict_types = 1 );

namespace App\Drivers\Storage;

use Illuminate\Support\Facades\Cache;
use InstagramAPI\Exception\SettingsException;
use InstagramAPI\Settings\StorageInterface;

/**
 * Class Redis
 * @package App\Drivers\Storage
 */
class Redis implements StorageInterface
{
	const CACHE_TIME = 10;
	const SETTINGS   = 'settings';
	const COOKIES    = 'cookies';

	/**
	 * @var \Illuminate\Contracts\Cache\Repository
	 */
	protected $cache;

	/** @var string Current Instagram username that all settings belong to. */
	private $_username;

	/**
	 * @param array $locationConfig
	 */
	public function openLocation (array $locationConfig)
	{
		$this->cache = Cache::store('redis');
	}

	/**
	 * Whether the storage backend contains a specific user.
	 *
	 * Having a user is defined as HAVING the USERSETTINGS-portion of the data.
	 * The usercookies may be stored separately (such as in a cookiefile) and
	 * are NOT essential since they can be re-generated. So the data storage
	 * implementation MUST ONLY check for the existence of the USERSETTINGS.
	 *
	 * @param string $username The Instagram username.
	 *
	 * @throws \InstagramAPI\Exception\SettingsException
	 *
	 * @return bool TRUE if user exists, otherwise FALSE.
	 */
	public function hasUser ($username)
	{
		// Check whether the user's settings exist (empty string allowed).
		return $this->_getUserKey($username, self::SETTINGS);
	}

	/**
	 * Move the internal data for a username to a new username.
	 *
	 * Is NEVER called for the currently loaded user, so Storage backend writers
	 * can safely assume that you'll never be asked to rename the loaded user.
	 *
	 * Before performing the move, this function MUST validate that the OLD user
	 * EXISTS and that the NEW user DOESN'T EXIST, and MUST throw an exception
	 * if either of those checks fail. This is to ensure that users don't lose
	 * data by accidentally overwriting something.
	 *
	 * @param string $oldUsername The old name that settings are stored as.
	 * @param string $newUsername The new name to move the settings to.
	 *
	 * @throws \InstagramAPI\Exception\SettingsException
	 */
	public function moveUser ($oldUsername, $newUsername)
	{
		// Verify that the old username exists and fetch the old data.
		$oldSettings = $this->_getUserKey($oldUsername, self::SETTINGS);
		$oldCookies  = $this->_getUserKey($oldUsername, self::COOKIES);
		if ($oldSettings === null) { // Only settings are vital.
			throw new SettingsException(sprintf(
				'Cannot move non-existent user "%s".',
				$oldUsername
			));
		}

		// Verify that the new username does not exist.
		if ($this->hasUser($newUsername)) {
			throw new SettingsException(sprintf(
				'Refusing to overwrite existing user "%s".',
				$newUsername
			));
		}

		// Now attempt to write all data to the new name.
		$this->_setUserKey($newUsername, self::SETTINGS, $oldSettings);
		if ($oldCookies !== null) { // Only if cookies existed.
			$this->_setUserKey($newUsername, self::COOKIES, $oldCookies);
		}

		// Delete the previous user keys.
		$this->deleteUser($oldUsername);
	}

	/**
	 * Delete all internal data for a given username.
	 *
	 * Is NEVER called for the currently loaded user, so Storage backend writers
	 * can safely assume that you'll never be asked to delete the loaded user.
	 *
	 * This function MUST treat a non-existent or already deleted user as
	 * "success". ONLY throw an exception if ACTUAL deletion fails.
	 *
	 * @param string $username The Instagram username.
	 *
	 * @throws \InstagramAPI\Exception\SettingsException
	 */
	public function deleteUser ($username)
	{
		$this->_delUserKey($username, self::SETTINGS);
		$this->_delUserKey($username, self::COOKIES);
	}

	/**
	 * Open the data storage for a specific user.
	 *
	 * If the user does not exist, THIS call MUST create their user storage, or
	 * at least do any necessary preparations so that the other functions can
	 * read/write to the user's storage (and behave as specified).
	 *
	 * Is called every time we're switching to a user, and happens before we
	 * call any user-specific data retrieval functions.
	 *
	 * This function must cache the user reference and perform necessary backend
	 * operations, such as opening file/database handles and finding the row ID
	 * for the given user, so that all further queries know what user to use.
	 *
	 * All further calls relating to that user will assume that your storage
	 * class has cached the user reference we gave you in this call.
	 *
	 * @param string $username The Instagram username.
	 *
	 * @throws \InstagramAPI\Exception\SettingsException
	 */
	public function openUser ($username)
	{
		$this->_username = $username;
	}

	/**
	 * Load all settings for the currently active user.
	 *
	 * @throws \InstagramAPI\Exception\SettingsException
	 *
	 * @return array An array with all current key-value pairs for the user, or
	 *               an empty array if no settings exist.
	 */
	public function loadUserSettings ()
	{
		$userSettings = [];

		$encodedData = $this->_getUserKey($this->_username, self::SETTINGS);
		if ( ! empty($encodedData)) {
			$userSettings = @json_decode($encodedData, true, 512, JSON_BIGINT_AS_STRING);
			if ( ! is_array($userSettings)) {
				throw new SettingsException(sprintf(
					'Failed to decode corrupt settings for account "%s".',
					$this->_username
				));
			}
		}

		return $userSettings;
	}

	/**
	 * Save the settings for the currently active user.
	 *
	 * Is called every time any setting changes. The trigger-key can be used for
	 * selectively saving only the modified setting. But most backends should
	 * simply JSON-encode the whole $userSettings array and store that string.
	 *
	 * @param array  $userSettings An array with all of the user's key-value pairs.
	 * @param string $triggerKey   The differing key which triggered the write.
	 *
	 * @throws \InstagramAPI\Exception\SettingsException
	 */
	public function saveUserSettings (array $userSettings, $triggerKey)
	{
		// Store the settings as a JSON blob.
		$encodedData = json_encode($userSettings);
		$this->_setUserKey($this->_username, self::SETTINGS, $encodedData);
	}

	/**
	 * Whether the storage backend has cookies for the currently active user.
	 *
	 * Even cookiefile (file-based jars) MUST answer this question, for example
	 * by checking if their desired cookiefile exists and is non-empty. And all
	 * other storage backends (such as databases) MUST also verify that their
	 * existing cookie data is non-empty.
	 *
	 * Don't validate the actual cookie contents, just look for non-zero size!
	 *
	 * @throws \InstagramAPI\Exception\SettingsException
	 *
	 * @return bool TRUE if cookies exist, otherwise FALSE.
	 */
	public function hasUserCookies ()
	{
		// Simply check if the storage key for cookies exists and is non-empty.
		return ! empty($this->loadUserCookies()) ? true : false;
	}

	/**
	 * Get the cookiefile disk path (only if a file-based cookie jar is wanted).
	 *
	 * The file does not have to exist yet. It will be created by the caller
	 * on-demand when necessary.
	 *
	 * @throws \InstagramAPI\Exception\SettingsException
	 *
	 * @return string|null Either a non-empty string file-path to use a
	 *                     file-based cookie jar which the CALLER will
	 *                     read/write, otherwise NULL (or any other
	 *                     non-string value) if the BACKEND wants to
	 *                     handle the cookies itself.
	 */
	public function getUserCookiesFilePath ()
	{
		return null;
	}

	/**
	 * (Non-cookiefile) Load all cookies for the currently active user.
	 *
	 * Note that this function is ONLY called if a non-string answer was
	 * returned by the getUserCookiesFilePath() call.
	 *
	 * If your Storage backend class uses a cookiefile, make this a no-op.
	 *
	 * @throws \InstagramAPI\Exception\SettingsException
	 *
	 * @return string|null A previously-stored raw cookie data string, or an
	 *                     empty string/NULL if no data exists in the storage.
	 */
	public function loadUserCookies ()
	{
		return $this->_getUserKey($this->_username, self::COOKIES);
	}

	/**
	 * (Non-cookiefile) Save all cookies for the currently active user.
	 *
	 * Note that this function is called frequently! But it is ONLY called if a
	 * non-string answer was returned by the getUserCookiesFilePath() call.
	 *
	 * If your Storage backend class uses a cookiefile, make this a no-op.
	 *
	 * @param string $rawData An encoded string with all cookie data.
	 *
	 * @throws \InstagramAPI\Exception\SettingsException
	 */
	public function saveUserCookies ($rawData)
	{
		$this->_setUserKey($this->_username, self::COOKIES, $rawData);
	}

	/**
	 * Close the settings storage for the currently active user.
	 *
	 * Is called every time we're switching away from a user, BEFORE the new
	 * user's loadUserSettings() call. Should be used for doing things like
	 * closing previous per-user file handles in the backend, and unsetting the
	 * cached user information that was set in the openUser() call.
	 *
	 * After this call, there will not be any other user-related calls until the
	 * next openUser() call.
	 *
	 * @throws \InstagramAPI\Exception\SettingsException
	 */
	public function closeUser ()
	{
		$this->_username = null;
	}

	/**
	 * Disconnect from a storage location and perform necessary shutdown steps.
	 *
	 * This function is called ONCE, when we no longer need to access the
	 * currently open storage. But we may still open another storage afterwards,
	 * so do NOT treat this as a "class destructor"!
	 *
	 * Implementing this is optional, but the function must exist.
	 *
	 * @throws \InstagramAPI\Exception\SettingsException
	 */
	public function closeLocation ()
	{
		//
	}

	/**
	 * Retrieve a redis key for a particular user.
	 *
	 * @param string $username The Instagram username.
	 * @param string $key      Name of the subkey.
	 *
	 * @throws \InstagramAPI\Exception\SettingsException
	 *
	 * @return string|null The value as a string IF the user's key exists,
	 *                     otherwise NULL.
	 */
	private function _getUserKey ($username, $key)
	{
		$realKey = $username . '_' . $key;
		return $this->cache->get($realKey);
	}

	/**
	 * Set a redis key for a particular user.
	 *
	 * @param string       $username The Instagram username.
	 * @param string       $key      Name of the subkey.
	 * @param string|mixed $value    The data to store. MUST be castable to string.
	 */
	private function _setUserKey (string $username, string $key, $value)
	{
		$realKey = $username . '_' . $key;
		$this->cache->put($realKey, (string) $value, self::CACHE_TIME);
	}

	/**
	 * Delete a memcached key for a particular user.
	 *
	 * @param string $username The Instagram username.
	 * @param string $key      Name of the subkey.
	 */
	private function _delUserKey ($username, $key)
	{
		$realKey = $username . '_' . $key;
		$result  = $this->cache->forget($realKey);

		if ( ! $result)
			throw new SettingsException('Redis Error: can not delete key - ' . $realKey);
	}
}