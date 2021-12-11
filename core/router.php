<?php
class Router {
	// Array of routes
	private static $routes = array();

	// Add GET route
	public static function get($path, $value) {
		$path = slash_check($path);
		self::$routes["GET"][$path] = $value;
	}

	// Add POST route
	public static function post($path, $values) {
		$path = slash_check($path);
		self::$routes["POST"][$path] = $values;
	}

	// Search route
	public static function search($path, $type) {
		if(count(self::$routes) == 0) return false;
		if(array_key_exists($path, self::$routes[$type])) {
			return self::$routes[$type][$path];
		} else return false;
	}
}
?>