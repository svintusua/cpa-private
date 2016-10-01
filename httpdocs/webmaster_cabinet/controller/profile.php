<?php

class C_Profile extends Controller {

    protected $template = "wm";
	
	public function main() {
		//<?=$this->vars['img_all']
		// var_dump(Offers::getOffers());
		// exit;
		$this->view = 'profile.php';
		$this->addVar("title", 'Профиль');
		$cookie = Cookie::get("hash");
		if(isset($cookie) && !empty($cookie)){
			$info = User::getInfoByHash($cookie);
			if(filter_var($info['type'], FILTER_VALIDATE_INT)){
				$type_user = $info['type'];
				$wm_id = $info['id'];
				$this->addVar("refid", $wm_id);
				$this->addVar("name", explode('@',$info['email'])[0]);
			}else{
				header('Location: /');
			}	
			
			if($type_user == 2 || $type_user == 3){
				header('Location: /');
			}				
		}else{
			header('Location: /');
		}
		
		$b = User::getBalansByUserId($wm_id);
			if(isset($b[1]) && !empty($b[1])){
				$hold = $b[1];
			}else{
				$hold = 0;
			} 
			if(isset($b[2]) && !empty($b[2])){
				$balans = $b[2];
			}else{
				$balans = 0;
			}
			
			$this->addVar("balans", $balans);
			
			$this->addVar("hold", $hold);

			$this->addVar("profil", User::getProfilByUserId($wm_id));
		parent::main();
	}
	
	public function setInfo(){
		unset($_POST['is_ajax']);
		$cookie = Cookie::get("hash");
		if(isset($cookie) && !empty($cookie)){
			$info = User::getInfoByHash($cookie);
			if(filter_var($info['type'], FILTER_VALIDATE_INT)){				
				if(User::setInfo($info['id'],$_POST)){
					$this->output(array("response"=>'success',"text"=>"Данные внесены успешно"));
				}else{
					$this->output(array("response"=>'error',"text"=>"Ошибка при внесении данных"));
				}
			}else{
				header('Location: /');
			}	
			
			if($type_user == 2 || $type_user == 3){
				header('Location: /');
			}				
		}else{
			header('Location: /');
		}

	}
}