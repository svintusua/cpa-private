<?php

class C_Faq extends Controller {

    protected $template = "wm";
	
	public function main() {
		//<?=$this->vars['img_all']
		// var_dump(Offers::getOffers());
		// exit;
		$this->view = 'faq.php';
		$this->addVar("title", 'FAQ');

		parent::main();
	}
}