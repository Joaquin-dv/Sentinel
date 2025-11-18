<?php

	if (!isset($_SESSION['user'])) {
		header("Location: ?slug=login");		
	}

	/* Se instancia a la clase del motor de plantillas */
	$tpl = new Enano("panel");

	$username = $_SESSION['user']["nombres"];

	$tpl->assignVar(["APP_SECTION" => "Panel", "USER_NAME" => $username]);

	/* Imprime la plantilla en la página */
	$tpl->printToScreen();


 ?>