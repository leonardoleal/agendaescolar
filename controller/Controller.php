<?php
abstract class Controller {
	protected $parameters = array();
	protected $post = array();

	public function __construct() {
		if (isset($_GET['parameters'])) {
			$this->parameters = explode('/', $_GET['parameters']);
		}

		if (isset($_POST)) {
			$this->post = $_POST;
		}

		$this->init();
	}

	protected function init() {}
	abstract function index();

	protected function jsonHeaderDocument() {
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json");
	}
}