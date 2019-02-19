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

namespace app\lib;

use app\core\View;

class Router
{
	private $routes = array();
	private $params = array();
	public  $controller;

	public function __construct()
	{
		if (debug) { echo '<b>'.__CLASS__.'</b> <span style="color: darkgreen">Constructor</span><br>'; }

		$routes = require 'app/config/_routes.php';

		foreach ($routes as $route => $params) {
			$this->add($route, $params);
		}
	}

	// prepare route for PREG_MATCH
	public function add($route, $params)
	{
		$rt = '#^'.$route.'$#';
		$this->routes[$rt] = $params;
	}

	// check if uri matches one of predefined routes
	public function match() : bool
	{
		$url = trim($_SERVER['REQUEST_URI'], '/');

		foreach ($this->routes as $route => $params) {
			if (preg_match($route, $url, $matches)) {
				$this->params = $params;
				return true;
			}
		}
		return false;
	}

	// Run application
	public function run()
	{
		if (debug) { echo 'I\'m method - <b>' . __METHOD__.'</b><br>'; }

		// check if route is defined
		if (!$this->match()) {
			View::errorCode(404);
		}

		// check for availability of corresponding Controlled
		$class = 'app\\controllers\\'.ucfirst($this->params['controller']).'Controller';
		if (!class_exists($class)) {
			View::errorCode(404);
		}

		// check for availability of corresponding Action in Controlled
		$action = $this->params['action'].'Action';
		if (!method_exists($class, $action)) {
			View::errorCode(404);
		}

		// instantiate class and call its Action method
		$this->controller = new $class($this->params);
		$this->controller->$action();
	}
}