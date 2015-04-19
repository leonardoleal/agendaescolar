<?php
abstract class Controller {

	function __construct() {
		if (!isset($_GET['action'])) {
			$_GET['action'] = 'index';
		}
		$this->$_GET['action']();
	}

	abstract function index();
}