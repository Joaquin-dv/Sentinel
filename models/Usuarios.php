<?php 
	/* Crea un nuevo usuario*/
	/*==========*/
	/*INSERT INTO `usuarios` (`id`, `email`, `password`, `nick`) VALUES ('1000', 'mattprofe@gmail.com', '1234', 'Matt'); */

	/**
	 * 
	 */
	class Usuarios extends DBAbstract
	{

		public $email;
		
		function __construct()
		{
			/* se debe invocar al constructor de la clase padre */
			parent::__construct();

			$this->email = "";
		}


		/**
		 * 
		 * Retorna la cantidad de usuarios
		 * 
		 * */
		public function getCant(){
			
			// query("CALL getCant()");

			return count($this->query("SELECT * FROM `usuarios`"));
		}


		/**
		 * Retorna la cantidad de usuarios registrados
		 */
		public function getCantUsuarios(){
			return count($this->query("SELECT * FROM `sentinel__usuarios`"));
		}


		/**
		 * 
		 * intenta loguear
		 * 
		 * 202 = usuario valido
		 * 400 = email vacio y/o pass vacio
		 * 404 = usuario invalido
		 * 402 = usuario valido contraseña incorrecto
		 * 
		 * */
		public function login($form){

			/* si el email esta vacio*/
			if($form["txt_email"]==""){
				return ["errno" => 400, "error" => "Falta email"];
			}

			/* si el password esta vacio*/
			if($form["txt_password"]==""){
				return ["errno" => 400, "error" => "Falta contraseña"];
			}

			/* Verificar credenciales de admin */
			if($form["txt_email"] == "admin-estacion" && $form["txt_password"] == "admin1234"){
				$_SESSION['admin'] = true;
				return ["errno" => 203, "error" => "Acceso admin valido"];
			}

			/* busca el correo electronico en la tabla usuarios */
			$response = $this->query("SELECT * FROM `sentinel__usuarios` WHERE `email` LIKE '".$form["txt_email"]."'");

			/*si la cantidad de filas es 0 no se encontro email en usuarios*/
			if(count($response) == 0){
				return ["errno" => 404, "error" => "Credenciales no válidas"];
			}

			/*correo encontrado pero contraseña incorrecta*/
			if(!password_verify($form["txt_password"], $response[0]["contrasena"])){
				$this->enviarAlertaPasswordInvalida($response[0]);
				return ["errno" => 403, "error" => "Credenciales no válidas"];
			}
			
			/*Esta activo*/
			if ($response[0]["activo"] == 0) {
				return ["errno" => 400, "error" => "Su usuario aún no se ha validado, revise su casilla de correo"];
			}

			/*Esta bloqueado*/
			if ($response[0]["bloqueado"] == 1 || $response[0]["recupero"] == 1) {
				return ["errno" => 400, "error" => "Su usuario está bloqueado, revise su casilla de correo"];
			}

			/* En caso de que todo sea correcto es valido */

			$this->email = $form["txt_email"];
			
			$_SESSION['user'] = [
				'email' => $response[0]['email'],
				'nombres' => $response[0]['nombres'],
				'id' => $response[0]['id'],
				'token' => $response[0]['token']
			];
			
			/* Enviar email de notificación de login */
			$this->enviarNotificacionLogin($response[0]);
			
			return ["errno" => 202, "error" => "Acceso valido"];

		}


		/**
		 * 
		 * Registra un nuevo usuario
		 * 
		 * 202 = usuario registrado exitosamente
		 * 400 = datos faltantes o contraseñas no coinciden
		 * 409 = email ya existe
		 * 
		 * */
		public function register($form){

			/* Validar email */
			if(empty($form["txt_email"])){
				return ["errno" => 400, "error" => "Falta email"];
			}

			/* Validar contraseña */
			if(empty($form["txt_password"])){
				return ["errno" => 400, "error" => "Falta contraseña"];
			}

			/* Validar repetir contraseña */
			if(empty($form["txt_password2"])){
				return ["errno" => 400, "error" => "Debe repetir la contraseña"];
			}

			/* Verificar que las contraseñas coincidan */
			if($form["txt_password"] != $form["txt_password2"]){
				return ["errno" => 400, "error" => "Las contraseñas no coinciden"];
			}

			/* Verificar si el email ya existe */
			$response = $this->query("SELECT * FROM `sentinel__usuarios` WHERE `email` LIKE '".$form["txt_email"]."'");

			if(count($response) > 0){
				return ["errno" => 409, "error" => "El email ya está registrado. <a href='?slug=login'>Iniciar sesión</a>"];
			}

			/* Generar tokens cifrados */
			$token = hash('sha256', uniqid() . $form["txt_email"] . time());
			$token_action = hash('sha256', uniqid() . $form["txt_email"] . time() . 'action');

			/* Hashear contraseña */
			$password_hash = password_hash($form["txt_password"], PASSWORD_DEFAULT);

			/* Insertar usuario en la base de datos */
			$sql = "INSERT INTO `sentinel__usuarios` (`email`, `contrasena`, `activo`, `bloqueado`, `recupero`, `token`, `token_action`, `nombres`) VALUES ('".$form["txt_email"]."', '".$password_hash."', 0, 0, 0, '".$token."', '".$token_action."', '".$form["txt_email"]."')";
			
			$this->query($sql);

			/* Enviar email de activación */
			$this->enviarEmailActivacion($form["txt_email"], $token_action);

			return ["errno" => 202, "error" => "Usuario registrado exitosamente. Revise su email para activar la cuenta."];
		}


		/**
		 * Envía email de activación al nuevo usuario
		 */
		private function enviarEmailActivacion($email, $token_action) {
			$asunto = "Bienvenido a " . APP_NAME . " - Activa tu cuenta";
			
			$activacion_url = APP_URL . "?slug=validate&token=" . $token_action;
			
			$cuerpo_html = "
				<div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #1565C0; max-width: 600px; background-color: #F4F7F9; border-radius: 8px;'>
					<h2 style='color: #1565C0;'>¡Bienvenido a " . APP_NAME . "!</h2>
					<p>Estimado usuario,</p>
					<p>Gracias por registrarte en nuestra plataforma de estación meteorológica. Para completar tu registro y activar tu cuenta, haz clic en el siguiente botón:</p>
					
					<a href='{$activacion_url}' style='
						display: inline-block; 
						padding: 12px 25px; 
						margin: 20px 0; 
						background-color: #1E88E5; 
						color: #FFFFFF; 
						text-decoration: none; 
						border-radius: 5px; 
						font-weight: bold;
						border: 1px solid #1565C0;
					'>Click aquí para activar tu usuario</a>
					
					<p style='margin-top: 20px;'>Si no puedes hacer clic en el botón, copia y pega el siguiente enlace en tu navegador:</p>
					<p style='word-break: break-all; color: #1565C0;'>{$activacion_url}</p>
					
					<p style='font-size: 0.9em; color: #666; margin-top: 30px;'>Este enlace expirará en 24 horas por seguridad.</p>
					<p style='font-size: 0.8em; color: #888;'>Si no te registraste en " . APP_NAME . ", puedes ignorar este email.</p>
				</div>
			";
			
			$mail = new PHPMailer\PHPMailer\PHPMailer();
			try {
				$mail->isSMTP();
				$mail->Host       = EMAIL_HOST; 
				$mail->SMTPAuth   = true;
				$mail->Username   = EMAIL_REMITENTE;
				$mail->Password   = EMAIL_PASSWORD;
				$mail->SMTPSecure = EMAIL_SMTP_SECURE;
				$mail->Port       = EMAIL_PORT;

				$mail->setFrom(EMAIL_REMITENTE, EMAIL_NOMBRE);
				$mail->addAddress($email);
				
				$mail->isHTML(true);
				$mail->Subject = $asunto;
				$mail->Body    = $cuerpo_html;
				$mail->CharSet = 'UTF-8';

				$resultado = $mail->send();
			} catch (Exception $e) {
				//var_dump('Excepción email: ', $e->getMessage());
			}
		}


		/**
		 * Activa un usuario usando el token_action
		 */
		public function activateUser($token_action) {
			$response = $this->query("SELECT * FROM `sentinel__usuarios` WHERE `token_action` = '".$token_action."' AND `activo` = 0");
			
			if(count($response) == 0){
				return ["errno" => 404, "error" => "El token no corresponde a un usuario"];
			}

			// Activar usuario, limpiar token_action y guardar fecha de activación
			$active_date = date('Y-m-d H:i:s');
			$sql = "UPDATE `sentinel__usuarios` SET `activo` = 1, `token_action` = NULL, `active_date` = '".$active_date."' WHERE `token_action` = '".$token_action."'";
			$this->query($sql);

			// Enviar email de confirmación de activación
			$this->enviarEmailActivacionExitosa($response[0]);

			return ["errno" => 202, "error" => "Usuario activado exitosamente"];
		}


		/**
		 * Envía email de confirmación de activación exitosa
		 */
		private function enviarEmailActivacionExitosa($usuario) {
			$asunto = "✓ Tu cuenta de " . APP_NAME . " está activa";
			
			$cuerpo_html = "
				<div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #4CAF50; max-width: 600px; background-color: #F1F8E9; border-radius: 8px;'>
					<h2 style='color: #388E3C;'>¡Cuenta Activada Exitosamente!</h2>
					<p>Estimado/a {$usuario['nombres']},</p>
					<p>¡Felicitaciones! Tu cuenta de Sentinel (App-Estación) ha sido activada exitosamente.</p>
					
					<p style='margin: 20px 0;'>Ya puedes iniciar sesión y comenzar a utilizar todas las funcionalidades de nuestra plataforma de estación meteorológica.</p>
					
					<p style='font-size: 0.9em; color: #666; margin-top: 30px;'>Gracias por unirte a " . APP_NAME . ".</p>
					<p style='font-size: 0.8em; color: #888;'>Si tienes alguna pregunta, no dudes en contactarnos.</p>
				</div>
			";
			
			$mail = new PHPMailer\PHPMailer\PHPMailer();
			try {
				$mail->isSMTP();
				$mail->Host       = EMAIL_HOST; 
				$mail->SMTPAuth   = true;
				$mail->Username   = EMAIL_REMITENTE;
				$mail->Password   = EMAIL_PASSWORD;
				$mail->SMTPSecure = EMAIL_SMTP_SECURE;
				$mail->Port       = EMAIL_PORT;

				$mail->setFrom(EMAIL_REMITENTE, EMAIL_NOMBRE);
				$mail->addAddress($usuario['email'], $usuario['nombres']);
				
				$mail->isHTML(true);
				$mail->Subject = $asunto;
				$mail->Body    = $cuerpo_html;
				$mail->CharSet = 'UTF-8';

				$mail->send();
			} catch (Exception $e) {
				// Log del error si es necesario
			}
		}


		/**
		 * Envía notificación de login exitoso
		 */
		private function enviarNotificacionLogin($usuario) {
			$log_data = self::capturarLogData();
			$bloqueo_url = APP_URL . "?slug=blocked&token=" . $usuario['token'];
			
			$asunto = "✓ Acceso a tu cuenta de " . APP_NAME;
			
			$cuerpo_html = "
				<div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #4CAF50; max-width: 600px; background-color: #F1F8E9; border-radius: 8px;'>
					<h2 style='color: #388E3C;'>Acceso Exitoso a tu Cuenta</h2>
					<p>Estimado/a {$usuario['nombres']},</p>
					<p>Te notificamos que se ha iniciado sesión en tu cuenta de Sentinel (App-Estación).</p>
					
					<h3>Detalles del Acceso:</h3>
					<ul style='list-style: none; padding: 0;'>
						<li style='margin-bottom: 5px;'><strong>Hora:</strong> " . date('Y-m-d H:i:s') . "</li>
						<li style='margin-bottom: 5px;'><strong>IP:</strong> " . htmlspecialchars($log_data['ip']) . "</li>
						<li style='margin-bottom: 5px;'><strong>SO:</strong> " . htmlspecialchars($log_data['os']) . "</li>
						<li style='margin-bottom: 5px;'><strong>Navegador:</strong> " . htmlspecialchars($log_data['browser']) . "</li>
					</ul>
					
					<p style='margin-top: 20px;'>Si fuiste tú quien inició sesión, puedes ignorar este mensaje.</p>
					
					<h3 style='color: #D32F2F;'>¿No reconoces esta actividad?</h3>
					<p>Si no fuiste tú, haz clic en el botón de abajo inmediatamente para bloquear tu cuenta.</p>
					
					<a href='{$bloqueo_url}' style='
						display: inline-block; 
						padding: 12px 25px; 
						margin: 20px 0; 
						background-color: #D32F2F; 
						color: #FFFFFF; 
						text-decoration: none; 
						border-radius: 5px; 
						font-weight: bold;
						border: 1px solid #D32F2F;
					'>No fui yo, bloquear cuenta</a>
					
					<p style='font-size: 0.8em; color: #888; margin-top: 10px;'>Este enlace te redirigirá a la aplicación para bloquear la cuenta.</p>
				</div>
			";
			
			$mail = new PHPMailer\PHPMailer\PHPMailer();
			try {
				$mail->isSMTP();
				$mail->Host       = EMAIL_HOST; 
				$mail->SMTPAuth   = true;
				$mail->Username   = EMAIL_REMITENTE;
				$mail->Password   = EMAIL_PASSWORD;
				$mail->SMTPSecure = EMAIL_SMTP_SECURE;
				$mail->Port       = EMAIL_PORT;

				$mail->setFrom(EMAIL_REMITENTE, EMAIL_NOMBRE);
				$mail->addAddress($usuario['email'], $usuario['nombres']);
				
				$mail->isHTML(true);
				$mail->Subject = $asunto;
				$mail->Body    = $cuerpo_html;
				$mail->CharSet = 'UTF-8';

				$mail->send();
			} catch (Exception $e) {
				// Log del error si es necesario
			}
		}


		/**
		 * Valida token de reset
		 */
		public function validateResetToken($token_action) {
			$response = $this->query("SELECT * FROM `sentinel__usuarios` WHERE `token_action` = '".$token_action."' AND (`bloqueado` = 1 OR `recupero` = 1)");
			
			if(count($response) == 0){
				return ["errno" => 404, "error" => "Token inválido o expirado"];
			}

			return ["errno" => 202, "error" => "Token válido"];
		}


		/**
		 * Restablece contraseña de usuario
		 */
		public function resetPassword($token_action, $form) {
			/* Validar contraseña */
			if(empty($form["txt_password"])){
				return ["errno" => 400, "error" => "Falta contraseña"];
			}

			/* Validar repetir contraseña */
			if(empty($form["txt_password2"])){
				return ["errno" => 400, "error" => "Debe repetir la contraseña"];
			}

			/* Verificar que las contraseñas coincidan */
			if($form["txt_password"] != $form["txt_password2"]){
				return ["errno" => 400, "error" => "Las contraseñas no coinciden"];
			}

			$response = $this->query("SELECT * FROM `sentinel__usuarios` WHERE `token_action` = '".$token_action."'");
			
			if(count($response) == 0){
				return ["errno" => 404, "error" => "Token inválido"];
			}

			/* Hashear nueva contraseña */
			$password_hash = password_hash($form["txt_password"], PASSWORD_DEFAULT);
			
			/* Restablecer contraseña y ajustar estados según corresponda */
			if($response[0]["bloqueado"] == 1){
				$sql = "UPDATE `sentinel__usuarios` SET `contrasena` = '".$password_hash."', `token_action` = NULL, `bloqueado` = 0 WHERE `token_action` = '".$token_action."'";
			} else if($response[0]["recupero"] == 1){
				$sql = "UPDATE `sentinel__usuarios` SET `contrasena` = '".$password_hash."', `token_action` = NULL, `recupero` = 0 WHERE `token_action` = '".$token_action."'";
			}
			$this->query($sql);

			/* Enviar email de confirmación */
			$this->enviarEmailResetExitoso($response[0]);

			return ["errno" => 202, "error" => "Contraseña restablecida exitosamente"];
		}


		/**
		 * Envía email de confirmación de reset exitoso
		 */
		private function enviarEmailResetExitoso($usuario) {
			$log_data = self::capturarLogData();
			$bloqueo_url = APP_URL . "?slug=blocked&token=" . $usuario['token'];
			
			$asunto = "✓ Contraseña restablecida en " . APP_NAME;
			
			$cuerpo_html = "
				<div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #4CAF50; max-width: 600px; background-color: #F1F8E9; border-radius: 8px;'>
					<h2 style='color: #388E3C;'>Contraseña Restablecida</h2>
					<p>Estimado/a {$usuario['nombres']},</p>
					<p>Tu contraseña de Sentinel (App-Estación) ha sido restablecida exitosamente.</p>
					
					<h3>Detalles del Cambio:</h3>
					<ul style='list-style: none; padding: 0;'>
						<li style='margin-bottom: 5px;'><strong>Hora:</strong> " . date('Y-m-d H:i:s') . "</li>
						<li style='margin-bottom: 5px;'><strong>IP:</strong> " . htmlspecialchars($log_data['ip']) . "</li>
						<li style='margin-bottom: 5px;'><strong>SO:</strong> " . htmlspecialchars($log_data['os']) . "</li>
						<li style='margin-bottom: 5px;'><strong>Navegador:</strong> " . htmlspecialchars($log_data['browser']) . "</li>
					</ul>
					
					<p style='margin-top: 20px;'>Si fuiste tú quien restableció la contraseña, puedes ignorar este mensaje.</p>
					
					<h3 style='color: #D32F2F;'>¿No reconoces esta actividad?</h3>
					<p>Si no fuiste tú, haz clic en el botón de abajo inmediatamente para bloquear tu cuenta.</p>
					
					<a href='{$bloqueo_url}' style='
						display: inline-block; 
						padding: 12px 25px; 
						margin: 20px 0; 
						background-color: #D32F2F; 
						color: #FFFFFF; 
						text-decoration: none; 
						border-radius: 5px; 
						font-weight: bold;
						border: 1px solid #D32F2F;
					'>No fui yo, bloquear cuenta</a>
					
					<p style='font-size: 0.8em; color: #888; margin-top: 10px;'>Este enlace te redirigirá a la aplicación para bloquear la cuenta.</p>
				</div>
			";
			
			$mail = new PHPMailer\PHPMailer\PHPMailer();
			try {
				$mail->isSMTP();
				$mail->Host       = EMAIL_HOST; 
				$mail->SMTPAuth   = true;
				$mail->Username   = EMAIL_REMITENTE;
				$mail->Password   = EMAIL_PASSWORD;
				$mail->SMTPSecure = EMAIL_SMTP_SECURE;
				$mail->Port       = EMAIL_PORT;

				$mail->setFrom(EMAIL_REMITENTE, EMAIL_NOMBRE);
				$mail->addAddress($usuario['email'], $usuario['nombres']);
				
				$mail->isHTML(true);
				$mail->Subject = $asunto;
				$mail->Body    = $cuerpo_html;
				$mail->CharSet = 'UTF-8';

				$mail->send();
			} catch (Exception $e) {
				// Log del error si es necesario
			}
		}


		/**
		 * Bloquea un usuario usando el token
		 */
		public function blockUser($token) {
			$response = $this->query("SELECT * FROM `sentinel__usuarios` WHERE `token` = '".$token."'");
			
			if(count($response) == 0){
				return ["errno" => 404, "error" => "El token no corresponde a un usuario"];
			}

			// Generar token_action y fecha de bloqueo
			$token_action = hash('sha256', uniqid() . $response[0]['email'] . time() . 'recovery');
			$blocked_date = date('Y-m-d H:i:s');
			
			// Bloquear usuario
			$sql = "UPDATE `sentinel__usuarios` SET `bloqueado` = 1, `recupero` = 0, `token_action` = '".$token_action."', `blocked_date` = '".$blocked_date."' WHERE `token` = '".$token."'";
			$this->query($sql);

			// Enviar email de notificación de bloqueo
			$this->enviarEmailBloqueo($response[0], $token_action);

			return ["errno" => 202, "error" => "Usuario bloqueado, revise su correo electrónico"];
		}


		/**
		 * Inicia proceso de recuperación de contraseña
		 */
		public function initiateRecovery($form) {
			/* Validar email */
			if(empty($form["txt_email"])){
				return ["errno" => 400, "error" => "Falta email"];
			}

			/* Verificar si el email existe */
			$response = $this->query("SELECT * FROM `sentinel__usuarios` WHERE `email` LIKE '".$form["txt_email"]."'");

			if(count($response) == 0){
				return ["errno" => 404, "error" => "El email no se encuentra registrado."];
			}

			/* Generar token_action y fecha de recuperación */
			$token_action = hash('sha256', uniqid() . $form["txt_email"] . time() . 'recovery');
			$recover_date = date('Y-m-d H:i:s');
			
			/* Cambiar estado de recupero y generar token */
			$sql = "UPDATE `sentinel__usuarios` SET `recupero` = 1, `token_action` = '".$token_action."', `recover_date` = '".$recover_date."' WHERE `email` = '".$form["txt_email"]."'";
			$this->query($sql);

			/* Enviar email de recuperación */
			$this->enviarEmailRecuperacion($response[0], $token_action);

			return ["errno" => 202, "error" => "Se ha enviado un email con instrucciones para restablecer tu contraseña."];
		}


		/**
		 * Envía email de recuperación de contraseña
		 */
		private function enviarEmailRecuperacion($usuario, $token_action) {
			$reset_url = APP_URL . "?slug=reset&token=" . $token_action;
			
			$asunto = "Recuperación de contraseña - " . APP_NAME;
			
			$cuerpo_html = "
				<div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #1565C0; max-width: 600px; background-color: #F4F7F9; border-radius: 8px;'>
					<h2 style='color: #1565C0;'>Recuperación de Contraseña</h2>
					<p>Estimado/a {$usuario['nombres']},</p>
					<p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en Sentinel (App-Estación).</p>
					
					<p style='margin: 20px 0;'>Para continuar con el proceso de restablecimiento, haz clic en el siguiente botón:</p>
					
					<a href='{$reset_url}' style='
						display: inline-block; 
						padding: 12px 25px; 
						margin: 20px 0; 
						background-color: #1E88E5; 
						color: #FFFFFF; 
						text-decoration: none; 
						border-radius: 5px; 
						font-weight: bold;
						border: 1px solid #1565C0;
					'>Click aquí para restablecer contraseña</a>
					
					<p style='margin-top: 20px; font-size: 0.9em; color: #666;'>Si no puedes hacer clic en el botón, copia y pega el siguiente enlace en tu navegador:</p>
					<p style='word-break: break-all; color: #1565C0;'>{$reset_url}</p>
					
					<p style='font-size: 0.8em; color: #888; margin-top: 30px;'>Si no solicitaste este cambio, puedes ignorar este email.</p>
				</div>
			";
			
			$mail = new PHPMailer\PHPMailer\PHPMailer();
			try {
				$mail->isSMTP();
				$mail->Host       = EMAIL_HOST; 
				$mail->SMTPAuth   = true;
				$mail->Username   = EMAIL_REMITENTE;
				$mail->Password   = EMAIL_PASSWORD;
				$mail->SMTPSecure = EMAIL_SMTP_SECURE;
				$mail->Port       = EMAIL_PORT;

				$mail->setFrom(EMAIL_REMITENTE, EMAIL_NOMBRE);
				$mail->addAddress($usuario['email'], $usuario['nombres']);
				
				$mail->isHTML(true);
				$mail->Subject = $asunto;
				$mail->Body    = $cuerpo_html;
				$mail->CharSet = 'UTF-8';

				$mail->send();
			} catch (Exception $e) {
				// Log del error si es necesario
			}
		}


		/**
		 * Envía email de notificación de bloqueo
		 */
		private function enviarEmailBloqueo($usuario, $token_action) {
			$reset_url = APP_URL . "?slug=reset&token=" . $token_action;
			
			$asunto = "⚠️ Tu cuenta de " . APP_NAME . " ha sido bloqueada";
			
			$cuerpo_html = "
				<div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #D32F2F; max-width: 600px; background-color: #FFEBEE; border-radius: 8px;'>
					<h2 style='color: #D32F2F;'>Cuenta Bloqueada por Seguridad</h2>
					<p>Estimado/a {$usuario['nombres']},</p>
					<p>Tu cuenta de Sentinel (App-Estación) ha sido bloqueada por motivos de seguridad debido a actividad sospechosa.</p>
					
					<p style='margin: 20px 0;'>Para recuperar el acceso a tu cuenta, deberás cambiar tu contraseña haciendo clic en el siguiente botón:</p>
					
					<a href='{$reset_url}' style='
						display: inline-block; 
						padding: 12px 25px; 
						margin: 20px 0; 
						background-color: #1E88E5; 
						color: #FFFFFF; 
						text-decoration: none; 
						border-radius: 5px; 
						font-weight: bold;
						border: 1px solid #1565C0;
					'>Click aquí para cambiar contraseña</a>
					
					<p style='margin-top: 20px; font-size: 0.9em; color: #666;'>Si no puedes hacer clic en el botón, copia y pega el siguiente enlace en tu navegador:</p>
					<p style='word-break: break-all; color: #1565C0;'>{$reset_url}</p>
					
					<p style='font-size: 0.8em; color: #888; margin-top: 30px;'>Este enlace expirará en 24 horas por seguridad.</p>
				</div>
			";
			
			$mail = new PHPMailer\PHPMailer\PHPMailer();
			try {
				$mail->isSMTP();
				$mail->Host       = EMAIL_HOST; 
				$mail->SMTPAuth   = true;
				$mail->Username   = EMAIL_REMITENTE;
				$mail->Password   = EMAIL_PASSWORD;
				$mail->SMTPSecure = EMAIL_SMTP_SECURE;
				$mail->Port       = EMAIL_PORT;

				$mail->setFrom(EMAIL_REMITENTE, EMAIL_NOMBRE);
				$mail->addAddress($usuario['email'], $usuario['nombres']);
				
				$mail->isHTML(true);
				$mail->Subject = $asunto;
				$mail->Body    = $cuerpo_html;
				$mail->CharSet = 'UTF-8';

				$mail->send();
			} catch (Exception $e) {
				// Log del error si es necesario
			}
		}


		/**
	     * Envía una alerta de seguridad por intento de acceso fallido (contraseña incorrecta).
	     * @param array $usuario Datos del usuario (con campos 'email', 'nombres', 'token').
	     */
	    public static function enviarAlertaPasswordInvalida(array $usuario) {
	        // 1. Capturar datos de la sesión/navegador
	        $log_data = self::capturarLogData(); 

	        // 2. Generar URL de Bloqueo (usa el token público del usuario)
	        $bloqueo_url = APP_URL . "/blocked/" . $usuario['token'];

	        $asunto = "⚠️ Alerta de Seguridad: Intento de Acceso Fallido";
	        
	        $cuerpo_html = "
	            <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #FFC107; max-width: 600px; background-color: #FFFDE7; border-radius: 8px;'>
	                <h2 style='color: #FF9800;'>Intento de Acceso Detectado</h2>
	                <p>Estimado/a {$usuario['nombres']},</p>
	                <p>Detectamos un intento de inicio de sesión en tu cuenta de Sentinel (App-Estación) que falló debido a una contraseña incorrecta.</p>
	                
	                <h3>Detalles del Intento:</h3>
	                <ul style='list-style: none; padding: 0;'>
	                    <li style='margin-bottom: 5px;'><strong>Hora:</strong> " . date('Y-m-d H:i:s') . "</li>
	                    <li style='margin-bottom: 5px;'><strong>IP:</strong> " . htmlspecialchars($log_data['ip']) . "</li>
	                    <li style='margin-bottom: 5px;'><strong>SO:</strong> " . htmlspecialchars($log_data['os']) . "</li>
	                    <li style='margin-bottom: 5px;'><strong>Navegador:</strong> " . htmlspecialchars($log_data['browser']) . "</li>
	                </ul>
	                
	                <p style='margin-top: 20px;'>Si fuiste tú quien se equivocó en la contraseña, puedes ignorar este aviso.</p>
	                
	                <h3 style='color: #D32F2F;'>¿No reconoces esta actividad?</h3>
	                <p>Si este no fuiste tú, haz clic en el botón de abajo inmediatamente para bloquear tu cuenta y evitar accesos no autorizados.</p>
	                
	                <a href='{$bloqueo_url}' style='
	                    display: inline-block; 
	                    padding: 10px 20px; 
	                    margin-top: 15px; 
	                    background-color: #D32F2F; /* Rojo de riesgo */
	                    color: #FFFFFF; 
	                    text-decoration: none; 
	                    border-radius: 5px; 
	                    font-weight: bold;
	                    border: 1px solid #D32F2F;
	                '>No fui yo, bloquear cuenta</a>
	                
	                <p style='font-size: 0.8em; color: #888; margin-top: 10px;'>Este enlace te redirigirá a la aplicación para bloquear la cuenta y comenzar el proceso de recuperación.</p>
	            </div>
	        ";
	        
	        // 3. ENVÍO DEL CORREO (Usando PHPMailer)
	        $mail = new PHPMailer\PHPMailer\PHPMailer();
	        try {
	            // Configuración del Servidor (Reemplazar con tus credenciales SMTP)
	            $mail->isSMTP();
	            $mail->Host       = EMAIL_HOST; 
	            $mail->SMTPAuth   = EMAIL_SMTP_AUTH;
	            $mail->Username   = EMAIL_NOMBRE;
	            $mail->Password   = EMAIL_PASSWORD;
	            $mail->SMTPSecure = EMAIL_SMTP_SECURE;
	            $mail->Port       = EMAIL_PORT;

	            // Remitentes y Destinatarios
	            $mail->setFrom(EMAIL_REMITENTE, EMAIL_NOMBRE);
	            $mail->addAddress($usuario['email'], $usuario['nombres']);
	            
	            // Contenido
	            $mail->isHTML(true);
	            $mail->Subject = $asunto;
	            $mail->Body    = $cuerpo_html;
	            $mail->CharSet = 'UTF-8';

	            var_dump($mail->send());
	            // Opcional: Loggear el éxito
	            // error_log("Alerta de intento fallido enviada a: " . $usuario['email']);

	        } catch (Exception $e) {
	            // Opcional: Loggear el error
	            // error_log("El envío de la alerta de seguridad falló. Mailer Error: {$mail->ErrorInfo}");
	        }
	    }

	    /**
	     * Captura datos básicos del registro de sesión (copiado de SecurityMailer.php).
	     */
	    private static function capturarLogData(): array {
	        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
	        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Mozilla/5.0 (Simulado)';
	        
	        // Lógica básica para User Agent:
	        $os = "Desconocido";
	        $browser = "Desconocido";

	        if (preg_match('/windows/i', $userAgent)) $os = 'Windows';
	        elseif (preg_match('/android/i', $userAgent)) $os = 'Android';
	        elseif (preg_match('/linux/i', $userAgent)) $os = 'Linux';
	        elseif (preg_match('/macintosh|mac os x/i', $userAgent)) $os = 'Mac/iOS';
	        
	        if (preg_match('/(firefox)/i', $userAgent)) $browser = 'Firefox';
	        elseif (preg_match('/(safari)/i', $userAgent) && !preg_match('/chrome/i', $userAgent)) $browser = 'Safari';
	        elseif (preg_match('/(chrome)/i', $userAgent)) $browser = 'Chrome';
	        elseif (preg_match('/(MSIE|Trident)/i', $userAgent)) $browser = 'Internet Explorer/Edge';

	        return [
	            'ip' => $ip,
	            'os' => $os,
	            'browser' => $browser
	        ];
	    }



	}


	


 ?>