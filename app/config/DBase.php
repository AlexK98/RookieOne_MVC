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

namespace app\config;

class DBase
{
	public static $host = 'localhost';
	public static $user = 'root';
	public static $pass = 'mysql';

	public static $dbase = 'rookie';
	public static $table = 'users';
	public static $index = 'email';

	public static $charset = 'utf8mb4';
	public static $collate = 'utf8mb4_unicode_ci';

	public static $msg = '';
}