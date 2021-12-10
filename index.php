<?php
	// Include include
	include "core/helpers/include.php";

	// Core and helpers include
	include_files("core/");

	// Models include
	include_files("models/");

	// Include class Controller
	include "controllers/Controller.php";

	// Others include
	include "routes.php";

	// Data for connecting to the base
	define("HOST", 		"localhost");
	define("USERNAME", 	"root");
	define("PASSWORD", 	"root");
	define("DBNAME", 	"music");

	// Server
	$server = new Server();

	// Check and processing route in case of availability
	if(!$server->search_route($_SERVER["REQUEST_URI"]))
		echo "<h1>This path doesn't exist</h1>";
		// or return view("404"); in view

?>