<?php
class Sessao
{
	static function registrarSessao($nomeUsuario, $id)
	{
		session_start("logado");

		if (isset($nomeUsuario)) {
			$_SESSION['id'] = $id;
			$_SESSION['nomeUsuario'] = $nomeUsuario;
			$_SESSION['logado'] = true;
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

	static function encerrarSessao()
	{
		session_start("logado");
		unset($_SESSION['id']);
		unset($_SESSION['nomeUsuario']);
		unset($_SESSION['logado']);
	}
}