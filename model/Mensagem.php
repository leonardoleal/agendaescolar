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
    public $idDestinatario;
    public $destinatarios;

    public function __construct() {
        $this->destinatarios = array();
    }

	public function toArray() {
		return get_object_vars($this);
	}

	public function listarMensagens() {
		$banco = new Banco();
		$stmt = $banco->getPdoConn()->prepare('
					SELECT
						m.idMensagem, m.idAutor, m.idAluno, m.assunto,
						m.mensagem, m.dataEnvio, m.dataEvento, m.idPrecedente,
						(SELECT
                                COUNT(me.idMensagem)
                            FROM
                                mensagem AS me
                            WHERE
                            me.idPrecedente = m.idMensagem
                        ) AS "totalRespostas"
					FROM
						mensagem AS m
						INNER JOIN professor_mensagem AS prme
						  ON prme.idMensagem = m.idMensagem
					WHERE
						m.idAutor = :idLogado
						AND m.idPrecedente IS NULL
                    ORDER BY
                        m.dataEnvio DESC
		'); // TODO adicionar parametros e paginar

		$stmt->bindValue(':idLogado', Sessao::getIdPessoa(), PDO::PARAM_INT);
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Mensagem');

		if (!$stmt->execute()) {
			throw new ErrorException('Erro na consulta ao banco');
		}

        $mensagens = $stmt->fetchAll();

        $stmt = $banco->getPdoConn()->prepare('
					SELECT
					    m.idMensagem,
						pe.nome
					FROM
						mensagem AS m
						INNER JOIN professor_mensagem AS prme
						  ON prme.idMensagem = m.idMensagem
						INNER JOIN responsavel_mensagem AS reme
						  ON reme.idMensagem = m.idMensagem
						INNER JOIN responsavel AS re
						  ON re.idResponsavel = reme.idResponsavel
						INNER JOIN pessoa AS pe
						  ON pe.idPessoa = re.idPessoa
					WHERE
						m.idAutor = :idLogado
						AND m.idPrecedente IS NULL
                    ORDER BY
                        m.dataEnvio DESC
		'); // TODO adicionar parametros e paginar

        $stmt->bindValue(':idLogado', Sessao::getIdPessoa(), PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt->execute()) {
            throw new ErrorException('Erro na consulta ao banco');
        }

		if ($stmt->rowCount() < 1) {
			return FALSE;
		}

        $mensagemDestinatarios = $stmt->fetchAll();
        foreach($mensagens as $mensagem) {
            foreach($mensagemDestinatarios as $key => $destinatario) {
                if($mensagem->idMensagem == $destinatario['idMensagem']) {
                    array_push($mensagem->destinatarios, $destinatario['nome']);
                    unset($mensagemDestinatarios[$key]);
                }
            }
        }
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

    public function listarTodosEventos() {
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
						AND m.dataEvento IS NOT NULL
		');

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
						INNER JOIN professor_mensagem AS prme
						  ON prme.idMensagem = m.idMensagem
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
						INNER JOIN professor_mensagem AS prme
						  ON prme.idMensagem = m.idMensagem
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

        $stmt = $banco->getPdoConn()->prepare('
					SELECT
						m.idMensagem,
						pe.nome
					FROM
						mensagem AS m
						INNER JOIN professor_mensagem AS prme
						  ON prme.idMensagem = m.idMensagem
						INNER JOIN responsavel_mensagem AS reme
						  ON reme.idMensagem = m.idMensagem
						INNER JOIN responsavel AS re
						  ON re.idResponsavel = reme.idResponsavel
						INNER JOIN pessoa AS pe
						  ON pe.idPessoa = re.idPessoa
					WHERE
					    m.idMensagem = :idMessage
					    OR m.idPrecedente = :idMessage
                    ORDER BY
                        m.dataEnvio ASC
		');

        $stmt->bindValue(':idMessage', $idMsgPai, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt->execute()) {
            throw new ErrorException('Erro na consulta ao banco');
        }

        if ($stmt->rowCount() < 1) {
            return FALSE;
        }

        $mensagemDestinatarios = $stmt->fetchAll();
        foreach($mensagens as $mensagem) {
            foreach($mensagemDestinatarios as $key => $destinatario) {
                if($mensagem->idMensagem == $destinatario['idMensagem']) {
                    array_push($mensagem->destinatarios, $destinatario['nome']);
                    unset($mensagemDestinatarios[$key]);
                }
            }
        }
        $stmt->closeCursor();

        return $mensagens;
    }

    public function gravar() {
        $banco = new Banco();
        $banco = $banco->getPdoConn();
        $banco->beginTransaction();

        $stmt = $banco->prepare('
                    INSERT INTO
                        mensagem (
                            idAutor,
                            idAluno,
                            assunto,
                            mensagem,
                            dataEvento,
                            idPrecedente
                        )
                    VALUES (
                        :idPessoa,
                        (SELECT a.idAluno FROM aluno a
                            INNER JOIN aluno_responsavel ar
                              ON ar.idAluno = a.idAluno
                              INNER JOIN responsavel r
                                ON r.idResponsavel = ar.idResponsavel
                                  AND r.idResponsavel = :idDestinatario
                            LIMIT 1),
                        :assunto,
                        :mensagem,
                        :dataEvento,
                        :idPrecedente
                    );
        ');
        $stmt->bindValue(':idPessoa', $this->idAutor, PDO::PARAM_INT);
        $stmt->bindValue(':idDestinatario', $this->idDestinatario, PDO::PARAM_INT);
        $stmt->bindValue(':assunto', $this->assunto, PDO::PARAM_STR);
        $stmt->bindValue(':mensagem', $this->mensagem, PDO::PARAM_STR);
        $stmt->bindValue(':dataEvento', $this->dataEvento, PDO::PARAM_STR);
        $stmt->bindValue(':idPrecedente', $this->idPrecedente, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            $banco->rollBack();
            return FALSE;
        }

        $idMensagemNova = $banco->lastInsertId();

        $stmt = $banco->prepare('
                    INSERT INTO
                        professor_mensagem (
                            idProfessor,
                            idMensagem
                        )
                    VALUES (
                        (SELECT p.idProfessor FROM professor p WHERE p.idPessoa = :idPessoa),
                        :idMensagemNova
                    );
        ');
        $stmt->bindValue(':idPessoa', $this->idAutor, PDO::PARAM_INT);
        $stmt->bindValue(':idMensagemNova', $idMensagemNova, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            $banco->rollBack();
            return FALSE;
        }

        $stmt = $banco->prepare('
                    INSERT INTO
                        responsavel_mensagem (
                            idResponsavel,
                            idMensagem
                        )
                    VALUES (
                        :idDestinatario,
                        :idMensagemNova
                    );
        ');
        $stmt->bindValue(':idDestinatario', $this->idDestinatario, PDO::PARAM_INT);
        $stmt->bindValue(':idMensagemNova', $idMensagemNova, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            $banco->rollBack();
            return FALSE;
        }

        $banco->commit();
        return TRUE;
    }

    public function excluirRelacaoProfessor($idMesagem) {
        $banco = new Banco();
        $banco = $banco->getPdoConn();
        $banco->beginTransaction();

        $qMarks = str_repeat('?,', count($idMesagem) - 1) . '?';
        $stmt = $banco->prepare('
                    DELETE prme.* FROM
                        professor_mensagem as prme
                        INNER JOIN professor AS pr
                          ON pr.idProfessor = prme.idProfessor
                    WHERE
                        prme.idMensagem IN('. $qMarks .')
        ');

        if ($stmt->execute($idMesagem)) {
            $banco->commit();
            return TRUE;
        }

        $banco->rollBack();
        return FALSE;
    }
}