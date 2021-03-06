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

    static public function getDia($str = 'today') {
        Data::setLocalePtBr();


        return date('j', strtotime($str));
    }

    static public function getMes($str = 'today') {
        Data::setLocalePtBr();

        return  date('n', strtotime($str));
    }

	static public function getDataHoraExtenso($str = 'now') {
		Data::setLocalePtBr();

        return utf8_encode(ucfirst(strftime('%A, %d de %B de %Y as %H:%M', strtotime($str))));
	}

    static public function dateTimeHtml5ToSql($date) {
        $date = explode('T', $date);
        return $date[0] .' '. $date[1];
    }

    static public function dateTimeSqlToHtml5($date) {
        return date("Y-m-d\TH:i:s", strtotime($date));
    }
}