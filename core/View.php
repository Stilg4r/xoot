<?php
/**
 * Clase de la vista
 */

/**
 * Clase que renderiza la vista 
 */
class View extends Application{
	
	protected $variables = array();
	protected $css=[];
	protected $js=[];

	function __construct(){}

	function tokenForm($formname){
		echo '<input type="hidden" name="CSRFToken" value="'.$this->generateToken($formname).'">';
	}

	/**
	 * Pasa las variable del controlador a la visota
	 * @param string $name  nombre de la variable
	 * @param object $value valor de la variable
	 */
	function set($name,$value) {
		$this->variables[$name] = $value;
	}
	/**
	 * renderiza una vista
	 * @param  string $view_name nombre de la vista
	 * @param  string $snippet   nombre de la plantilla
	 */
	function render($view_name,$snippet = DEFAULT_TEMPLATE) {
		extract($this->variables);
		$path=ROOT . DS .'application' . DS . 'views' . DS . $snippet . '.php';
		if( file_exists($path) ) {
			include ($path);
		} else {
    		$trace = debug_backtrace();
			trigger_error('no existe plantilla '.$path.' '.$trace[0]['file'].' en la linea '.$trace[0]['line'],E_USER_ERROR);
		}
	}
	/**
	 * Renderiza un contenido parcial
	 * @param  strig $render_partial nombre de la vista parcial
	 */
	function render_partial($render_partial){
		extract($this->variables);
		$path=ROOT . DS .'application' . DS . 'views' . DS . $render_partial . '.php';
		if( file_exists($path) ) {
			include ($path);
		} else {			
    		$trace = debug_backtrace();
			trigger_error('no existe contenido parcial '.$path.' '.$trace[0]['file'].' en la linea '.$trace[0]['line'],E_USER_ERROR);
		}
	}
	protected function css(){
	 	foreach ($this->css as $css) {
	 		if (preg_match('/^htt(ps|p):\/\/.*\.css$/', $css)) {
	 			echo '<link rel="stylesheet" href="'.$css.'">';
	 		}else{
	 			echo '<link rel="stylesheet" href="'.PATH.'/css/'.$css.'.css">';	 			
	 		}
	 		echo "\r\n";
	 	}
	}
	protected function js(){
		foreach ($this->js as $js) {
			if (preg_match('/^htt(ps|p):\/\/.*\.js$/', $js)) {
				echo '<script type="text/javascript" src="'.$js.'"></script>';
			}else{
				echo '<script type="text/javascript" src="'.PATH.'/js/'.$js.'.js"></script>';
			}
			echo "\r\n";
		}
	}
	private function add2array(&$array,$item) {
		if (is_array($item)) {
			$array=$array+$item;
		}elseif (is_string($item)) {
			$array[]=$item;
		}
	}
	public function addCss($csss){
		$this->add2array($this->css,$csss);
	}
	public function addJs($jss){
		$this->add2array($this->js,$jss);
	}
}