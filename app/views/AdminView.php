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

namespace app\views;

use app\config\DBase;
use app\config\User;
use app\core\View;
use app\models\AdminModel;

class AdminView extends View
{
	public function renderPage(AdminModel $model)
	{
		if (User::getUserId() === 0) {
			exit (__METHOD__.' Please call getProfile* method first to fill User variables with values from DB');
		}

		$logged = $this->getLogged();

		// HEADER
		if ($logged) {
			$this->addVar('btnProfile', $this->btnProfile());
			$this->addVar('btnSignOut', $this->btnSignOut());
			$this->addVar('textUserName', $this->headerUserName($model->getFirstName(User::getUserId())));
		} else {
			$this->addVar('btnSignIn', $this->btnSignIn());
			$this->addVar('btnSignUp', $this->btnSignUp());
		}
		$templates['header'] = $this->render('header', true);

		// BODY
		if ($logged) {
			$this->addVar('message', DBase::$msg);
			$templates['main'] = $this->render('main');
		}

		// FOOTER
		$this->addVar('width', 'width456'); // @data is given CSS style
		$templates['footer'] = $this->render('footer', true);
		$templates['title'] = 'Admin';

		// RENDER PAGE
		echo $this->renderLayout('default', $templates);
	}
}