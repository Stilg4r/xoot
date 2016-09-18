<?php
class RestFullController extends Controller{
	public function __construct($controller,$action) {
		parent::__construct($controller, $action);
	}
	protected function jsonResponce($data,$code=200){
		http_response_code($code);
		header('Content-Type: application/json');
		echo json_encode($data);
		exit();
	}
	protected function setter(&$result,$code=200){
		$data = json_decode(file_get_contents("php://input"),true);
		try{
			foreach ($data as $key => $value) {
				$result->set($key,$value);
			}
			if ($result->save()) {
				$this->jsonResponce($result->asArray(),$code);	
			}else {
				$this->jsonResponce($result->getErrors(),409);
			}
		}catch (Exception $e) {
		 	http_response_code(400);
		} 
	}
	public function all(){
		$model=$this->getModel();
		$result=$model::findArray();
		if (empty($result)) {
			http_response_code(204);
			exit();
		}
		$this->jsonResponce($result);
	}
	public function create(){
		$model=$this->getModel();
		$result=$model::create();
		$this->setter($result,201);
	}
	public function read($id){
		$model=$this->getModel();
		$result=$model::ifExist($id,function(){http_response_code(404) ;exit();});
		$this->jsonResponce($result->asArray());
	}
	public function update($id){
		$model=$this->getModel();
		$result=$model::ifExist($id,function(){http_response_code(404) ;exit();});
		$this->setter($result);
	}
	public function delete($id){
		$model=$this->getModel();
		$result=$model::ifExist($id,function(){http_response_code(404) ;exit();});
		if ($result->delete()) {
			http_response_code(200);
		}else{
			$this->jsonResponce($result->getErrors(),409);
		}
	}
}