<?php

	//Verifico si esta logueado el usuario
	if (isset($_SESSION['user'])) {
		header("Location: ?slug=panel");	
	}

	require_once 'models/Usuarios.php';

	$error = "";
	$errno = "";
	$success = false;

	$usuario = new Usuarios();

	if(isset($_GET["token"])){
		$result = $usuario->activateUser($_GET["token"]); 
		if($result["errno"] == 202){
			$message = '<div class="success-message"><h3>¡Cuenta Activada!</h3><p>Tu cuenta ha sido activada exitosamente. Ya puedes iniciar sesión.</p></div><a href="?slug=login" class="btn-login">Iniciar Sesión</a>';
		} else {
			$message = '<div class="error-message"><h3>Error de Activación</h3><p>'.$result["error"].'</p></div><a href="?slug=register" class="btn-login">Registrarse</a>';
		}
	} else {
		$message = '<div class="error-message"><h3>Error de Activación</h3><p>Token no proporcionado</p></div><a href="?slug=register" class="btn-login">Registrarse</a>';
	}

	$tpl = new Enano("validate");
	$tpl->assignVar(["APP_SECTION" => "Validate", "MESSAGE" => $message]);
	$tpl->printToScreen();

?>