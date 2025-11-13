<?php 


	include '../.env.php';
	
	$vector_variables = ["APP_NAME", "APP_AUTHOR"];


	/*foreach ($vector_variables as $key => $value) {
		var_dump($value);
	}*/

	$bolsa = "APP_NAME";
	

	var_dump(constant($bolsa));
	


 ?>