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
				
			$banco->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
			$banco->bindValue(':usuario', $this->post['usuario'], PDO::PARAM_STR);
			$banco->bindValue(':senha', $this->post['senha'], PDO::PARAM_STR);
			
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
		echo "{msg: 'Usuário e senha inválido.}";
	}

	private function gerarToken(Usuario $usuario) {
		$usuario->inicioSessao = date('Y-m-d h:i:s');

		$usuario->token = md5(uniqid(
						md5($usuario->getId()+$usuario->inicioSessao)
						, true)
				);

		$banco = new Banco();
		$banco = $banco->getPdoConn()->prepare('
					UPDATE 
						usuario
					SET
						inicioSessao = :inicioSessao,
						token = :token
					WHERE
						id = :id
		');

		$banco->bindValue(':id', $usuario->getId(), PDO::PARAM_INT);
		$banco->bindValue(':inicioSessao', $usuario->inicioSessao, PDO::PARAM_STR);
		$banco->bindValue(':token', $usuario->token, PDO::PARAM_STR);
		$banco->execute();

		return $usuario;
	}
}