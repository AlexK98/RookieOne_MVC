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

use app\config\User;
use app\core\View;
use app\models\SignupModel;

class SignupView extends View
{
	public function renderPage(SignupModel $model)
	{
		$this->prepareVariables();

		// HEADER
		$this->addVar('btnSignIn', $this->btnSignIn());
		$templates['header'] = $this->render('header', true);

		// BODY
		$this->addVar('firstname', User::$firstname);
		$this->addVar('lastname', User::$lastname);
		$this->addVar('email', User::$email);

		$this->addVar('phFirstStyle', User::$phFirstStyle);
		$this->addVar('phFirst', User::$phFirst);
		$this->addVar('phLastStyle', User::$phLastStyle);
		$this->addVar('phLast', User::$phLast);
		$this->addVar('phEmailStyle', User::$phEmailStyle);
		$this->addVar('phEmail', User::$phEmail);
		$this->addVar('phPassStyle', User::$phPassStyle);
		$this->addVar('phPass', User::$phPass);
		$templates['main'] = $this->render('main');

		// FOOTER
		$this->addVar('width', 'width456'); // @data is given CSS style
		$templates['footer'] = $this->render('footer', true);
		$templates['title'] = 'Sign Up';

		// RENDER PAGE
		echo $this->renderLayout('default', $templates);
	}

	private function prepareVariables()
	{
		if (!empty(User::$firstnameErr)) {
			User::$phFirstStyle = User::$phErrStyle;
			User::$phFirst = User::$firstnameErr;
			User::$firstname = '';
		}
		if (!empty(User::$lastnameErr)) {
			User::$phLastStyle = User::$phErrStyle;
			User::$phLast = User::$lastnameErr;
			User::$lastname = '';
		}
		if (!empty(User::$emailErr)) {
			User::$phEmailStyle = User::$phErrStyle;
			User::$phEmail = User::$emailErr;
			User::$email = '';
		}
		if (!empty(User::$passErr)) {
			User::$phPassStyle = User::$phErrStyle;
			User::$phPass = User::$passErr;
		}
	}
}