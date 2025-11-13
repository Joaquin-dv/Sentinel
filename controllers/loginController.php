<?php 

	/**
	 * 
	 * Se incluyen las librerias
	 * Los modelos
	 * 
	 * */

	require_once 'models/Usuarios.php';




	/**
	 * 
	 * Lógica
	 * 
	 * */

	$usuario = new Usuarios();

	if(isset($_POST["btn_login"])){

		if($usuario->login($_POST)["errno"] == 202){
			header("Location: ?slug=panel");
		}
	}


	/***
	 * 
	 * Al final siempre se imprime la vista
	 * 
	 * */

	$tpl = new Enano("login");

	$tpl->assignVar(["CANT_USER" => $usuario->getCant(), "COMPONENT-TABLE" => "<table border='1'>
		{{ ROWS }}
	</table>"]);


	$buffer_row = "";

	for ($i=0; $i < 10; $i++) { 
		$buffer_row .= "<tr>$i</tr>";
	}


	$tpl->assignVar(["ROWS" => $buffer_row]);


	/*para asignar valor a las variables dentro la plantilla*/
	/* formato {{ variable }} valor a pasar como un vector asociativo [ variable_html => valor] */
	$tpl->assignVar(["APP_SECTION" => "Login"]);

	$tpl->printToScreen();

 ?>