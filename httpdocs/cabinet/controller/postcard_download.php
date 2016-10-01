<?php
class C_Postcard_download extends Controller{
    protected $template = 'cabinet';
    public function main() {
        $this->view = 'postcard_download.php';
        parent::main();
    }
}