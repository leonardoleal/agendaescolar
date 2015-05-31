<?php
class LoginController extends Controller {

	public function index() {
		View::load('Login');
	}

	public function validar() {

		if (!empty($this->post['usuario'])
				AND !empty($this->post['senha'])
		) {
			$usuario = new Usuario(new TipoUsuarioEnum(TipoUsuarioEnum::PROFESSOR));
			$usuario->usuario = $this->post['usuario'];
			$usuario->senha = $this->post['senha'];

			if ($usuario->validarUsuario()) {
				Sessao::registrarSessao($usuario);

				HTML::redirect('../default');
				return;
			}
		}

		Sessao::setMensagem('Usuário e/ou senha inválidos.');
		$this->encerrar();
	}

	public function encerrar() {
		Sessao::encerrarSessao();
		HTML::redirect('../login');
	}
}