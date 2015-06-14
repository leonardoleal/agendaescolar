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

		$mensagens = $mensagem->listarMensagens();
		View::addData($mensagens, 'mensagens');

		$totalRegistros = $mensagem->contarMensagensProfessor();
		View::addData($totalRegistros, 'totalRegistros');

		View::load('MensagemListar');
	}

    public function detalhes() {
        $mensagem = new Mensagem();

        $mensagens = $mensagem->detalhesMensagem((int) $this->parameters[0]);
        View::addData($mensagens, 'mensagens');

        View::load('MensagemDetalhes');
    }

    public function nova() {
        View::load('MensagemNova');
    }

    public function enviar() {
        HTML::redirect('mensagem/detalhes');
    }
}