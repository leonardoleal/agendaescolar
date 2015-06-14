<?php
class ServicoSessaoController extends Controller {

	public function index() {
		echo ('Ação inválida.');
	}

	public function validarUsuario() {
		if (!empty($this->post['usuario'])
				AND !empty($this->post['senha'])
		) {
			$usuario = new Usuario(new TipoUsuarioEnum(TipoUsuarioEnum::RESPONSAVEL));
			$usuario->usuario = $this->post['usuario'];
			$usuario->senha = $this->post['senha'];

			if ($usuario->validarUsuario()) {
				$usuario->gerarToken();
				Sessao::registrarSessao($usuario);

                View::loadJSON($usuario);
				exit(0);
			}
		}

        View::loadJSON(array('msg' => 'Usuário e senha inválido.'));
		exit(1);
	}

	public function validarToken() {
		if (!empty($this->parameters[0])) {
			$usuario = new Usuario();
			$usuario->token = $this->parameters[0];

			if ($usuario->validarToken()) {
				Sessao::registrarSessao($usuario);
				return 1;
			}
		}

        View::loadJSON(array('msg' => 'Token inválido.'));
		exit(0);
	}
}