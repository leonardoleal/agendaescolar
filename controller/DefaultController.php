<?php
class DefaultController extends Controller {

	public function init() {
		Sessao::redirecionaNaoLogado();
	}
	
	public function index() {
		$mensagem = new Mensagem();

		$eventos = $mensagem->listarProximosEventos(5);
		View::addData($eventos, 'proximosEventos');

		View::load('Default');
	}
}