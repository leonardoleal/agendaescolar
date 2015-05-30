<?php
class View {
	public static $HEADER = 'header';
	public static $FOOTER = 'footer';

	static function load($view, $complete = TRUE) {
		if ($complete) {
			include_once 'view/'. View::$HEADER .'.php';
		}

		include_once 'view/'. $view .'.php';

		if ($complete) {
			include_once 'view/'. View::$FOOTER .'.php';
		}
	}
}