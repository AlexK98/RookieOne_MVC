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
use app\config\Image;
use app\core\View;
use app\models\ProfileModel;

class ProfileView extends View
{
	public function renderPage(ProfileModel $model)
	{
		if (User::getUserId() === 0) {
			exit (__METHOD__.' Please call getProfile* method first to fill User variables with values from DB');
		}

		$this->prepareVariables();

		$logged = $this->getLogged();

		// HEADER
		if ($logged) {
			if (User::getRole() === ROLE_SKYNET) {
				$this->addVar('btnManageDB', $this->btnAdmin());
			}
			$this->addVar('btnSignOut', $this->btnSignOut());
			$this->addVar('textUserName', $this->headerUserName($model->getFirstName(User::getUserId())));
		}
		$templates['header'] = $this->render('header', true);

		// BODY
		$this->addVar('userImage', Image::$dir.User::$image);
		$this->addVar('firstname', User::$firstname);
		$this->addVar('lastname',  User::$lastname);
		$this->addVar('about',     User::$about);
		$this->addVar('city',      User::$city);
		$this->addVar('country',   User::$country);
		$this->addVar('gender',    User::$gender);

		$this->addVar('phFirstStyle', User::$phFirstStyle);
		$this->addVar('phFirst', User::$phFirst);
		$this->addVar('phLastStyle', User::$phLastStyle);
		$this->addVar('phLast', User::$phLast);
		$this->addVar('phAbout', User::$phAbout);
		$this->addVar('phCity', User::$phCity);
		$this->addVar('phCountry', User::$phCountry);
		$this->addVar('phGender', User::$phGender);

		$this->addVar('msgImageStyle', Image::$msgStyle);
		$this->addVar('msgImage', Image::$msg);
		$this->addVar('msgDataStyle', User::$msgStyle);
		$this->addVar('msgData', User::$msg);

		$templates['main'] = $this->render('main');

		// FOOTER
		$this->addVar('width', 'width678'); // @data is given CSS style
		$templates['footer'] = $this->render('footer', true);
		$templates['title'] = 'Profile';

		// RENDER PAGE
		echo $this->renderLayout('default', $templates);
	}

	//
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

		if (Image::$isOk !== 1 && !empty(Image::$msg)) {
			Image::$msgStyle = Image::$msgStyleErr;
		}

		if (User::$isOk !== 1 && !empty(User::$msg)) {
			User::$msgStyle = User::$msgStyleErr;
		}
	}
}