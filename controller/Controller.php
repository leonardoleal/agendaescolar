<?php
abstract class Controller {
	protected $parameters = array();
	protected $post = array();

	function __construct() {
		if (isset($_GET['parameters'])) {
			$this->parameters = explode('/', $_GET['parameters']);
		}

		if (isset($_POST)) {
			$this->post = $_POST;
		}

		if (!isset($_GET['action'])) {
			$_GET['action'] = 'index';
		}
		$this->$_GET['action']();
	}

	abstract function index();
}