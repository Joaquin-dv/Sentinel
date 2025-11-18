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

	if(isset($_POST["btn_login"])){

		$result = $usuario->login($_POST); 
		if($result["errno"] == 202){
			header("Location: ?slug=panel");
		} else if($result["errno"] == 203){
			header("Location: ?slug=administrator");
		}
		$error = $result["error"];
		$errno = $result["errno"];

	}



	/***
	 * 
	 * Al final siempre se imprime la vista
	 * 
	 * */

	$tpl = new Enano("login");

	/*para asignar valor a las variables dentro la plantilla*/
	/* formato {{ variable }} valor a pasar como un vector asociativo [ variable_html => valor] */
	$tpl->assignVar(["APP_SECTION" => "Login", "ERRNO" => $errno, "ERROR" => $error]);

	$tpl->printToScreen();

 ?>