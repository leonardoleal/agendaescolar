<?php
class MensagemController extends Controller {

	public function init() {
		Sessao::redirecionaNaoLogado();
	}
	
	public function index() {
		HTML::redirect('mensagem/listar');
	}

	public function listar() {
		$mensagem = new Mensagem();

		$mensagens = $mensagem->listarMensagensProfessor();
		View::addData($mensagens, 'mensagens');

		$totalRegistros = $mensagem->contarMensagensProfessor();
		View::addData($totalRegistros, 'totalRegistros');

		View::load('MensagemListar');
	}
}