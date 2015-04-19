<?php
function __autoload($arquivo)
{
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
} else {
// 	$classe = 'LoginController';
}

new $classe();