<?php
class Mensagem {
	private $idMensagem;
	private $idAutor;
	private $assunto;
	private $mensagem;
	private $dataEnvio;
	private $horaEnvio;
	private $dataEvento;

	public function getIdMensagem() {
		return $this->idMensagem;
	}

	public function getIdAutor() {
		return $this->idAutor;
	}

	public function setIdAutor($idAutor) {
		$this->idAutor = $idAutor;
	}

	public function getAssunto() {
		return $this->assunto;
	}
	
	public function setAssunto($assunto) {
		$this->assunto = $assunto;
	}

	public function getMensagem() {
		return $this->mensagem;
	}
	
	public function setMensagem($mensagem) {
		$this->mensagem = $mensagem;
	}

	public function getDataEnvio() {
		return $this->dataEnvio;
	}

	public function setDataEnvio($dataEnvio) {
		$this->dataEnvio = $dataEnvio;
	}

	public function getHoraEnvio() {
		return $this->horaEnvio;
	}
	
	public function setHoraEnvio($horaEnvio) {
		$this->horaEnvio = $horaEnvio;
	}

	public function getDataEvento() {
		return $this->dataEvento;
	}
	
	public function setDataEvento($dataEvento) {
		$this->dataEvento = $dataEvento;
	}

	public function toArray() {
		return get_object_vars($this);
	}

	public function listarMensagensProfessor() {
		$banco = new Banco();
		$stmt = $banco->getPdoConn()->prepare('
					SELECT
						m.idMensagem, m.idAutor, m.idAluno, m.assunto,
						m.mensagem, m.dataEnvio, m.dataEvento, m.idPrecedente
					FROM
						mensagem AS m
					WHERE
						m.idAutor = :idLogado
						AND m.idPrecedente IS NULL
		'); // TODO adicionar parametros e paginar

		$stmt->bindValue(':idLogado', Sessao::getIdPessoa(), PDO::PARAM_INT);
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Mensagem');

		if (!$stmt->execute()) {
			throw new ErrorException('Erro na consulta ao banco');
		}

		if ($stmt->rowCount() < 1) {
			return FALSE;
		}

		$mensagens = $stmt->fetchAll();
		$stmt->closeCursor();

		return $mensagens;
	}

	public function contarMensagensProfessor() {
		$banco = new Banco();
		$stmt = $banco->getPdoConn()->prepare('
					SELECT
						COUNT(m.idMensagem)
					FROM
						mensagem AS m
					WHERE
						m.idAutor = :idLogado
						AND m.idPrecedente IS NULL
		');

		$stmt->bindValue(':idLogado', Sessao::getIdPessoa(), PDO::PARAM_INT);
	
		if (!$stmt->execute()) {
			throw new ErrorException('Erro na consulta ao banco');
		}
	
		if ($stmt->rowCount() < 1) {
			return FALSE;
		}
	
		$total = $stmt->fetchColumn(0);
		$stmt->closeCursor();
	
		return $total;
	}
}