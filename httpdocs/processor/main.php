<?php

class C_Main extends Controller {
	protected $template = "activation";
	
	public function main() {
		$activated_hash = array_keys($_GET)[0];

		// $activation = User::activatedUsers($activated_hash);

		if($activation == TRUE){
			header('Location: /');///webmaster_cabinet');
		}
		parent::main();
	}
}