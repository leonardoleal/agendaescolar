<?php
class Banco {
	private $pdo;
	function __construct() {
		$this->pdo = new PDO('mysql:host=localhost;dbname=agendaescolar', 'root', '');
	}

	function pdo() {
		return $this->pdo;
	}
}