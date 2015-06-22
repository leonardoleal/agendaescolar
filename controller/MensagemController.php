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
        $responsavel = new Responsavel();

        $responsaveis = $responsavel->buscarTodos();
        View::addData($responsaveis, 'responsaveis');

        View::load('MensagemNova');
    }

    public function enviar() {
        $msg = 'Falha ao enviar a mensagem';
        $mensagem = new Mensagem();

        if(!isset($this->post['idPrecedente'])) {
            $this->post['idPrecedente'] = '';
        }

        if(isset($this->post['mensagem'])
            AND isset($this->post['idDestinatario'])
        ) {
            $mensagem->idAutor = Sessao::getIdPessoa();
            $mensagem->assunto = $this->post['assunto'];
            $mensagem->mensagem = $this->post['mensagem'];
            $mensagem->idPrecedente = $this->post['idPrecedente'] ? : NULL;
            $mensagem->idDestinatario = $this->post['idDestinatario'];
            $mensagem->idDestinatario = $this->post['idDestinatario'];
            $mensagem->dataEvento = !empty($this->post['dataEvento']) ? Data::dateTimeHtml5ToSql($this->post['dataEvento']) : NULL;

            if($mensagem->gravar()) {
                $msg = 'Mensagem enviada';
            }
        }

        Sessao::setMensagem($msg);

        if(empty($this->post['idPrecedente'])) {
            HTML::redirect('../mensagem/listar');
        } else {
            HTML::redirect('../mensagem/detalhes/'. $this->post['idPrecedente']);
        }
    }

    public function excluir() {
        $msg = 'Falha ao excluir a(s) mensagem(s).';

        if(empty($this->post['idMensagem'])) {
            $msg = 'Para excluir é necessário selecionar ao menos uma mensagem.';
        } else {
            $mensagem = new Mensagem();
            if($mensagem->excluirRelacaoProfessor($_POST['idMensagem'], Sessao::getIdPessoa())) {
                $msg = 'Mensagem(s) excluída(s) com sucesso.';
            }
        }

        Sessao::setMensagem($msg);
        HTML::redirect('../mensagem/listar');
    }
}