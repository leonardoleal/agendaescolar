<?php
class Sessao {
	static function registrarSessao(Usuario $usuario) {
		if (isset($usuario)) {
			Sessao::startSession();
			$_SESSION['id'] = $usuario->getIdUsuario();
			$_SESSION['idPessoa'] = $usuario->getIdPessoa();
			$_SESSION['nomeUsuario'] = $usuario->usuario;
			$_SESSION['logado'] = true;
			$_SESSION['token'] = $usuario->token;
			$_SESSION['inicioSessao'] = $usuario->inicioSessao;
			$_SESSION['ultimaSessao'] = $usuario->ultimaSessao;
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

	static function getIdPessoa() {
		Sessao::startSession();
		return $_SESSION['idPessoa'];
	}

	static function getNome() {
		Sessao::startSession();
		return $_SESSION['nomeUsuario'];
	}

	static function getToken() {
		Sessao::startSession();
		return $_SESSION['token'];
	}

	static function getInicioSessao() {
		Sessao::startSession();
		return $_SESSION['inicioSessao'];
	}

	static function getUltimaSessao() {
		Sessao::startSession();
		return $_SESSION['ultimaSessao'];
	}

	static function encerrarSessao() {
		Sessao::startSession();
		unset($_SESSION['id']);
		unset($_SESSION['nomeUsuario']);
		unset($_SESSION['logado']);
		unset($_SESSION['token']);
        session_destroy();
	}

	static function redirecionaNaoLogado($url = '/') {
		if (! Sessao::isLogado()) {
			header('Location: ' . $url);
		}
	}

	static private function startSession() {
		if(Sessao::is_session_started() === FALSE) {
			session_start("logado");
		}
	}

	static private function is_session_started() {
		if ( php_sapi_name() !== 'cli' ) {
			if ( version_compare(phpversion(), '5.4.0', '>=') ) {
				return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
			} else {
				return session_id() === '' ? FALSE : TRUE;
			}
		}
		return FALSE;
	}

	static public function setMensagem($msg) {
		Sessao::startSession();
		$_SESSION['mensagem'] = $msg;
		
	}

	static public function getMensagem() {
		if (Sessao::hasMensagem()) {
			$msg = $_SESSION['mensagem'];
			unset($_SESSION['mensagem']);

			return $msg;
		}

		return FALSE;
	}

	static public function hasMensagem() {
		Sessao::startSession();
		return isset($_SESSION['mensagem']);
	}
}