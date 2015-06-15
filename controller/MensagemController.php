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

        $responsavel = new Responsavel();

        $responsaveis = $responsavel->buscarTodos();
        View::addData($responsaveis, 'responsaveis');



        View::load('MensagemDetalhes');
    }

    public function nova() {
        View::load('MensagemNova');
    }

    public function enviar() {
        $msg = 'Falha ao enviar a mensagem';
        if(isset($this->post['mensagem'])
            AND isset($this->post['idPrecedente'])
        ) {
            $mensagem = new Mensagem();

            $mensagem->idAutor = Sessao::getIdPessoa();
            $mensagem->idPrecedente = $this->post['idPrecedente'];
            $mensagem->mensagem = $this->post['mensagem'];
            $mensagem->destinatario = $this->post['idDestinatario'];

            if($mensagem->gravar()) {
                $msg = 'Mensagem enviada';
            }
        }

        Sessao::setMensagem($msg);
        HTML::redirect('../mensagem/detalhes/'. $this->post['idPrecedente']);
    }
}