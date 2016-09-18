<?php
class Urls extends RestFullController{
	public function __construct($controller,$action) {
		parent::__construct($controller, $action);
	}
	private function save($result){
		if ($result->save()) {
			$result->id=base_convert($result->id, 10, 36);
			$result->short='http://'.DOMAIN.PATH.'/'.$result->id;
			$this->jsonResponce($result->asArray(),201);	
		}else {
			$this->jsonResponce($result->getErrors(),409);
		}
	}
	public function create(){
		$data = json_decode(file_get_contents("php://input"),true);
		$model=$this->getModel();
		if ($data['personify']==1) {
			if (strlen($data['id'])<=4 and strlen($data['id'])>0) {
				$data['id']=intval($data['id'],36);
				if ($result=$model::whereAnyIs([['id'=>$data['id']],['url'=>$data['url']]])->findOne() ) {
					$this->jsonResponce(['it already exists'],409);
				}else{
					$result=$model::create();
					$result->id=$data['id'];
					$result->url=$data['url'];
					$this->save($result);
				}
			}else{
				$this->jsonResponce(['It is not valid too long or short'],409);
			}
		}else{
			try {
				if ((isset($data['url'])) and ($result=$model::where('url',$data['url'])->findOne())) {
					$result->id=base_convert($result->id, 10, 36);
					$result->short='http://'.DOMAIN.PATH.'/'.$result->id;
					$this->jsonResponce($result->asArray(),201);
				}else{
					$result=$model::create();
					$result->url=$data['url'];
					$this->save($result);
				}
			} catch (Exception $e) {
				http_response_code(400);	
			}		
		}
	}	
}