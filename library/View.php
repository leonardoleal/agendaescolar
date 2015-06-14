<?php
class View {
	public static $HEADER = 'Header';
	public static $FOOTER = 'Footer';
	private static $data = array();
	private static $COMPLETE = TRUE;

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

        if (View::$COMPLETE) {
			include_once 'view/'. View::$HEADER .'.php';
		}

		include_once 'view/'. $view .'.php';

		if (View::$COMPLETE) {
			include_once 'view/'. View::$FOOTER .'.php';
		}
	}

	static public function setComplete($bool = TRUE) {
		View::$COMPLETE = $bool;
	}

    static public function loadJSON($data = NULL) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        if (is_null($data)) {
            $data = View::$data;
        }
        echo(json_encode($data, JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
    }
}