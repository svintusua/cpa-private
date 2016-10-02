<?php

class C_Regulation extends Controller {

    protected $template = "wm";
	
	public function main() {
		//<?=$this->vars['img_all']
		// var_dump(Offers::getOffers());
		// exit;
		$this->view = 'regulation.php';
		$this->addVar("title", 'Правила');
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
	
}