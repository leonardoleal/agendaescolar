<?php
class Mensagem {
    public $idMensagem;
    public $idAutor;
    public $assunto;
    public $mensagem;
    public $dataEnvio;
    public $horaEnvio;
    public $dataEvento;
    public $idPrecedente;
    public $totalRespostas;

	public function toArray() {
		return get_object_vars($this);
	}

	public function listarMensagens() {
		$banco = new Banco();
		$stmt = $banco->getPdoConn()->prepare('
					SELECT
						m.idMensagem, m.idAutor, m.idAluno, m.assunto,
						m.mensagem, m.dataEnvio, m.dataEvento, m.idPrecedente,
						(
                            SELECT
                                COUNT(me.idMensagem)
                            FROM
                                mensagem AS me
                            WHERE
                            me.idPrecedente = m.idMensagem
                        ) AS "totalRespostas"
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

	public function listarProximosEventos($limite = 3) {
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
						AND m.dataEvento > DATE(NOW())
					ORDER BY
						m.dataEvento ASC
					LIMIT
						:limite
		');

		$stmt->bindValue(':idLogado', Sessao::getIdPessoa(), PDO::PARAM_INT);
		$stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
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

    public function detalhesMensagem($idMsgPai) {
        $banco = new Banco();
        $stmt = $banco->getPdoConn()->prepare('
					SELECT
						m.idMensagem, m.idAutor, m.idAluno, m.assunto,
						m.mensagem, m.dataEnvio, m.dataEvento, m.idPrecedente
					FROM
						mensagem AS m
					WHERE
					    m.idMensagem = :idMessage
					    OR m.idPrecedente = :idMessage
                    ORDER BY
                        m.dataEnvio ASC
		');

        $stmt->bindValue(':idMessage', $idMsgPai, PDO::PARAM_INT);
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
}