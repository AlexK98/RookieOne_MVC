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

// DEFAULT - ACCESS CONTROL LIST

return [
	'guest' => [
		'home'    => 1,
		'admin'   => 0,
		'profile' => 0,
		'signin'  => 1,
		'signout' => 0,
		'signup'  => 1,
	],

	'rookie' => [
		'home'    => 1,
		'admin'   => 0,
		'profile' => 1,
		'signin'  => 0,
		'signout' => 1,
		'signup'  => 0,
	],

	'skynet' => [
		'home'    => 1,
		'admin'   => 1,
		'profile' => 1,
		'signin'  => 1,
		'signout' => 1,
		'signup'  => 1,
	],
];