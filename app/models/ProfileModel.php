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

namespace app\models;

use app\config\Image;
use app\config\User;
use app\core\Model;

class ProfileModel extends Model
{
	// update User Image
	public function setUserImage(int $userid) : bool
	{
		// Checking 'save' button was pressed but no new image was provided for upload
		if (empty($_FILES['file2Upload']['name'])) {
			Image::$msg = 'Profile image stays the same.';
			Image::$isOk = 1; // so that message is displayed in green
			return false;
		}

		// Validating and sanitizing input. This also updates USERVAR class variables
		if (!$this->validateImage()) {
			return false;
		}

		// move from temp to designated folder
		if (!$this->moveImage()) {
			Image::$msg = 'Sorry, there was an error saving your image.';
			return false;
		}

		// update DB
		if (!$this->updateImage($userid, Image::$name)) {
			Image::$msg = 'Sorry, image update failed!';
			return false;
		}

		Image::$msg = 'Image update successful!';
		Image::$isOk = 1; // so that message is displayed in green

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	// update textual user information
	public function setUserData(int $userid) : bool
	{
		// Validating and sanitizing input. This also updates USERVAR class variables
		if (!$this->validateData()) {
			User::$msg = 'Sorry, input validation failed.';
			return false;
		}
		// update DB
		$userData = [
			'firstname' => User::$firstname,
			'lastname' => User::$lastname,
			'about' => User::$about,
			'city' => User::$city,
			'country' => User::$country,
			'gender' => User::$gender,
		];
		if (!$this->updateData($userid, $userData)) {
			User::$msg = 'Sorry, profile update failed!';
			return false;
		}

		User::$msg = 'Profile updated successfully!';
		User::$isOk = 1; // so that message is displayed in green

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	// validating user supplied image
	private function validateImage() : bool
	{
		//check filename of file being uploaded
		if (!$this->validate->fileName($_FILES['file2Upload']['name'])) {
			Image::$msg = 'Filename is strange.';
			return false;
		}
		Image::$name = $_FILES['file2Upload']['name'];

		//check filename of temp file
		if (!$this->validate->fileName($_FILES['file2Upload']['tmp_name'])) {
			Image::$msg = 'Temporary filename is strange.';
			return false;
		}
		Image::$temp = $_FILES['file2Upload']['tmp_name'];

		//Check TEMP IMAGE file for proper MIME type
		if (!$this->validate->MIMEType()) {
			return false;
		}

		//Check IMAGE size
		if (!$this->validate->fileSize(Image::$temp)) {
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	// validating user supplied text
	private function validateData() : bool
	{
		$fn = $this->validate->firstName();
		$ln = $this->validate->lastName();
		$ab = $this->validate->about();
		$ci = $this->validate->city();
		$co = $this->validate->country();
		$ge = $this->validate->gender();

		if (!$fn || !$ln || !$ab || !$ci || !$co || !$ge) {
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}
}