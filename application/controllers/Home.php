<?php
class Home extends Controller{
	public function __construct($controller,$action) {
		parent::__construct($controller, $action);
	}
	public function index(){
		$this->addJs();
		$this->renderView();
	}
	public function short($id){
		$id=intval($id,36);
		$url=UrlsModel::ifExist($id,function(){header('Location: '.PATH.'/404');exit();});
		header('Location: '.$url->url);
	}
}