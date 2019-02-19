<?php
/*
* Author: Alex Kot
* Date: 2019/01/20
* EMail: kot.oleksandr.v@gmail.com
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details:
* http://www.gnu.org/licenses/gpl.html
*/

namespace app\core;

use app\config\DBase;
use app\config\Image;
use app\config\User;
use app\lib\Database;
use app\lib\Validator;

abstract class Model
{
	protected $db;
	protected $validate;

	protected $base;

	public function __construct()
	{
		if (debug) { echo '<b>'.__CLASS__.'</b> <span style="color: darkgreen">Constructor</span><br>'; }

		$this->base = DBase::$dbase.'.'.DBase::$table;
		$this->db   = new Database();
		$this->validate = new Validator();
	}

	// Get UserName based on different LOGGED conditions for use in VIEWs.
	public function getUserName() : string
	{
		if (isset($_COOKIE['name']) && !empty(trim($_COOKIE['name']))) {
			return htmlspecialchars($_COOKIE['name']);
		}

		if (!empty(User::$firstname) && !empty(User::$lastname)) {
			return trim(User::$firstname.rtrim(' '.User::$lastname));
		}

		return User::getBasename();
	}

	// Get user's FIRSTNAME by USERID.
	public function getFirstName(int $id) : string
	{
		$sql = 'SELECT firstname FROM '.$this->base.' WHERE id = :id';
		$params = [ 'id' => $id ];

		$firstname = $this->db->getColumn($sql, $params);

		if ($firstname === false) {
			return __METHOD__.' Error';
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return $firstname;
	}

	// Get USERID by EMAIL.
	public function getUserId(string $email) : string
	{
		if (empty($email)) {
			exit(__METHOD__.' [$email] should not be empty<br>');
		}

		$sql = 'SELECT id FROM '.$this->base.' WHERE email = :em';
		$params = [ 'em' => $email ];

		$userid = $this->db->getColumn($sql, $params);

		if ($userid === false) {
			return __METHOD__.' Error';
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return $userid;
	}

	// Get last ACTIVITY of the user.
	public function getActivityById(int $id) : int
	{
		$sql = 'SELECT activity FROM '.$this->base.' WHERE id = :id';
		$params = [ 'id' => $id ];

		$activity = $this->db->getColumn($sql, $params);

		if ($activity === false) {
			return __METHOD__.' Error';
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return $activity;
	}
	public function getActivityByEmail(string $email) : int
	{
		if (empty(trim($email))) {
			exit(__METHOD__.' [$email] should not be empty<br>');
		}

		$sql = 'SELECT activity FROM '.$this->base.' WHERE email = :em';
		$params = [ 'em' => $email ];

		$activity = $this->db->getColumn($sql, $params);

		if ($activity === false) {
			return __METHOD__.' Error';
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return $activity;
	}

	// Get all the user data from DB
	public function getProfileById(int $id) : bool
	{
		$sql = 'SELECT * FROM '.$this->base.' WHERE id = :id';
		$params = ['id' => $id];

		$result = $this->db->getRow($sql, $params);

		if (count($result) === 0) {
			DBase::$msg = __METHOD__.' nothing read from database';
			return false;
		}
		$this->fillUserVars($result[0]);

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}
	public function getProfileByEmail(string $email) : bool
	{
		if (empty(trim($email))) {
			exit(__METHOD__.' [$email] should not be empty<br>');
		}

		$sql = 'SELECT * FROM '.$this->base.' WHERE email=:em';
		$params = ['em' => $email];

		$result = $this->db->getRow($sql, $params);

		if (count($result) === 0) {
			DBase::$msg = __METHOD__.' nothing read from database';
			return false;
		}
		$this->fillUserVars($result[0]);

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	// Get SessID field from DB.
	public function getSessIdById(int $id) : string
	{
		$sql = 'SELECT sessid FROM '.$this->base.' WHERE id = :id';
		$params = [ 'id' => $id ];

		$sessid = $this->db->getColumn($sql, $params);

		if ($sessid === false) {
			return __METHOD__.' Error';
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return $sessid;
	}
	public function getSessIdByEmail(string $email) : string
	{
		if (empty(trim($email))) {
			exit(__METHOD__.' [$email] should not be empty<br>');
		}

		$sql = 'SELECT sessid FROM '.$this->base.' WHERE email = :em';
		$params = [ 'em' => $email ];

		$sessid = $this->db->getColumn($sql, $params);

		if ($sessid === false) {
			return __METHOD__.' Error';
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return $sessid;
	}

	// Set SessID field in DB.
	public function setSessIdById(int $id, string $sessid) : bool
	{
		if (empty(trim($sessid))) {
			exit( __METHOD__.' [$sessid] should not be empty<br>');
		}

		$sql = 'UPDATE '.$this->base.' SET sessid = :se WHERE id = :id';
		$params = [
			'se' => $sessid,
			'id' => $id
		];

		$stmt = $this->db->queryDb($sql, $params);
		if (!$stmt) {
			DBase::$msg = 'Failed to update SessID';
			return false;
		}

		DBase::$msg = 'SessID update successful!';

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}
	public function setSessIdByEmail(string $email, string $sessid) : bool
	{
		if (empty(trim($email))) {
			exit(__METHOD__.' [$email] should not be empty<br>');
		}

		if (empty(trim($sessid))) {
			exit( __METHOD__.' [$sessid] should not be empty<br>');
		}

		$sql = 'UPDATE '.$this->base.' SET sessid = :se WHERE email = :em';
		$params = [
			'se' => $sessid,
			'em' => $email
		];

		$stmt = $this->db->queryDb($sql, $params);
		if (!$stmt) {
			DBase::$msg = 'Failed to update SessID';
			return false;
		}

		DBase::$msg = 'SessID update successful!';

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	//========================================================

	// Update user image in DB. Validate input first
	protected function updateImage(int $id, string $image) : bool
	{
		if ($id === 0) {
			exit(__METHOD__.' [$id] should not be ZERO<br>');
		}

		if (empty(trim($image))) {
			exit(__METHOD__.' [$image] should not be empty<br>');
		}

		$sql = 'UPDATE '.$this->base.' SET userimage = :im WHERE id = :id';
		$params = [
			'id' => $id,
			'im' => $image
		];

		$stmt = $this->db->queryDb($sql, $params);
		if (!$stmt) {
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	// Update user data in DB. Validate input first
	protected function updateData(int $id, array $array) : bool
	{
		if ($id === 0) {
			exit(__METHOD__.' [$id] should not be ZERO<br>');
		}
		if (count($array) < 6) {
			exit(__METHOD__.' [$array] should have 6 parameters in it<br>');
		}

		$sql = 'UPDATE '.$this->base.' SET firstname = :fn, lastname = :ln, about = :ab, city = :ci, country = :co, gender = :ge WHERE id = :id';
		$params = [
			'fn' => $array['firstname'],
			'ln' => $array['lastname'],
			'ab' => $array['about'],
			'ci' => $array['city'],
			'co' => $array['country'],
			'ge' => $array['gender'],
			'id' => $id
		];

		$stmt = $this->db->queryDb($sql, $params);
		if (!$stmt) { return false; }

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	//========================================================

	// Check if email is registered. Validate input first
	protected function isEmailInDb(string $email) : bool
	{
		if (empty(trim($email))) {
			exit(__METHOD__.' [$email] should not be empty<br>');
		}

		$sql = 'SELECT email FROM '.$this->base.' WHERE email = :em';
		$params = [ 'em' => $email ];

		$result = $this->db->getRow($sql, $params);

		if (count($result) === 0) {
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	// Check if passwords match. Validate input first
	protected function doPasswordsMatch(string $email, string $pass) : bool
	{
		if (empty(trim($email))) { exit(__METHOD__.' [$email] should not be empty<br>'); }
		if (empty(trim($pass)))  { exit(__METHOD__.' [$pass] should not be empty<br>'); }

		$sql = 'SELECT pass FROM '.$this->base.' WHERE email = :em';
		$params = [ 'em' => $email ];

		$passInDb = $this->db->getColumn($sql, $params);

		if (!password_verify($pass, $passInDb)) {
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	// Add user to database. Validate input first
	protected function addUserToDb(string $email, string $first, string $last, string $pass) : bool
	{
		if (empty(trim($email))) { exit(__METHOD__.' [$email] should not be empty<br>'); }
		if (empty(trim($first))) { exit(__METHOD__.' [$first] should not be empty<br>'); }
		if (empty(trim($last)))  { exit(__METHOD__.' [$last] should not be empty<br>'); }
		if (empty(trim($pass)))  { exit(__METHOD__.' [$pass] should not be empty<br>'); }

		$hashedPass = password_hash($pass, PASSWORD_DEFAULT);
		$sql = 'INSERT INTO '.$this->base.'(firstname, lastname, email, pass) VALUES (:fn, :ln, :em, :pw)';
		$params = [
			'fn' => $first,
			'ln' => $last,
			'em' => $email,
			'pw' => $hashedPass
		];

		$stmt = $this->db->queryDb($sql, $params);
		if (!$stmt) {
			User::$msg = 'Sorry, we failed to add you to the Database. Sign up failed!';
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	// Helper method for getProfile* methods
	private function fillUserVars(array $array)
	{
		if (count($array) < 12) {
			exit(__METHOD__.' [$array] should have 12 parameters in it<br>');
		}

		User::setUserId($array['id']);
		User::setRole($array['role']);
		User::setSessID($array['sessid']);
		User::setActivity($array['activity']);
		User::$firstname = $array['firstname'];
		User::$lastname  = $array['lastname'];
		User::$email     = $array['email'];
		User::$about     = $array['about'];
		User::$city      = $array['city'];
		User::$country   = $array['country'];
		User::$gender    = $array['gender'];
		User::$image     = $array['userimage'];
	}

	// Helper: Copy uploaded image to proper folder. Validate input first
	protected function moveImage() : bool
	{
		if (!move_uploaded_file(Image::$temp, Image::$dir . Image::$name)) {
			Image::$msg = 'Could not move uploaded file to destination folder';
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

}