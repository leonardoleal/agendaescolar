<?php
class HTML {
	static public function redirect($url) {
		header('Location: '. $url);
	}

	static public function isSelectedPage($page) {
		return strstr($_SERVER['QUERY_STRING'], '='. $page);
	}
}