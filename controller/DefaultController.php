<?php
class DefaultController extends Controller {

	public function init() {
		Sessao::redirecionaNaoLogado();
	}
	
	public function index() {
		View::load('Default');
	}
}