<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd().DS);
define('APPLICATION', ROOT.'application'.DS);
define('CLASSTEMPLATES', ROOT.'core'.DS.'ClassTemplates'.DS);

$help=<<<EOT
Usage
	base controller <controler name> 	#Crea un controlador
	base model <model name>	 		#Crea un modelo
	base mvc <name>					#Crea un modelo controlar y directorio de vistas

EOT;

function save($class,$template,$msg){
	if (!file_exists($class)) {
		$newFile = fopen($class, 'w');
		fwrite($newFile, $template);
		fclose($newFile);
		chmod($class,0644);				
	}else{
		echo $msg;
	}
}

function controller($name){
	$class = ucwords($name);
	$template = file_get_contents(CLASSTEMPLATES.'Controller.txt');
	$template = str_replace("#ClassName#", $class, $template);
	$class=APPLICATION.'controllers'.DS.$class.'.php';
	save($class,$template,'Controlador ya existe');
}

function model($model){
	$class = ucwords($model).'Model';
	$template = file_get_contents(CLASSTEMPLATES.DS.'Model.txt');
	$template = str_replace("#ClassName#",$class, $template);
	$template = str_replace("#ModelName#",$model, $template);
	$class=APPLICATION.'models'.DS.$class.'.php';
	save($class,$template,'Modelo ya existe');
}

if (isset($argv[2])) {
	switch ($argv[1]) {
		case 'controller':
			controller($argv[2]);
			break;
		case 'model':
			model($argv[2]);
			break;
		case 'mvc':
			controller($argv[2]);
			model($argv[2]);
			mkdir(APPLICATION.'views'.DS.$argv[2],0755);
			break;
		default:
			echo $help;
			break;
	}
}else{
	echo $help;
}