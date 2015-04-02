<?php
class View {
	function openHtml($titulo = "Inicial") {
		echo '
		<!DOCTYPE>
		<html>
			<head>
				<title>'. $titulo .'</title>
				<link rel="stylesheet" type="text/css" href="static/estilo.css">
			</head>
			<body>
		';
	}

	function footer() {
		echo '
			<footer>
				<p>Análise e Desenvolvimento de Sistemas</p>
				<p>Prova de Aproveitamento Informal</p>
				<p>Programação para Internet I</p>
			</footer>
		';
	}

	function closeHtml() {
		echo '
			</body>
		</html>
		';
	}
}