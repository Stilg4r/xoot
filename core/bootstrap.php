<?php
/**
 * Iniciador de la aplicacion
 */

/**
 * carga la configuracion y la funcionos golvales
 */
require_once('config'. DS . 'config.php');
require_once('core' . DS . 'functions.php');
/**
 * Carga automatica de clases 
 * @param  string $className nombre de la clase
 */
function autoload($className) {
	if (file_exists(ROOT . DS .'core' . DS . ($className) . '.php')) {
        require_once(ROOT . DS .'core' . DS . ($className) . '.php');
    } 
	else if (file_exists(ROOT . DS .'application' . DS . 'controllers' . DS . ($className) . '.php')) {
        require_once(ROOT . DS .'application' . DS . 'controllers' . DS . ($className) . '.php');
    }
	else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . $className . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'models' . DS . $className . '.php');
	}
}
spl_autoload_register('autoload');
/**
 * Enruta la peticion al contrador adecuado
 */
Router::route($url);