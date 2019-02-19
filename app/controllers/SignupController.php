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

class SignupController extends Controller
{
	private $valid = false;
	private $form  = false;

	public function signupAction()
	{
		if (debug) { echo '<b>'.__METHOD__.'</b><br>'; }

		// process SIGN UP form
		if (isset($_POST['submit']) && $_POST['submit'] === 'SignUp') {
			// validate form data
			$this->valid = $this->model->validateInput();

			//check if email is already there or not, and then add user to db
			if ($this->valid) {
				$this->form = $this->model->processForm();
			}

			// the rest of sign up process
			if ($this->form) {
				// start session
				$this->sess->start();

				// update session id in DB
				$this->model->setSessIdByEmail(User::$email, $this->sess->getSessId());

				// refresh user data from DB
				$this->model->getProfileByEmail(User::$email);

				// set basic variables of LOGGED user.
				$this->sess->setBasicVars();
				$this->setNameCookie();

				header('Location: /');
				exit();
			}
		}

		// render page
		$this->view->renderPage($this->model);
	}
}