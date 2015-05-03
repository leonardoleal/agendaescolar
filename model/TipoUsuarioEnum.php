<?php
class TipoUsuarioEnum extends Enum {
	const _default = self::PROFESSOR;

	const PROFESSOR = 'professor';
	const RESPONSAVEL = 'responsavel';
	const ALUNO = 'aluno';
	const DIRETOR = 'diretor';
}