<?php
class Sessao {
	static function registrarSessao(Usuario $usuario) {
		Sessao::startSession();
		if (isset($usuario)) {
			$_SESSION['id'] = $usuario->getIdUsuario();
			$_SESSION['nomeUsuario'] = $usuario->usuario;
			$_SESSION['logado'] = true;
			$_SESSION['token'] = $usuario->token;
		}
	}

	static function isLogado() {
		Sessao::startSession();
		return isset($_SESSION['logado']);
	}

	static function getId() {
		Sessao::startSession();
		return $_SESSION['id'];
	}

	static function getNome() {
		Sessao::startSession();
		return $_SESSION['nomeUsuario'];
	}

	static function getToken() {
		Sessao::startSession();
		return $_SESSION['token'];
	}

	static function encerrarSessao() {
		Sessao::startSession();
		unset($_SESSION['id']);
		unset($_SESSION['nomeUsuario']);
		unset($_SESSION['logado']);
		unset($_SESSION['token']);
	}

	static function redirecionaNaoLogado($url = '/') {
		Sessao::startSession();
		if (! Sessao::isLogado()) {
			header('Location: ' . $url);
		}
	}

	static private function startSession() {
		if(session_id() == '') {
			session_start("logado");
		}
	}

	static public function setMensagem($msg) {
		Sessao::startSession();
		$_SESSION['mensagem'] = $msg;
		
	}

	static public function getMensagem() {
		Sessao::startSession();
		if (Sessao::hasMensagem()) {
			$msg = $_SESSION['mensagem'];
			unset($_SESSION['mensagem']);

			return $msg;
		}

		return FALSE;
	}

	static public function hasMensagem() {
		Sessao::startSession();
		if (isset($_SESSION['mensagem'])) {
			return TRUE;
		}

		return FALSE;
	}
}