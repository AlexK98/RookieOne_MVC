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

use app\core\Controller;
use app\core\View;

class AdminController extends Controller
{
	public function adminAction()
	{
		if (debug) { echo '<b>'.__METHOD__.'</b><br>'; }

		$logged = $this->sess->getLogged();

		// check if user is logged, refresh user data, and process POST requests
		if (isset($_COOKIE[RONEID]) && $_COOKIE[RONEID] === $this->sess->getSessId() && $logged) {
			// refresh user data
			$this->model->getProfileById($this->sess->getUserId());

			// process POST requests
			if (isset($_POST['submit']) && $_POST['submit'] === 'createDB') {
				$this->model->initDB();
			}
			if (isset($_POST['submit']) && $_POST['submit'] === 'dropDB') {
				$this->model->dropDB();
			}

			// render page
			$this->view->setLogged($logged);
			$this->view->renderPage($this->model);
		} else {
			View::errorCode(403);
		}
	}
}