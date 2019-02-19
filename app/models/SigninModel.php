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

use app\config\DBase;
use app\config\User;
use app\core\Model;

class SigninModel extends Model
{
	// process validated form data
	public function processForm() : bool
	{
		if (!$this->isEmailInDb(User::$email)) {
			User::$emailErr = 'Email is not registered. Please, sign up first.';
			return false;
		}
		if (!$this->doPasswordsMatch(User::$email, User::$pass)) {
			User::$passErr = 'You entered wrong password';
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	// validate input
	public function validateInput() : bool
	{
		$em = $this->validate->email();
		$pw = $this->validate->password();

		if (!$em || !$pw) {
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}
}