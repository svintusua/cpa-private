<?php

class C_Partner_balans_update extends Controller {

    protected $template = "main";

    public function main() {
		// $this->view = 'partner_balans_update.php';
		User::updatePartnerBalans();
		exit;
		 // parent::main();
	}
}