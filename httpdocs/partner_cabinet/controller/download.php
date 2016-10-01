<?php

class C_Download extends Controller {
   protected $template = "download";
	
	public function main() {
		$this->view = 'download.php';
		parent::main();
	}
}