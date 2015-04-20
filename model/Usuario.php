<?php
class Usuario {
	private $id;
	public $idPessoa;
	public $usuario;
	public $senha;
	public $inicioSessao;
	public $token;

	function getId() {
		return $this->id;
	}
}