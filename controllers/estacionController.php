<?php

	if (!isset($_SESSION['user'])) {
		header("Location: ?slug=login");		
	}

	/* Se instancia a la clase del motor de plantillas */
	$tpl = new Enano("estacion");

	$id = $_GET['chipid'];
	$tpl->assignVar(["APP_SECTION" => "Estacion", "CHIP_ID" => $id ]);

	/* Imprime la plantilla en la página */
	$tpl->printToScreen();


 ?>