<?php
class ServicoSessaoController extends Controller {

	function index() {
		echo ('Ação inválida.');
	}

	public function validarUsuario() {
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json");

		if ((isset($this->post['usuario'])
				AND isset($this->post['senha']))
		) {
			$banco = new Banco();
			$banco = $banco->getPdoConn()->prepare('
					SELECT
						*
					FROM
						usuario
					WHERE
						usuario = :usuario
						AND senha = MD5(:senha)
					LIMIT 1;
			');

			$banco->bindValue(':usuario', $this->post['usuario'], PDO::PARAM_STR);
			$banco->bindValue(':senha', $this->post['senha'], PDO::PARAM_STR);
			$banco->setFetchMode(PDO::FETCH_CLASS, 'Usuario');

			if ($banco->execute()) {
				$usuario = $banco->fetch();
				$banco->closeCursor();

				if ($usuario instanceof Usuario) {
					$usuario = $this->gerarToken($usuario);
					Sessao::registrarSessao($usuario);

					echo json_encode($usuario, JSON_FORCE_OBJECT);
					return 1;
				}
			}
		}
		echo '{msg: "Usuário e senha inválido."}';
		exit(0);
	}

	public function validarToken() {
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json");

		if (isset($this->parameters[0])) {
			$banco = new Banco();
			$banco = $banco->getPdoConn()->prepare('
					SELECT
						*
					FROM
						usuario
					WHERE
						token = :token
					LIMIT 1;
			');

			$banco->bindValue(':token', $this->parameters[0], PDO::PARAM_STR);
			$banco->setFetchMode(PDO::FETCH_CLASS, 'Usuario');

			if ($banco->execute()) {
				$usuario = $banco->fetch();
				$banco->closeCursor();

				if ($usuario instanceof Usuario) {
					Sessao::registrarSessao($usuario);
					return 1;
				}
			}
		}
		echo '{msg: "Token inválido."}';
		exit(0);
	}

	private function gerarToken(Usuario $usuario) {
		$usuario->gerarToken();

		$banco = new Banco();
		$banco = $banco->getPdoConn()->prepare('
					UPDATE 
						usuario
					SET
						inicioSessao = :inicioSessao,
						token = :token
					WHERE
						idUsuario = :idUsuario
		');

		$banco->bindValue(':idUsuario', $usuario->getIdUsuario(), PDO::PARAM_INT);
		$banco->bindValue(':inicioSessao', $usuario->inicioSessao, PDO::PARAM_STR);
		$banco->bindValue(':token', $usuario->token, PDO::PARAM_STR);

		$banco->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
		$banco->execute();

		return $usuario;
	}
}