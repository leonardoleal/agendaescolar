<?php
class Banco {
	private $pdo;
	function __construct() {
 		$this->pdo = new PDO(
            'mysql:host=localhost;dbname=',
            '',
            '',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
        );

		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	}

	function getPdoConn() {
		return $this->pdo;
	}
}