<?php
class ServicoMensagemController extends Controller {

	function init() {
		$svSessao = new ServicoSessaoController();
		$svSessao->validarToken();
	}

	function index() {
		echo ('Ação inválida.');
	}

	public function consultaPorResponsavel() {
		$banco = new Banco();
		$banco = $banco->getPdoConn()->prepare('
					SELECT
						m.*,
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
						INNER JOIN pessoa AS pProf
							ON m.idAutor = pProf.idPessoa
					WHERE
						rm.status = "enviado"
		');

		$banco->bindValue(':token', Sessao::getToken(), PDO::PARAM_STR);
		$banco->setFetchMode(PDO::FETCH_CLASS, 'Mensagem');

		if (!$banco->execute()) {
			echo '{msg : "Erro ao selecionar as mensagens."}';
			exit(1);
		}

		$arrMensagens = $banco->fetchAll(PDO::FETCH_ASSOC);
		$banco->closeCursor();

		if (sizeof($arrMensagens) <= 0) {
			echo '{msg : "Nenhuma mensagem para este usuário"}';
			exit(2);
		}

		echo json_encode($arrMensagens, JSON_FORCE_OBJECT);
	}

	public function alterarStatusMensagem() {
		if (isset($this->post['idMensagem'])
				AND isset($this->post['status'])
		) {
			// limpa valores em branco, caso haja
			$this->post['idMensagem'] = array_filter($this->post['idMensagem']);

			$banco = new Banco();
			$banco = $banco->getPdoConn()->prepare('
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
			$banco->bindValue(':status', $this->post['status'], PDO::PARAM_STR);
			$banco->bindValue(':token', Sessao::getToken(), PDO::PARAM_STR);

			if ($banco->execute()) {
				echo '{msg : "Sucesso."}';
				exit(0);
			}
		}

		echo '{msg : "Erro"}';
	}
}