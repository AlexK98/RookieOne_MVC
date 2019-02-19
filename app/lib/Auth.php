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

class Auth
{
	private $acl;
	private $page;

	public function __construct(array $route)
	{
		if (debug) { echo '<b>'.__CLASS__.'</b> <span style="color: darkgreen">Constructor</span><br>'; }

		// web page we accessing
		$this->page = $route['action'];

		// load list of permissions
		$this->acl  = $this->load();
	}

	// Check permissions based on user's Role
	public function check(string $userRole = ROLE_GUEST) : bool
	{
		if (empty(trim($userRole))) {
			exit(__METHOD__.' [$role] should not be empty<br>');
		}

		if ($this->match($userRole)) {
			return true;
		}

		return false;
	}

	// Load Access Control List configuration file
	private function load(string $list = 'default')
	{
		if (empty(trim($list))) {
			exit(__METHOD__.' [$route] should not be empty<br>');
		}

		$file = 'app/acl/'.ucfirst($list).'ACL.php';

		if (!file_exists($file)) {
			return false;
		}

		return include $file;
	}

	// Run through the Access Control List to find
	// if user's Role allows to access page being visited
	private function match(string $userRole = ROLE_GUEST) : bool
	{
		if (empty(trim($userRole))) {
			exit(__METHOD__.' [$userRole] should not be empty<br>');
		}

		foreach ($this->acl as $role => $pages) {
			if ($role === $userRole) {
				foreach ($pages as $page => $permission) {
					if ($permission === 1 && $page === $this->page) {
						return true;
					}
				}
			}
		}
		return false;
	}
}