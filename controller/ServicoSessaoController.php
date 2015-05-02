<?php
class ServicoSessaoController extends Controller {

	function index() {
		echo ('Ação inválida.');
	}

	public function validarUsuario() {
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json");

		if (!empty($this->post['usuario'])
				AND !empty($this->post['senha'])
		) {
			$banco = new Banco();
			$stmt = $banco->getPdoConn()->prepare('
					SELECT
						u.*
					FROM
						usuario AS u
						INNER JOIN responsavel AS r
						ON r.idPessoa = u.idPessoa
					WHERE
						usuario = :usuario
						AND senha = :senha
					LIMIT 1;
			');

			$stmt->bindValue(':usuario', $this->post['usuario'], PDO::PARAM_STR);
			$stmt->bindValue(':senha', MD5($this->post['senha']), PDO::PARAM_STR);
			$stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario');

			if ($stmt->execute()) {
				$usuario = $stmt->fetch();
				$stmt->closeCursor();

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

		if (!empty($this->parameters[0])) {
			$banco = new Banco();
			$stmt = $banco->getPdoConn()->prepare('
					SELECT
						*
					FROM
						usuario
					WHERE
						token = :token
					LIMIT 1;
			');

			$stmt->bindValue(':token', $this->parameters[0], PDO::PARAM_STR);
			$stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario');

			if ($stmt->execute()) {
				$usuario = $stmt->fetch();
				$stmt->closeCursor();

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
		$stmt = $banco->getPdoConn()->prepare('
					UPDATE 
						usuario
					SET
						inicioSessao = :inicioSessao,
						token = :token
					WHERE
						idUsuario = :idUsuario
		');

		$stmt->bindValue(':idUsuario', $usuario->getIdUsuario(), PDO::PARAM_INT);
		$stmt->bindValue(':inicioSessao', $usuario->inicioSessao, PDO::PARAM_STR);
		$stmt->bindValue(':token', $usuario->token, PDO::PARAM_STR);

		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
		$stmt->execute();

		return $usuario;
	}
}