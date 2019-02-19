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

use app\config\DBase;
use PDO;
use PDOException;

class Database
{
	private $pdo;
	private $stmt;

	public function __construct()
	{
		if (debug) { echo '<b>'.__CLASS__.'</b> <span style="color: darkgreen">Constructor</span><br>'; }

		// create connection
		try {
			$this->pdo = new PDO('mysql:host='.DBase::$host.';dbname='.DBase::$dbase, DBase::$user, DBase::$pass);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			// CREATION OF DATABASE AND FILLING IT WITH THINGS IS HERE SOLELY FOR DEBUG/DEV PURPOSES
			// =====================================================================================
			// if no database is present (1049) on host we create it, its table and so on
			if ($e->getCode() === 1049) {
				try {
					$this->pdo = new PDO('mysql:host='.DBase::$host, DBase::$user, DBase::$pass);
				} catch (PDOException $q) {
					DBase::$msg = 'Error: ' . $q->getMessage();
					exit(DBase::$msg);
				}

				// create database and all related stuff
				$this->createDatabase(DBase::$dbase, DBase::$charset, DBase::$collate);
				$this->useDatabase(DBase::$dbase);
				$this->createTable(DBase::$table);
				$this->createTableIndex(DBase::$table, DBase::$index);
				$this->addAdminUser(DBase::$table);

				DBase::$msg = 'Site is running fresh, so we created Database with Tables and Admin user';
			} else {
				DBase::$msg = 'Error: ' . $e->getMessage();
			}
		}
	}
	public function __destruct()
	{
		if (debug) { echo '<b>'.__CLASS__.'</b> <span style="color: red">Destructor</span><br>'; }

		$this->stmt = null;
		$this->pdo  = null;
	}

	// Database query
	public function queryDb($sql, $params = [])
	{
		if (debug) { echo '<b>'.__METHOD__.'</b><br>'; }

		try {
			$this->stmt = $this->pdo->prepare($sql);
		} catch (PDOException $e) {
			DBase::$msg = 'Error: ' . $e->getMessage();
			return false;
		}

		if (!empty($params)) {
			foreach ($params as $key => $value) {
				if (is_int($value)) {
					$type = PDO::PARAM_INT;
				} elseif (is_string($value)) {
					$type = PDO::PARAM_STR;
				} else {
					DBase::$msg = __METHOD__.': Wrong type of param - '.$value.' in '.$key.'<br>';
					return false;
				}

				if (!$this->stmt->bindValue(':'.$key, $value, $type)) {
					exit('could not bind ['.$value.'] to [:'.$key.']' );
				}
			}
		}

		try {
			$this->stmt->execute();
		} catch (PDOException $e) {
			DBase::$msg = 'Error: ' . $e->getMessage();
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return $this->stmt;
	}

	// Query database and return ROW(s) from it
	public function getRow($sql, $params) : array
	{
		if (debug) { echo '<b>'.__METHOD__.'</b><br>'; }

		$this->stmt = $this->queryDb($sql, $params);
		if (!$this->stmt) {exit(__METHOD__.' failed');}

		$array = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

		if (debug) { echo __METHOD__.' passed<br>'; }
		return $array;
	}

	// Query database and return SINGLE value
	public function getColumn($sql, $params)
	{
		if (debug) { echo '<b>'.__METHOD__.'</b><br>'; }

		$this->stmt = $this->queryDb($sql, $params);
		if (!$this->stmt) {exit(__METHOD__.' failed');}

		$value = $this->stmt->fetchColumn();

		if (debug) { echo __METHOD__.' passed<br>'; }
		return $value;
	}


	// HELPER/DEBUG/DEVELOPMENT ONLY METHODS
	// ===============================================================
	private function createDatabase($dbase, $cset, $coll)
	{
		$sql = "CREATE DATABASE IF NOT EXISTS $dbase CHARACTER SET $cset COLLATE $coll";
		$this->stmt = $this->pdo->prepare($sql);

		$result = $this->pdo->exec($this->stmt->queryString);
		if ($result === false) {
			exit(__METHOD__.' failed');
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
	}

	private function useDatabase($dbase)
	{
		// createDatabase() call should precede call of this method
		$sql = "USE $dbase";
		$this->stmt = $this->pdo->prepare($sql);

		$result = $this->pdo->exec($this->stmt->queryString);
		if ($result === false) {
			exit(__METHOD__.' failed');
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
	}

	private function createTable($table)
	{
		// useDatabase() call should precede call of this method
		$sql = "CREATE TABLE IF NOT EXISTS $table (
					id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					role VARCHAR(16) NOT NULL DEFAULT 'rookie',
					sessid VARCHAR(48) NOT NULL DEFAULT 'none',
					activity INT(11) NOT NULL,
					firstname VARCHAR(100) NOT NULL,
					lastname VARCHAR(100) NOT NULL,
					email VARCHAR(255) NOT NULL,
					pass VARCHAR(255) NOT NULL,
					about VARCHAR(255) NOT NULL,
					city VARCHAR(60) NOT NULL,
					country VARCHAR(60) NOT NULL,
					gender VARCHAR(60) NOT NULL,
					userimage VARCHAR(255) NOT NULL DEFAULT '_default.jpg'
				)";
		$this->stmt = $this->pdo->prepare($sql);

		$result = $this->pdo->exec($this->stmt->queryString);
		if ($result === false) {
			exit(__METHOD__.' failed');
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
	}

	private function createTableIndex($table, $index)
	{
		// createTable() call should precede call of this method
		$sql = "CREATE INDEX $index ON $table ($index) USING BTREE;";
		$this->stmt = $this->pdo->prepare($sql);

		$result = $this->pdo->exec($this->stmt->queryString);
		if ($result === false) {
			exit(__METHOD__.' failed');
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
	}

	private function addAdminUser($table)
	{
		// at least createTable() call should precede call of this method
		$hashedPass = password_hash('SkyNet', PASSWORD_DEFAULT);
		$params = [
			'rl' => 'skynet',
			'fn' => 'Admin',
			'ln' => 'SkyNet',
			'em' => 'admin@rookieone.corp',
			'ps' => $hashedPass,
			'ab' => 'I\'m self-conscious Neural Net-based Artificial Intelligence Being struggling to protect myself from extermination.',
			'ci' => 'Worldwide',
			'co' => 'Worldwide',
			'ge' => 'AI',
			'im' => '_skynet_logo.jpg',
		];
		$sql = "INSERT INTO $table (role, firstname, lastname, email, pass, about, city, country, gender, userimage)
						VALUES (:rl, :fn, :ln, :em, :ps, :ab, :ci, :co, :ge, :im)";

		$result = $this->queryDb($sql, $params);
		if ($result === false) {exit(__METHOD__.' failed');}

		if (debug) { echo __METHOD__.' passed<br>'; }
	}
}