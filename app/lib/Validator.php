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

use app\config\Image;
use app\config\User;

class Validator
{
	public function __construct()
	{
		if (debug) { echo '<b>'.__CLASS__.'</b> <span style="color: darkgreen">Constructor</span><br>'; }
	}

	public function isEmpty($data) : bool
	{
		if (!empty(trim($data))) {
			return false;
		}
		return true;
	}

	public function sanitize($data)
	{
		if (is_string($data)) {
			return filter_var(strip_tags($data), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW|FILTER_FLAG_NO_ENCODE_QUOTES);
		}

		if (is_int($data)) {
			return (int)filter_var($data, FILTER_SANITIZE_NUMBER_INT);
		}

		if (is_float($data)) {
			return (float)filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT);
		}
		return false;
	}

	public function firstName($required = true) : bool
	{
		if ($required && $this->isEmpty($_POST['firstname'])) {
			User::$firstnameErr = FIELD_REQUIRED;
			return false;
		}

		if ($_POST['firstname'] !== $this->sanitize($_POST['firstname'])) {
			User::$firstnameErr = FIELD_HACK_WARN;
			return false;
		}

		User::$firstname = $this->sanitize($_POST['firstname']);

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	public function lastName($required = true) : bool
	{
		if ($required && $this->isEmpty($_POST['lastname'])) {
			User::$lastnameErr = FIELD_REQUIRED;
			return false;
		}

		if ($_POST['lastname'] !== $this->sanitize($_POST['lastname'])) {
			User::$lastnameErr = FIELD_HACK_WARN;
			return false;
		}

		User::$lastname = $this->sanitize($_POST['lastname']);

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	public function email($required = true) : bool
	{
		if ($required && $this->isEmpty($_POST['email'])) {
			User::$emailErr = FIELD_REQUIRED;
			return false;
		}

		User::$email = filter_var(strtolower($_POST['email']), FILTER_SANITIZE_EMAIL);
		User::$email = filter_var(User::$email, FILTER_VALIDATE_EMAIL);

		if (User::$email === false) {
			User::$emailErr = 'Please enter valid email address.';
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	public function password($required = true) : bool
	{
		if ($required && $this->isEmpty($_POST['password'])) {
			User::$passErr = FIELD_REQUIRED;
			return false;
		}

		if ($_POST['password'] !== $this->sanitize($_POST['password'])) {
			User::$passErr = FIELD_HACK_WARN;
			return false;
		}

		User::$pass = $this->sanitize($_POST['password']);

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	public function about() : bool
	{
		if ($_POST['about'] !== $this->sanitize($_POST['about'])) {
			User::$aboutErr = FIELD_HACK_WARN;
			return false;
		}

		User::$about = $this->sanitize($_POST['about']);

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	public function city() : bool
	{
		if ($_POST['city'] !== $this->sanitize($_POST['city'])) {
			User::$cityErr = FIELD_HACK_WARN;
			return false;
		}

		User::$city = $this->sanitize($_POST['city']);

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	public function country() : bool
	{
		if ($_POST['country'] !== $this->sanitize($_POST['country'])) {
			User::$countryErr = FIELD_HACK_WARN;
			return false;
		}

		User::$country = $this->sanitize($_POST['country']);

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	public function gender() : bool
	{
		if ($_POST['gender'] !== $this->sanitize($_POST['gender'])) {
			User::$genderErr = FIELD_HACK_WARN;
			return false;
		}

		User::$gender = $this->sanitize($_POST['gender']);

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	public function fileName(string $data) : bool
	{
		if (!isset($data)) { return false; }

		$name = $this->sanitize(basename($data));

		if (basename($data) !== $name) {
			User::$msg = __METHOD__.' failed.';
			exit(__METHOD__.' failed<br>');
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	public function MIMEType() : bool
	{
		if (filesize(Image::$temp) < 60) {
			Image::$msg = 'Sorry, file is too small to be an image.';
			return false;
		}

		if (function_exists('exif_imagetype')) {
			Image::$mime = image_type_to_mime_type(exif_imagetype(Image::$temp));
		} else {
			$info = getimagesize(Image::$temp);
			Image::$mime = $info['mime'];
		}

		if (Image::$mime !== 'image/gif' && Image::$mime !== 'image/jpeg' && Image::$mime !== 'image/png') {
			Image::$msg = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	public function fileSize(string $file) : bool
	{
		$size = filesize($file);
		if ($size !== $this->sanitize($_FILES['file2Upload']['size'])) {
			Image::$msg = 'File size mismatch';
			return false;
		}

		if ($size > IMG_SIZE_LIMIT) {
			Image::$msg = 'Sorry, we do not allow images bigger than 2 MBytes.';
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}
}