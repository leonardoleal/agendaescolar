<?php
class Banco {
	private $pdo;
	function __construct() {
		$this->pdo = new PDO('mysql:host=localhost;dbname=', '', '');
	}

	function getPdoConn() {
		return $this->pdo;
	}
}