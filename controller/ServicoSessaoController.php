<?php
class ServicoSessaoController extends Controller {

	public function index() {
		echo ('Ação inválida.');
	}

	public function validarUsuario() {
		$this->jsonHeaderDocument();

		if (!empty($this->post['usuario'])
				AND !empty($this->post['senha'])
		) {
			$usuario = new Usuario(new TipoUsuarioEnum(TipoUsuarioEnum::RESPONSAVEL));
			$usuario->usuario = $this->post['usuario'];
			$usuario->senha = $this->post['senha'];

			if ($usuario->validarUsuario()) {
				$usuario->gerarToken();
				Sessao::registrarSessao($usuario);

				echo json_encode($usuario, JSON_FORCE_OBJECT);
				return 1;
			}
		}
		echo '{msg: "Usuário e senha inválido."}';
		exit(0);
	}

	public function validarToken() {
		$this->jsonHeaderDocument();

		if (!empty($this->parameters[0])) {
			$usuario = new Usuario();
			$usuario->token = $this->parameters[0];

			if ($usuario->validarToken()) {
				Sessao::registrarSessao($usuario);
				return 1;
			}
		}

		echo '{msg: "Token inválido."}';
		exit(0);
	}
}