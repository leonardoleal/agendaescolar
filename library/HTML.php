<?php
class HTML {
	static public function redirect($url) {
		header('Location: '. $url);
	}
}