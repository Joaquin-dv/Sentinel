<?php

	//Verifico si esta logueado el usuario, pero permito acceso si hay token válido
	if (isset($_SESSION['user']) && !isset($_GET['token'])) {
		header("Location: ?slug=panel");	
	}

	require_once 'models/Usuarios.php';

	$error = "";
	$errno = "";
	$token_valid = false;
	$show_form = false;

	$usuario = new Usuarios();

	$error_message = "";
	$form_content = "";

	// Verificar token
	if(isset($_GET["token"])){
		$token_result = $usuario->validateResetToken($_GET["token"]);
		if($token_result["errno"] == 202){
			$token_valid = true;
			$form_content = '<form action="" method="POST"><input type="password" name="txt_password" placeholder="Nueva contraseña" required><input type="password" name="txt_password2" placeholder="Repetir contraseña" required><button type="submit" name="btn_reset">Restablecer Contraseña</button></form>';
		} else {
			$error_message = '<div class="error-message">'.$token_result["error"].'</div>';
		}
	} else {
		$error_message = '<div class="error-message">Token no proporcionado</div>';
	}

	// Procesar formulario
	if(isset($_POST["btn_reset"]) && $token_valid){
		$result = $usuario->resetPassword($_GET["token"], $_POST); 
		if($result["errno"] == 202){
			session_destroy();
			header("Location: ?slug=login");
			exit();
		}
		$error_message = '<div class="error-message">'.$result["error"].'</div>';
		$form_content = '<form action="" method="POST"><input type="password" name="txt_password" placeholder="Nueva contraseña" required><input type="password" name="txt_password2" placeholder="Repetir contraseña" required><button type="submit" name="btn_reset">Restablecer Contraseña</button></form>';
	}

	$tpl = new Enano("reset");
	$tpl->assignVar(["APP_SECTION" => "Reset", "ERROR_MESSAGE" => $error_message, "FORM_CONTENT" => $form_content]);
	$tpl->printToScreen();

?>