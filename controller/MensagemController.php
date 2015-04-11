<?php
class MensagemController {

	function __construct() {
		if (!isset($_GET['act'])) {
			$_GET['act'] = 'consultaPorUsuario';
		}
		$this->$_GET['act']();
	}

	public function consultaPorUsuario() {
		$banco = new Banco();
		$banco = $banco->pdo()->prepare('
					SELECT
						*
					FROM
						mensagem
					WHERE
						1=1;
			');
			
		$banco->setFetchMode(PDO::FETCH_CLASS, 'mensagem');

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