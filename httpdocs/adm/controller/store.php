<?php

class C_Store extends Controller {
	protected $template = 'adm';
	
	public function main() {
		$params = Store::getParamsForAdd();
		//var_dump($params);
		//exit;
		$this->addVar('currency', '<select name="currency">'.$params['currency'].'</select>');
		$this->addVar('category', '<select name="category">'.$params['category'].'</select>');
		$this->addVar('company', '<select name="company">'.$params['company'].'</select>');
		$this->addVar('type_goods', '<select name="type_goods">'.$params['type_goods'].'</select>');
        $this->view = 'store.php';
		$this->addVar("title", 'Магазин');
        parent::main();
    }
	public function setInfo(){		
		$errors = array();
		$action = trim($_POST['action'])
		switch($action){
			case 'set_category':
				do{
					if(isset($_POST['name']) && !empty($_POST['name'])){
						$name = trim($_POST['name']);
					}else{
						$errors[] = 'Отсутсвует название категории';
					}
					if(isset($_POST['company']) && !empty($_POST['company']) && filter_var($_POST['company'], FILTER_VALIDATE_INT)){
						$company_id = trim($_POST['company']);
					}else{
						$errors[] = 'Отсутсвует компания';
					}
					Store::setCategory($name, $company_id);
				}while(false)
				if($errors){
					
				}
			break;
			case 'set_company':
				do{
					if(isset($_POST['name']) && !empty($_POST['name'])){
						$name = trim($_POST['name']);
					}else{
						$errors[] = 'Отсутсвует название фирмы';
					}
					if(isset($_POST['company']) && !empty($_POST['company']) && filter_var($_POST['company'], FILTER_VALIDATE_INT)){
						$company_id = trim($_POST['company']);
					}else{
						$errors[] = 'Отсутсвует nbg';
					}
					Store::setCategory($name, $company_id);
				}while(false)
				if($errors){
					
				}
			break;
			case 'add_goods':
				do{
					if(isset($_POST['name']) && !empty($_POST['name'])){
						$name = trim($_POST['name']);
					}else{
						$errors[] = 'Отсутсвует название фирмы';
					}
					if(isset($_POST['company']) && !empty($_POST['company']) && filter_var($_POST['company'], FILTER_VALIDATE_INT)){
						$company_id = trim($_POST['company']);
					}else{
						$errors[] = 'Отсутсвует nbg';
					}
					Store::setCategory($name, $company_id);
				}while(false)
				if($errors){
					
				}
			break;
		}
	}
}