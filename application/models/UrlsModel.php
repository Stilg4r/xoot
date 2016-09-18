<?php
use Respect\Validation\Validator as v;
load_lib('Respect/autoload');
class UrlsModel extends CustomModel{
	public static $_table = 'urls';
	public function save() {
		if (v::url()->validate($this->url)) {
			return parent::save();	
		}else{
			$this->setError("not valid url");
			return false;
		}
	}
}