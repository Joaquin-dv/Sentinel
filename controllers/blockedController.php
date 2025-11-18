<?php

	require_once 'models/Usuarios.php';

	$error = "";
	$errno = "";
	$success = false;

	$usuario = new Usuarios();

	if(isset($_GET["token"])){
		$result = $usuario->blockUser($_GET["token"]); 
		if($result["errno"] == 202){
			$success = true;
		}
		$error = $result["error"];
		$errno = $result["errno"];
	} else {
		$error = "Token no proporcionado";
		$errno = "400";
	}

	if($success) {
		$message = '<div class="success-message"><h3>¡Cuenta Bloqueada!</h3><p>Tu cuenta ha sido bloqueada por seguridad. Revisa tu email para instrucciones de recuperación.</p></div><a href="?slug=login" class="btn-login">Ir al Login</a>';
	} else {
		$message = '<div class="error-message"><h3>Error de Bloqueo</h3><p>'.$error.'</p></div><a href="?slug=login" class="btn-login">Ir al Login</a>';
	}

	$tpl = new Enano("blocked");
	$tpl->assignVar(["APP_SECTION" => "Blocked", "MESSAGE" => $message]);
	$tpl->printToScreen();

?>