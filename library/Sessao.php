<?php
class Sessao
{
	static function registrarSessao(Usuario $usuario) {
		session_start("logado");

		if (isset($usuario)) {
			$_SESSION['id'] = $usuario->getIdUsuario();
			$_SESSION['nomeUsuario'] = $usuario->usuario;
			$_SESSION['logado'] = true;
			$_SESSION['token'] = $usuario->token;
		}
	}

	static function isLogado() {
		session_start("logado");
		return isset($_SESSION['logado']);
	}

	static function getId() {
		return $_SESSION['id'];
	}

	static function getNome() {
		return $_SESSION['nomeUsuario'];
	}

	static function getToken() {
		return $_SESSION['token'];
	}

	static function encerrarSessao() {
		session_start("logado");
		unset($_SESSION['id']);
		unset($_SESSION['nomeUsuario']);
		unset($_SESSION['logado']);
		unset($_SESSION['token']);
	}
}