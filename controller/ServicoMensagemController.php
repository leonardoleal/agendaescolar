<?php
class ServicoMensagemController extends Controller {

	public function init() {
		$svSessao = new ServicoSessaoController();
		$svSessao->validarToken();
	}

	public function index() {
		echo ('Ação inválida.');
	}

	public function consultaPorResponsavel() {
		$banco = new Banco();
		$stmt = $banco->getPdoConn()->prepare('
					SELECT
						m.idMensagem, m.idAutor, m.idAluno, m.assunto, m.mensagem, m.dataEnvio, m.dataEvento, m.idPrecedente,
						pProf.nome as "professor"
					FROM
						mensagem AS m
						INNER JOIN responsavelmensagem AS rm
							ON rm.idMensagem = m.idMensagem
						INNER JOIN responsavel AS r
							ON r.idResponsavel = rm.idResponsavel
						INNER JOIN pessoa AS p
							ON p.idpessoa = r.idPessoa
						INNER JOIN usuario AS u
							ON u.idPessoa = p.idpessoa
							AND  u.token = :token
						INNER JOIN (pessoa AS pProf 
									INNER JOIN professor AS prof
									ON pProf.idPessoa = prof.idPessoa
								) ON m.idAutor = pProf.idPessoa
					WHERE
						rm.status = "enviado"
		');

		$stmt->bindValue(':token', Sessao::getToken(), PDO::PARAM_STR);
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Mensagem');

		if (!$stmt->execute()) {
            View::loadJSON(array('msg' => 'Erro ao selecionar as mensagens.'));
			exit(1);
		}

		$mensagens = $stmt->fetchAll();
		$stmt->closeCursor();

		if (sizeof($mensagens) <= 0) {
            View::loadJSON(array('msg' => 'Nenhuma mensagem para este usuário.'));
            exit(2);
        }

        View::loadJSON($mensagens);
	}

	public function alterarStatusMensagem() {
		if (!empty($this->post['idMensagem'])
				AND !empty($this->post['status'])
		) {
			// limpa valores em branco, caso haja
			$this->post['idMensagem'] = array_filter($this->post['idMensagem']);

			$banco = new Banco();
			$banco = $banco->getPdoConn();
			$banco->beginTransaction();

			$stmt = $banco->prepare('
						UPDATE
							responsavelmensagem AS rm
							INNER JOIN responsavel AS r
								ON r.idResponsavel = rm.idResponsavel
							INNER JOIN pessoa AS p
								ON p.idPessoa = r.idPessoa
							INNER JOIN usuario AS u
								ON u.idPessoa = p.idPessoa
									AND u.token = :token
						SET
							status = :status
						WHERE
							rm.idMensagem IN('. join(',', $this->post['idMensagem']) .')
			');
			$stmt->bindValue(':status', $this->post['status'], PDO::PARAM_STR);
			$stmt->bindValue(':token', Sessao::getToken(), PDO::PARAM_STR);

			if ($stmt->execute()) {
				$banco->commit();
                View::loadJSON(array('msg' => 'Sucesso.'));
				exit(0);
			}

		}

        View::loadJSON(array('msg' => 'Erro.'));
	}

	public function respostaResponsavel() {
		if (!empty($this->post['idMensagem'])
				AND !empty($this->post['idPessoa'])
				AND !empty($this->post['mensagem'])
		) {
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
								idPrecedente
							)
						VALUES (
							:idPessoa,
							(SELECT m1.idAluno FROM mensagem m1 WHERE m1.idMensagem = :idMensagem),
							(SELECT m2.assunto FROM mensagem m2 WHERE m2.idMensagem = :idMensagem),
							:mensagem,
							:idMensagem
						);
			');
			$stmt->bindValue(':idPessoa', $this->post['idPessoa'], PDO::PARAM_INT);
			$stmt->bindValue(':idMensagem', $this->post['idMensagem'], PDO::PARAM_INT);
			$stmt->bindValue(':mensagem', $this->post['mensagem'], PDO::PARAM_STR);

			if (!$stmt->execute()) {
				$banco->rollBack();
                View::loadJSON(array('msg' => 'Erro 1.'));
				exit(0);
			}
			$idMensagemNova = $banco->lastInsertId();

			$stmt = $banco->prepare('
						INSERT INTO
							professormensagem (
								idProfessor,
								idMensagem
							)
						VALUES (
							(SELECT pm.idProfessor FROM professormensagem pm WHERE pm.idMensagem = :idMensagem),
							:idMensagemNova
						);
			');
			$stmt->bindValue(':idMensagem', $this->post['idMensagem'], PDO::PARAM_INT);
			$stmt->bindValue(':idMensagemNova', $idMensagemNova, PDO::PARAM_INT);

			if (!$stmt->execute()) {
				$banco->rollBack();
                View::loadJSON(array('msg' => 'Erro 2.'));
				exit(0);
			}

			$stmt = $banco->prepare('
						INSERT INTO
							responsavelmensagem (
								idResponsavel,
								idMensagem
							)
						VALUES (
							(SELECT idResponsavel FROM responsavel WHERE idPessoa = :idPessoa),
							:idMensagemNova
						);
			');
			$stmt->bindValue(':idPessoa', $this->post['idPessoa'], PDO::PARAM_INT);
			$stmt->bindValue(':idMensagemNova', $idMensagemNova, PDO::PARAM_INT);

			if (!$stmt->execute()) {
				$banco->rollBack();
                View::loadJSON(array('msg' => 'Erro 3.'));
				exit(0);
			}

			$banco->commit();
            View::loadJSON(array('msg' => 'Sucesso.'));
			exit();
		}

        View::loadJSON(array('msg' => 'Erro.'));
	}
}