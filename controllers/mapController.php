<?php

	// Verificar si está logueado como admin
	if(!isset($_SESSION['admin'])){
		header("Location: ?slug=panel");
		exit();
	}

	$tpl = new Enano("map");
	$tpl->assignVar(["APP_SECTION" => "Map"]);
	$tpl->printToScreen();

?>