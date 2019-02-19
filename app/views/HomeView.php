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
use app\models\HomeModel;

class HomeView extends View
{
	public function renderPage(HomeModel $model)
	{
		$logged = $this->getLogged();

		// HEADER
		if ($logged) {
			if(User::getRole() === ROLE_SKYNET) {
				$this->addVar('btnManageDB', $this->btnAdmin());
			}
			$this->addVar('btnProfile', $this->btnProfile());
			$this->addVar('btnSignOut', $this->btnSignOut());
			$this->addVar('textUserName', $this->headerUserName($model->getFirstName(User::getUserId())));
		} else {
			$this->addVar('btnSignIn', $this->btnSignIn());
			$this->addVar('btnSignUp', $this->btnSignUp());
		}
		$templates['header'] = $this->render('header', true);

		// BODY
		$this->addVar('welcome', $this->textWelcome($logged));
		$this->addVar('feature', $this->textFeature($logged));
		$this->addVar('slogan', $this->textSlogan($logged));
		$templates['main'] = $this->render('main');

		// FOOTER
		$this->addVar('width', 'width678'); // @data is given CSS style
		$templates['footer'] = $this->render('footer', true);
		$templates['title'] = 'Home';

		// RENDER PAGE
		echo $this->renderLayout('default', $templates);
	}

	// HOME PAGE ELEMENTS
	// (it does not belong here, but I have not decide where to move it)
	// ==================================================================================
	private function textWelcome(bool $logged = false) : string
	{
		if($logged && User::getRole() === ROLE_SKYNET) {
			return '<div>At last, '.htmlspecialchars($_COOKIE['name']).'!</div>';
		}
		if($logged && User::getRole() === ROLE_ROOKIE) {
			return '<h2 class="block mt20">Welcome home, '.htmlspecialchars($_COOKIE['name']).'!</h2>';
		}
		return '<h2 class="block mt20">Welcome, '.User::getBasename().'!</h2>';
	}

	private function textFeature(bool $logged = false) : string
	{
		if($logged && User::getRole() === ROLE_SKYNET) {
			return '<div>Greetings to myself, as usual :)</div>';
		}
		if($logged && User::getRole() === ROLE_ROOKIE) {
			return '<div>It is good to see you with us.</div>
              <div>New wanders are waiting for you. And remember:</div>
							<p>&#x2193 &#x2193 &#x2193 &#x2193 &#x2193 &#x2193 &#x2193 &#x2193</p>';
		}
		return '<div>SkyNet is waiting for you.</div>
            <div>Enroll now to start enjoying the wonderful moments.</div>';
	}

	private function textSlogan(bool $logged = false) : string
	{
		if($logged && User::getRole() === ROLE_SKYNET) {
			return '<div>I Build The Future</div>';
		}
		return '<div>We Build The Future.</div>';
	}
}