<?php

	/* Se instancia a la clase del motor de plantillas */
	$tpl = new Enano("landing");

	/*para asignar valor a las variables dentro la plantilla*/
	/* formato {{ variable }} valor a pasar como un vector asociativo [ variable_html => valor] */
	$tpl->assignVar(["APP_SECTION" => "Bienvenido"]);

	/* Imprime la plantilla en la página */
	$tpl->printToScreen();


 ?>