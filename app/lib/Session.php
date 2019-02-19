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

namespace app\lib;

use app\config\User;

class Session
{
	public function __construct()
	{
		if (debug) { echo '<b>'.__CLASS__.'</b> <span style="color: darkgreen">Constructor</span><br>'; }

		// init session params
		$this->iniMaxLifeTime();
		$this->iniCookieLifeTime();
		$this->setName();
	}

	// start/destroy session
	public function start()
	{
		session_start();
	}
	public function destroy()
	{
		if (isset($_SESSION)) {
			session_unset();
			session_destroy();
		}
	}

	// set session name
	public function setName(string $name = RONEID)
	{
		if (isset($_SESSION)) {
			exit(__METHOD__.'. Set session name before starting session');
		}
		session_name($name);
	}

	// get active session ID
	public function getSessId() : string
	{
		if (!empty(session_id())) {
			return session_id();
		}
		exit(__METHOD__.' could not read Session ID. Start session first.');
	}

	// Used to get/set NAME of user logged in
	public function setRole(string $role = 'guest')
	{
		if (!isset($_SESSION['role'])) {
			$_SESSION['role'] = $role;
		}
	}
	public function getRole() : string
	{
		if (isset($_SESSION['role'])) {
			return $_SESSION['role'];
		}
		exit(__METHOD__.' [role] is not set. Set it first');
	}

	// Used to get/set ID of user logged in
	public function setUserId(int $id)
	{
		if($id < 0) {
			exit(__METHOD__.' [id] parameter must be unsigned integer');
		}

		if (!isset($_SESSION['userid'])) {
			$_SESSION['userid'] = $id;
		}
	}
	public function getUserId() : int
	{
		if (isset($_SESSION['userid'])) {
			return $_SESSION['userid'];
		}
		exit(__METHOD__.' [userid] is not set');
	}

	// Used to get/set NAME of user logged in
	public function setUserName(string $name = '')
	{
		if (!isset($_SESSION['name'])) {
			$_SESSION['name'] = User::getBasename();
			return;
		}

		if(empty(trim($name))) {
			$_SESSION['name'] = User::getBasename();
			return;
		}

		$_SESSION['name'] = $name;
	}
	public function getUserName() : string
	{
		if (isset($_SESSION['name']) && $_SESSION['name'] !== User::getBasename()) {
			return $_SESSION['name'];
		}
		return User::getBasename();
	}

	// Used to get/set user's LOGGED state in SESSION
	public function setLogged(bool $logged = false)
	{
		$_SESSION['logged'] = $logged;
	}
	public function getLogged() : bool
	{
		if (isset($_SESSION['logged'])) {
			return (bool)$_SESSION['logged'];
		}
		return false;
	}

	// making SESSION live defined LIFETIME period
	public function iniMaxLifeTime(int $lifetime = DEFAULT_LIFETIME)
	{
		if ($lifetime < 0) {
			exit (__METHOD__.' [$lifetime] should be positive number');
		}

		if (ini_get('session.gc_maxlifetime') < $lifetime) {
			ini_set('session.gc_maxlifetime', $lifetime);
		}
	}
	public function iniCookieLifeTime(int $lifetime = DEFAULT_LIFETIME)
	{
		if ($lifetime < 0) {
			exit (__METHOD__.' [$lifetime] should be positive number');
		}

		if (ini_get('session.cookie_lifetime') < $lifetime) {
			ini_set('session.cookie_lifetime', $lifetime);
		}
	}

	public function setBasicVars()
	{
		if (User::getUserId() === 0 || User::getRole() === 'guest') {
			exit(__METHOD__.'. Call getProfile* method prior to calling this method.');
		}

		$this->setUserId(User::getUserId());
		$this->setRole(User::getRole());
		$this->setUserName(User::$firstname.' '.User::$lastname);
		$this->setLogged(true);
	}
}