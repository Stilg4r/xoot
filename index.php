<?php
/**
 * Index recive todas las peticiones y maneja las seciones 
 */
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd());

session_start();

if (isset($_REQUEST['url'])) {
	$url=$_REQUEST['url'];
}else {
	$url="";
}

if (preg_match("/^administration.*/",$url ) and !isset($_SESSION['login'])) {
	$url = 'administration/login';
}

if (isset($_SESSION['keep_open']) and $_SESSION['keep_open'] ) {
	#nada
}else{
	// Make sure we have a canary set
	if (!isset($_SESSION['canary'])) {
		session_regenerate_id(true);
		$_SESSION['canary'] = ['birth' => time(),'IP' => $_SERVER['REMOTE_ADDR']];
	}

	if ($_SESSION['canary']['IP'] !== $_SERVER['REMOTE_ADDR']) {
		session_regenerate_id(true);
		$_SESSION=array();
		$_SESSION['canary'] = ['birth' => time(),'IP' => $_SERVER['REMOTE_ADDR']];
	}

	if ($_SESSION['canary']['birth'] < time() - 10000) {
		session_regenerate_id(true);
		$_SESSION['canary']['birth'] = time();
	}
}


require_once('core' . DS . 'bootstrap.php');