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

class Image
{
	// ================================================================
	// IMPORTANT: Variables get updated during:
	// - validation phase
	// - when read from database

	public static $dir      = 'public/images/';
	public static $name     = '_default.jpg';   //file2upload.name
	public static $temp     = '';               //file2upload.tmp_name
	public static $mime     = 'none';
	public static $msg      = '';
	public static $msgStyle = 'col_green';
	public static $msgStyleErr = 'col_coral';
	public static $isOk     = 0;
}