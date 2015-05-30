<?php
class TesteController extends Controller {
	public function index() {
		echo '<a href="teste/login">Login</a><br>';
		echo '<a href="teste/alterarStatus">Alterar Status</a><br>';
		echo '<a href="teste/responderMensagem">Responder Mensagem</a><br>';
	}

	public function login() {
		echo '
				<form action="../servicoSessao/validarUsuario" method="POST">
					Usuario:<input type="text" name="usuario" value="responsavel1A">
					Senha:<input type="text" name="senha" value="1234">
					<input type="submit">
				</form>
		';
	}

	public function alterarStatus() {
		if (!isset($this->parameters[0])) {
			die('O parâmetro de token deve ser setado na URL.');
		}

		echo '
				<form action="../../servicoMensagem/alterarStatusMensagem/'. $this->parameters[0] .'" method="POST">
					idMensagem:<input type="text" name="idMensagem[]" value="">
					<input type="text" name="idMensagem[]" value="">
					Status:<input type="text" name="status" value="recebido">
					<input type="submit">
				</form>
		';
	}

	public function responderMensagem() {
		if (!isset($this->parameters[0])) {
			die('O parâmetro de token deve ser setado na URL.');
		}
		$smc = new ServicoMensagemController();

		header("Access-Control-Allow-Origin: *");
		header("Content-Type: text/html; charset=UTF8");

		$smc->consultaPorResponsavel();

		echo '
				<form action="../../servicoMensagem/respostaResponsavel/'. $this->parameters[0] .'" method="POST">
					idMensagem:<input type="text" name="idMensagem" value="">
					idPessoa:<input type="text" name="idPessoa" value="21">
					Mensagem:<textarea name="mensagem"></textarea>
					<input type="submit">
				</form>
		';
	}
}