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

namespace app\config;

class User
{
	// ================================================================
	// IMPORTANT: Variables get updated during:
	// - validation phase
	// - when read from database

	private static $userid   = 0; // '0' means that either User is not logged in or valid data has not been fetched from database
	private static $role     = 'guest';
	private static $sessid   = 'none'; // string, php session id when user is logged in
	private static $activity = 0; // time of last user activity, updated on every page visit if user is logged in
	private static $basename = 'Rookie';

	public static $firstname = '';
	public static $lastname  = '';
	public static $email     = '';
	public static $pass      = '';
	public static $about     = '';
	public static $city      = '';
	public static $country   = '';
	public static $gender    = '';
	public static $image     = '_default.jpg';

	public static $firstnameErr = '';
	public static $lastnameErr  = '';
	public static $emailErr     = '';
	public static $passErr      = '';
	public static $aboutErr     = '';
	public static $cityErr      = '';
	public static $countryErr   = '';
	public static $genderErr    = '';

	public static $phFirst   = 'E.g. Sarah';
	public static $phLast    = 'E.g. Connor';
	public static $phEmail   = 'E.g. sarah@connor.name';
	public static $phPass    = 'Some password only you will know';
	public static $phCity    = 'E.g. Los Angeles';
	public static $phCountry = 'E.g. USA';
	public static $phAbout   = 'E.g. I\'m a fictional character in the Terminator franchise and one of the main protagonists of The Terminator, Terminator 2: Judgment Day and Terminator Genisys.';
	public static $phGender  = 'E.g. Male, Female, AI or other';

	public static $phFirstStyle = '';
	public static $phLastStyle  = '';
	public static $phEmailStyle = '';
	public static $phPassStyle  = '';

	public static $phErrStyle = 'alertPH';	// value taken from ROOKIE.CSS

	public static $msg = '';
	public static $msgStyle    = 'col_green';
	public static $msgStyleErr = 'col_coral';

	public static $isOk = 0;

	//======================================================================

	public static function getSessID(): string
	{
		return self::$sessid;
	}
	public static function setSessID(string $id)
	{
		self::$sessid = $id;
	}

	public static function getUserId() : int
	{
		return self::$userid;
	}
	public static function setUserId(int $id = 0)
	{
		self::$userid = $id;
	}

	public static function getRole() : string
	{
		return self::$role;
	}
	public static function setRole(string $role = 'default')
	{
		self::$role = $role;
	}

	public static function getActivity() : int
	{
		return self::$activity;
	}
	public static function setActivity(int $activity = 0)
	{
		self::$activity = $activity;
	}

	public static function getBasename(): string
	{
		return self::$basename;
	}
}
