<?php
ob_start();
header('Content-Type: text/html; charset=utf-8');

function __autoload($arquivo) {
	if (file_exists("controller/".$arquivo.".php")) {
		include_once "controller/".$arquivo.".php";
	} elseif (file_exists("model/".$arquivo.".php")) {
		include_once "model/".$arquivo.".php";
	} elseif (file_exists("view/".$arquivo.".php")) {
		include_once "view/".$arquivo.".php";
	} elseif (file_exists("library/".$arquivo.".php")) {
		include_once "library/".$arquivo.".php";
	}
}
// var_dump($_REQUEST);
if (isset($_GET['controller'])) {
	$classe = ucfirst($_GET['controller']).'Controller';

	if (isset($_GET['action'])) {
		$method = $_GET['action'];
	} else {
		$method = 'index';
	}
} else {
	$classe = 'LoginController';
	$method = 'index';
}

$controller = new $classe();
$controller->$method();