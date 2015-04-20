<?php
class ServicoMensagemController extends Controller {

	function index() {
		echo ('Ação inválida.');
	}

	public function consultaPorUsuario() {
		$banco = new Banco();
		$banco = $banco->getPdoConn()->prepare('
					SELECT
						*
					FROM
						mensagem
					WHERE
						1=1;
			');
			
		$banco->setFetchMode(PDO::FETCH_CLASS, 'Mensagem');

		if (!$banco->execute()) {
			echo "{}";
			return;
		}

		$arrMensagens = $banco->fetchAll(PDO::FETCH_ASSOC);
		$banco->closeCursor();

		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json");
		echo json_encode($arrMensagens, JSON_FORCE_OBJECT);
	} 
}