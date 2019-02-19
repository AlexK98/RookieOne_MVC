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

namespace app\controllers;

use app\config\User;
use app\core\Controller;
use app\core\View;

class ProfileController extends Controller
{
	private $userData = false;

	public function profileAction()
	{
		if (debug) { echo '<b>'.__METHOD__.'</b><br>'; }

		$userId = $this->sess->getUserId();
		$logged = $this->sess->getLogged();

		// check if user is logged, refresh user data, and process POST requests
		if (isset($_COOKIE[RONEID]) && $_COOKIE[RONEID] === $this->sess->getSessId() && $logged) {
			// Update USER IMAGE
			if (isset($_POST['submit']) && $_POST['submit'] === 'UserImage') {
				$this->model->setUserImage($userId);
			}

			// Update USER DATA
			if (isset($_POST['submit']) && $_POST['submit'] === 'UserData') {
				$this->userData = $this->model->setUserData($userId);
			}

			// refresh user data
			$this->model->getProfileById($userId);

			// update UserName change
			if ($this->userData === true) {
				$this->setNameCookie();
				$this->sess->setUserName(User::$firstname.' '.User::$lastname);
			}

			// render page
			$this->view->setLogged($logged);
			$this->view->renderPage($this->model);
		} else {
			View::errorCode(403);
		}
	}
}