<?php

	//Verifico si esta logueado el usuario
	if (isset($_SESSION['user'])) {
		header("Location: ?slug=panel");	
	}

	/**
	 * 
	 * Se incluyen las librerias
	 * Los modelos
	 * 
	 * */

	require_once 'models/Usuarios.php';



	$error = "";
	$errno = "";

	/**
	 * 
	 * Lógica
	 * 
	 * */

	$usuario = new Usuarios();

	if(isset($_POST["btn_register"])){

		$result = $usuario->register($_POST); 
		if($result["errno"] == 202){
			header("Location: ?slug=panel");
		}
		$error = $result["error"];
		$errno = $result["errno"];

	}

	/* Se instancia a la clase del motor de plantillas */
	$tpl = new Enano("register");

	$tpl->assignVar(["APP_SECTION" => "Register", "ERRNO" => $errno, "ERROR" => $error]);

	/* Imprime la plantilla en la página */
	$tpl->printToScreen();


 ?>