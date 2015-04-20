<?php
class Usuario {
	private $idUsuario;
	public $idPessoa;
	public $usuario;
	public $senha;
	public $inicioSessao;
	public $token;

	function getIdUsuario() {
		return $this->idUsuario;
	}
}