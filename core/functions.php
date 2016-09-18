<?php
/**
 * Funciones glovales
 */

/**
 * Funcion de carga de biblotecas
 */
function load_lib($lib){
	if (file_exists(ROOT.DS.'core'.DS.'libs'.DS.$lib.'.php')){
        require_once(ROOT.DS.'core'.DS.'libs'.DS.$lib.'.php');
    }else{
    	echo "No existe la biblotecas";
    	exit();
    }
}
/**
 * Funcion de carda de configaciones
 */
function load_conf($conf){
	if (file_exists(ROOT.DS.'config'.DS.$conf.'.php')){
        require_once(ROOT.DS.'config'.DS.$conf.'.php');
    }else{
    	echo "No existe el archivo de configuracion";
    	exit();
    }
}
