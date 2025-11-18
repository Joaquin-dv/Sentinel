<?php

	require ".env.php";
	require "models/DBAbstract.php";
	require "models/Tracker.php";

	header('Content-Type: application/json');

	if(isset($_GET['list-clients-location'])){
		
		$tracker = new Tracker();
		$locations = $tracker->getClientsLocation();
		
		$response = [];
		foreach($locations as $location){
			$response[] = [
				'ip' => $location['ip'],
				'latitud' => $location['latitud'],
				'longitud' => $location['longitud'],
				'cantidad_accesos' => (int)$location['cantidad_accesos']
			];
		}
		
		echo json_encode($response);
		
	} else {
		echo json_encode(['error' => 'Parámetro no válido']);
	}

?>