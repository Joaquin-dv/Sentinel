<?php

	//Verifico si esta logueado el usuario
	if (isset($_SESSION['user'])) {
		header("Location: ?slug=panel");	
	}

	require_once 'models/Usuarios.php';

	$error = "";
	$errno = "";
	$message = "";

	$usuario = new Usuarios();

	if(isset($_POST["btn_recovery"])){
		$result = $usuario->initiateRecovery($_POST); 
		$error = $result["error"];
		$errno = $result["errno"];
	}

	if($errno != ""){
		if($errno == "202"){
			$message = '<div style="background-color: #e8f5e8; color: #2e7d32; padding: 10px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #4caf50;">'.$error.'</div>';
		} else if($errno == "404"){
			$message = '<div style="background-color: #ffebee; color: #c62828; padding: 10px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #ef5350;">'.$error.' <a href="?slug=register">Registrarse</a></div>';
		} else {
			$message = '<div style="background-color: #ffebee; color: #c62828; padding: 10px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #ef5350;">'.$error.'</div>';
		}
	}

	$form_content = '<form action="" method="POST"><input type="email" name="txt_email" placeholder="Correo electrónico" required><button type="submit" name="btn_recovery">Enviar</button></form>';

	$tpl = new Enano("recovery");
	$tpl->assignVar(["APP_SECTION" => "Recovery", "MESSAGE" => $message, "FORM_CONTENT" => $form_content]);
	$tpl->printToScreen();

?>