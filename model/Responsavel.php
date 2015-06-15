<?php
class Responsavel extends Pessoa {
    public $idResponsavel;

    public function buscarTodos() {
        $banco = new Banco();
        $stmt = $banco->getPdoConn()->prepare('
					SELECT
						*
					FROM
						responsavel AS r
						LEFT JOIN pessoa p
						  ON p.idpessoa = r.idPessoa
		');

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Responsavel');

        if (!$stmt->execute()) {
            throw new ErrorException('Erro na consulta ao banco');
        }

        if ($stmt->rowCount() < 1) {
            return FALSE;
        }

        $responsaveis = $stmt->fetchAll();
        $stmt->closeCursor();

        return $responsaveis;
    }
} 