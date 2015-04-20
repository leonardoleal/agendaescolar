<?php
class Usuario {
	private $idUsuario;
	public $idPessoa;
	public $usuario;
	public $senha;
	public $inicioSessao;
	public $token;

	public function getIdUsuario() {
		return $this->idUsuario;
	}

	public function gerarToken() {
		$this->inicioSessao = date('Y-m-d h:i:s');

		$this->token = md5(
				uniqid(
						md5($this->getIdUsuario()+$this->inicioSessao)
						, true
				)
		);
	}
}