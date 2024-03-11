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

abstract class View
{
	private $basePath;
	private $vars = array(); // array gets cleaned/reset on every RENDER call
	private $logged = false;

	public function __construct(array $route)
	{
		if (debug) { echo '<b>'.__CLASS__.'</b> <span style="color: darkgreen">Constructor</span><br>'; }

		if(count($route) < 2) {
			exit(__METHOD__.' [$route] should at least have fields corresponding to [controller] and [action].');
		}

		$this->basePath = 'app/templates/'.$route['controller'].'/'.$route['action'];
	}

	// Drawing error page based on http error code
	public static function errorCode(int $code)
	{
		http_response_code($code);
		$path = 'app/templates/errors/'.$code.'.tpl.php';

		if (file_exists($path)) {
			include $path;
		} else {
			exit(__METHOD__.' Please define corresponding page for the error code issued');
		}
		exit();
	}

	// TEMPLATE PROCESSING
	// ==================================================================================
	// Adds variable and its contents to show on the page
	// @data - should be STRING or ARRAY
	public function addVar(string $name, $data)
	{
		$this->vars[$name] = $data;

		if (debug) { echo __METHOD__.' passed<br>'; }
	}

	// Render chosen $template. Set to render default one with $useDefault
	public function render(string $template, bool $useDefault = false)
	{
		ob_start();
		$file = $this->basePath.'_'.$template.'.tpl.php';

		if ($useDefault) {
			$file = 'app/templates/default/default_'.$template.'.tpl.php';
		}

		if (file_exists($file)) {
			extract($this->vars, EXTR_SKIP);
			include $file;
		}
		$result = ob_get_clean();

		// resetting output array
		reset($this->vars);

		if (debug) { echo __METHOD__.' passed<br>'; }
		return $result;
	}

	// Render layout with $vars being Templates
	public function renderLayout(string $layout, array $vars)
	{
		if (empty(trim($layout))) {
			$layout = 'default';
		}

		ob_start();
		extract($vars, EXTR_SKIP);

		$file = 'app/templates/_layouts/'.$layout.'.php';

		if (file_exists($file)) {
			include $file;
		} else {
			self::errorCode(404);
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return ob_get_clean();
	}

	public function setLogged(bool $logged)
	{
		$this->logged = $logged;
	}
	public function getLogged() : bool
	{
		return $this->logged;
	}

	// COMMON HEADER ELEMENTS
	// (i know, it does not belong here, but I have not decided where to move it)
	// ==================================================================================
	protected function btnAdmin() : string
	{
		return '<a href="/admin" class="btn fs18 btn2 float_L off_L" title="Dummy Admin page">Admin</a>';
	}
	protected function btnSignIn() : string
	{
		return '<a href="/signin" class="btn fs18 btn2 float_R off_R" title="Sign in to access your wanders.">Sign In</a>';
	}
	protected function btnSignUp() : string
	{
		return '<a href="/signup" class="btn fs18 btn2 float_R off_R" title="Sign up and wander with us all over our world.">Sign Up</a>';
	}
	protected function btnSignOut() : string
	{
		return '<a href="/signout" class="btn fs18 btn2 float_R off_R" title="Leaving so soon?">Sign Out</a>';
	}
	protected function btnProfile() : string
	{
		return '<a href="/profile" class="btn fs18 btn2 float_R off_R" title="Back to your wanders">Profile</a>';
	}
	protected function headerUserName($name) : string
	{
		return '<div class="username fs18 pt10 float_R">Hello, '. $name.'</div>';
	}
}