<?php
class Data {

	static public function setLocalePtBr() {
		setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		date_default_timezone_set('America/Sao_Paulo');
	}

	static public function getDataExtenso($str = 'today') {
		Data::setLocalePtBr();

		return utf8_encode(ucfirst(strftime('%A, %d de %B de %Y', strtotime($str))));
	}

	static public function getDataHoraExtenso($str = 'now') {
		Data::setLocalePtBr();

        return utf8_encode(ucfirst(strftime('%A, %d de %B de %Y as %H:%M', strtotime($str))));
	}
}