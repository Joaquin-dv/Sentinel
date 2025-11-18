<?php

	require_once 'models/Usuarios.php';
	require_once 'models/Tracker.php';

	// Verificar si está logueado como admin
	if(!isset($_SESSION['admin'])){
		header("Location: ?slug=login");
		exit();
	}
	$usuario = new Usuarios();
	$tracker = new Tracker();

	$cant_usuarios = $usuario->getCantUsuarios();
	$cant_clientes = $tracker->getCantClientes();

	$tpl = new Enano("administrator");
	$tpl->assignVar([
		"APP_SECTION" => "Administrator", 
		"CANT_USUARIOS" => $cant_usuarios,
		"CANT_CLIENTES" => $cant_clientes
	]);
	$tpl->printToScreen();

?>