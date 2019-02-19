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

namespace app\core;

use app\config\User;
use app\lib\Auth;
use app\lib\Session;

abstract class Controller
{
	protected $route;
	protected $view;
	protected $model;

	public    $auth;
	public    $sess;

	public function __construct(array $route)
	{
		if (debug) { echo '<b>'.__CLASS__.'</b> <span style="color: darkgreen">Constructor</span><br>'; }

		if(count($route) < 2) {
			exit(__METHOD__.' [$route] should at least have fields corresponding to [controller] and [action].');
		}

		$this->sess = new Session();

		// Check if user is logged in
		if (isset($_COOKIE[RONEID])) {
			// Resume/start session
			$this->sess->start();

			// Update user's ROLE
			if ($this->sess->getLogged() && $_COOKIE[RONEID] === $this->sess->getSessId()) {
				User::setRole($this->sess->getRole());
			}
		}

		// Check permissions to access pages based on User's Role
		// and create instances of corresponding Model and View classes
		$this->auth = new Auth($route);
		if ($this->auth->check(User::getRole())) {
			$this->model = $this->loadModel($route);
			$this->view  = $this->loadView($route);
		} else {
			View::errorCode(403);
		}
	}

	// Dynamically load MODEL by its NAME
	protected function loadModel(array $route)
	{
		if (debug) { echo '<b>'.__METHOD__.'</b><br>'; }

		$name = $route['controller'];

		if (empty(trim($name))) {
			exit(__METHOD__.' [$name] should not be empty<br>');
		}

		$model = 'app\\models\\'.ucfirst($name).'Model';
		if (!class_exists($model)) {
			exit(__METHOD__.' failed. '.$model.' not found.');
		}
		return new $model;
	}

	// Dynamically load VIEW by its NAME
	protected function loadView(array $route)
	{
		if (debug) { echo '<b>'.__METHOD__.'</b><br>'; }

		$name = $route['controller'];

		if (empty(trim($name))) {
			exit(__METHOD__.' [$name] should not be empty<br>');
		}

		$view = 'app\\views\\'.ucfirst($name).'View';
		if (!class_exists($view)) {
			exit(__METHOD__.' failed. '.$view.' not found.');
		}
		return new $view($route);
	}

	//========================================================
	// TODO: move method out of CONTROLLER class?
	public function setNameCookie()
	{
		setcookie('name', User::$firstname.' '.User::$lastname, time() + DEFAULT_LIFETIME);

		if (debug) { echo __METHOD__.' passed<br>'; }
	}
}