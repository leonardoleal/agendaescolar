<?php
class Mensagem {
	private $idMensagem;
	private $idAutor;
	private $assunto;
	private $mensagem;
	private $dataEnvio;
	private $horaEnvio;
	private $dataEvento;

	public function getIdMensagem() {
		return $this->idMensagem;
	}

	public function getIdAutor() {
		return $this->idAutor;
	}

	public function setIdAutor($idAutor) {
		$this->idAutor = $idAutor;
	}

	public function getAssunto() {
		return $this->assunto;
	}
	
	public function setAssunto($assunto) {
		$this->assunto = $assunto;
	}

	public function getMensagem() {
		return $this->mensagem;
	}
	
	public function setMensagem($mensagem) {
		$this->mensagem = $mensagem;
	}

	public function getDataEnvio() {
		return $this->dataEnvio;
	}

	public function setDataEnvio($dataEnvio) {
		$this->dataEnvio = $dataEnvio;
	}

	public function getHoraEnvio() {
		return $this->horaEnvio;
	}
	
	public function setHoraEnvio($horaEnvio) {
		$this->horaEnvio = $horaEnvio;
	}

	public function getDataEvento() {
		return $this->dataEvento;
	}
	
	public function setDataEvento($dataEvento) {
		$this->dataEvento = $dataEvento;
	}

	public function toArray() {
		return get_object_vars($this);
	}
}