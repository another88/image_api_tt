<?php
require_once "config/database.php";

require_once "api/image.php";

define('VIEW_PATH', 'views/');

class loader {
	private static $_allowed_views = array('index','browse');
	public static function view($filename, $data, $return = FALSE) {

		if (strpos($filename, '.php') === FALSE) {

			$filename .= '.php';

		}

		if (!file_exists(VIEW_PATH . $filename)) {

			die("Can't load view");

		}

		foreach ($data as $key => $value) {

			$$key = $value;

		}

		ob_start();

		require_once VIEW_PATH . $filename;
		
		$content = ob_get_contents();

		ob_end_clean();

		if ($return) {

			return $content;

		}

		echo $content;

	}

	public static function getView(){
		$path = $_SERVER['REQUEST_URI'];
		$path = explode('?', $path);
		$uri = explode('/', $path[0]);
		//default view
		$view = 'index';
		if(is_array($uri)){
			foreach ($uri as $key => $value) {
				if(in_array($value, self::$_allowed_views)){
					$view = $value;
					break;
				}
			}
		}
		
		return $view;
	}
}

