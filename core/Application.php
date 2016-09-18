<?php
/**
 * Clase base para la applicacion
 */

/**
 * Clase base para la applicacion
 */
class Application {
	/**
	 * Inicia las metodos 
	 */
	function __construct() {
		$this->set_reporting();
		$this->remove_magic_quotes();
		$this->unregister_globals();
	}
	
	protected function generateToken( $formName ){
		if ( !session_id() ) {
			session_start();
		}
		$sessionId = session_id();
		return sha1( SECRETKEY.$formName.$sessionId);
	}	
	/**
	 * Muestra errores depndiendo del entorno
	 */
	private function set_reporting(){
		if (DEBUG) {
			error_reporting(E_ALL);
			ini_set('display_errors',1);
		} else {
			error_reporting(E_ALL);
			ini_set('display_errors',0);
			ini_set('log_errors', 1);
			ini_set('error_log', ERROR_PAHT);
		}
	}
	/**
	 * magic 
	 */
	private function strip_slashes_deep($value) {
		$value = is_array($value) ? array_map(array($this,'strip_slashes_deep'), $value) : stripslashes($value);
		return $value;
	}
	/**
	 * magic 
	 */	
	private function remove_magic_quotes() {
		if ( get_magic_quotes_gpc() ) {
			$_GET    = $this->strip_slashes_deep($_GET);
			$_POST   = $this->strip_slashes_deep($_POST);
			$_COOKIE = $this->strip_slashes_deep($_COOKIE);
		}
	}
	/**
	 * remueve glovales 
	 */	
	private function unregister_globals() {
		if (ini_get('register_globals')) {
			$array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
			foreach ($array as $value) {
				foreach ($GLOBALS[$value] as $key => $var) {
					if ($var === $GLOBALS[$key]) {
						unset($GLOBALS[$key]);
					}
				}
			}
		}
	}
}