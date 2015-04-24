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

		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json");
		echo json_encode($arrMensagens, JSON_FORCE_OBJECT);
	} 
}