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

use app\config\User;
use app\core\Model;

class SignoutModel extends Model
{
	// sign out of the system
	public function signOut() : bool
	{
		if (User::getUserId() === 0 || User::getRole() === ROLE_GUEST) {
			exit (__METHOD__.' Please call getProfile* method first to fill User variables with values from DB');
		}

		if (!$this->setSessIdById(User::getUserId(), 'none')) {
			User::$msg = 'SignOut failed.';
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}
}