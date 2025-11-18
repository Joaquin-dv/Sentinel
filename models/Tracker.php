<?php 

	class Tracker extends DBAbstract
	{
		
		function __construct()
		{
			parent::__construct();
		}

		/**
		 * Obtiene ubicaciones de clientes sin repetir IP
		 */
		public function getClientsLocation(){
			$sql = "SELECT ip, latitud, longitud, COUNT(*) as cantidad_accesos 
					FROM sentinel__tracker 
					GROUP BY ip, latitud, longitud 
					ORDER BY cantidad_accesos DESC";
			
			return $this->query($sql);
		}


		/**
		 * Retorna la cantidad de clientes únicos
		 */
		public function getCantClientes(){
			return count($this->query("SELECT DISTINCT ip FROM sentinel__tracker"));
		}


		/**
		 * Registra acceso de cliente en tracker
		 */
		public function registrarAcceso(){
			$ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
			
			// Protección para IP local
			if($ip == "127.0.0.1"){
				$ip = "181.47.205.193";
			}

			// Obtener información de geolocalización
			$geoData = $this->getGeoData($ip);
			
			// Generar token cifrado
			$token = hash('sha256', uniqid() . $ip . time());
			
			// Insertar en tracker
			$sql = "INSERT INTO sentinel__tracker (token, ip, latitud, longitud, pais, navegador, sistema, add_date) VALUES ('".$token."', '".$ip."', '".$geoData['lat']."', '".$geoData['lng']."', '".$geoData['country']."', '".$geoData['browser']."', '".$geoData['os']."', NOW())";
			
			$this->query($sql);
		}


		/**
		 * Obtiene datos de geolocalización y navegador
		 */
		private function getGeoData($ip){
			// Consultar API de geolocalización
			$geoResponse = @file_get_contents("http://ipwho.is/".$ip);
			$geoData = $geoResponse ? json_decode($geoResponse, true) : null;
			
			// Obtener datos del navegador
			$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
			$os = $this->getOS($userAgent);
			$browser = $this->getBrowser($userAgent);
			
			return [
				'lat' => $geoData['latitude'] ?? '0',
				'lng' => $geoData['longitude'] ?? '0',
				'country' => $geoData['country'] ?? 'Unknown',
				'browser' => $browser,
				'os' => $os
			];
		}


		/**
		 * Detecta sistema operativo
		 */
		private function getOS($userAgent){
			if (preg_match('/windows/i', $userAgent)) return 'Windows';
			if (preg_match('/android/i', $userAgent)) return 'Android';
			if (preg_match('/linux/i', $userAgent)) return 'Linux';
			if (preg_match('/macintosh|mac os x/i', $userAgent)) return 'Mac';
			return 'Unknown';
		}


		/**
		 * Detecta navegador
		 */
		private function getBrowser($userAgent){
			if (preg_match('/firefox/i', $userAgent)) return 'Firefox';
			if (preg_match('/chrome/i', $userAgent)) return 'Chrome';
			if (preg_match('/safari/i', $userAgent)) return 'Safari';
			if (preg_match('/edge/i', $userAgent)) return 'Edge';
			return 'Unknown';
		}
	}

?>