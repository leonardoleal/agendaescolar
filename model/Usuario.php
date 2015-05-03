<?php
class Usuario {
	private $idUsuario;
	public $idPessoa;
	public $usuario;
	public $senha;
	public $inicioSessao;
	public $token;
	private $tipoUsuario;

	function __construct(TipoUsuarioEnum $tipoUsuario = NULL) {
		if ($tipoUsuario != NULL)
			$this->tipoUsuario = $tipoUsuario->getValue();
	}

	public function getIdUsuario() {
		return $this->idUsuario;
	}

	public function validarUsuario() {
		$banco = new Banco();

		$stmt = $banco->getPdoConn()->prepare('
					SELECT
						u.*
					FROM
						usuario AS u
						INNER JOIN '. $this->tipoUsuario .' AS tu
						ON tu.idPessoa = u.idPessoa
					WHERE
						usuario = :usuario
						AND senha = :senha
					LIMIT 1;
		');

		$stmt->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
		$stmt->bindValue(':senha', MD5($this->senha), PDO::PARAM_STR);
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$u = $stmt->fetch();
			$stmt->closeCursor();

			$this->idUsuario = $u->idUsuario;
			$this->idPessoa = $u->idPessoa;

			return TRUE;
		}

		return FALSE;
	}

	public function gerarToken() {
		$this->inicioSessao = date('Y-m-d h:i:s');
		$this->token = md5(
				uniqid(
						md5($this->getIdUsuario()+$this->inicioSessao)
						, TRUE
				)
		);

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
		$stmt->bindValue(':idUsuario', $this->idUsuario, PDO::PARAM_INT);
		$stmt->bindValue(':inicioSessao', $this->inicioSessao, PDO::PARAM_STR);
		$stmt->bindValue(':token', $this->token, PDO::PARAM_STR);

		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			$stmt->closeCursor();

			return TRUE;
		}

		$this->token = NULL;
		return FALSE;
	}

	public function validarToken() {
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
		
		$stmt->bindValue(':token', $this->token, PDO::PARAM_STR);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$stmt->closeCursor();
			return TRUE;
		}

		return FALSE;
	}
}