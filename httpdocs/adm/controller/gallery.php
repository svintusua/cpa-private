<?php

class C_Gallery extends Controller {

    protected $template = 'adm';
    
    public function uploadimg(){
        $countimg=count($_FILES["img"]['name']);
                for($i=0;$i<$countimg;$i++){
                    $allimg[$i]['name']=$_FILES["img"]['name'][$i];
                    $allimg[$i]['type']=$_FILES["img"]['type'][$i];
                    $allimg[$i]['tmp_name']=$_FILES["img"]['tmp_name'][$i];
                    $allimg[$i]['error']=$_FILES["img"]['error'][$i];
                    $allimg[$i]['size']=$_FILES["img"]['size'][$i];
                }
                Gallery::addImg(2, $allimg);
                parent::main();
    }
     public function main() {
        $this->view = 'gallery.php';
        parent::main();
    }
}