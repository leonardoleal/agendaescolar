<?php
class View {
	public static $HEADER = 'Header';
	public static $FOOTER = 'Footer';
	private static $data = array();
	private static $complete = TRUE;

	static function addData($value, $name = NULL) {
		if (!empty($value)) {
			if (is_null($name)) {
				VIEW::$data[] = $value;
			} else {
				VIEW::$data[$name] = $value;
			}
		}
	}

	static function load($view, $data = NULL) {
		View::addData($data);
		$data = View::$data;

		if (View::$complete) {
			include_once 'view/'. View::$HEADER .'.php';
		}

		include_once 'view/'. $view .'.php';

		if (View::$complete) {
			include_once 'view/'. View::$FOOTER .'.php';
		}
	}

	static public function setComplete($bool = TRUE) {
		View::$complete = $bool;
	}
}