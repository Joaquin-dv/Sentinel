<?php

	/* Se instancia a la clase del motor de plantillas */
	$tpl = new Enano("panel");

	$tpl->assignVar(["APP_SECTION" => "Panel", "USER_NAME" => ""]);

	/* Imprime la plantilla en la página */
	$tpl->printToScreen();


 ?>