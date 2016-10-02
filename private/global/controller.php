<?php

abstract class Controller {

    protected $template = 'main';
    static public $head_title;
    protected $content;
    protected $view = 'main.php';
    private $vars=array();
    protected $is_ajax=false;
    
    public function __construct() {
   session_start();
        if ($_REQUEST['is_ajax'])
                $this->is_ajax=true;
        
    }

    public function main() {
        if ($this->is_ajax==true){
            $ajax['response']=$this->vars;
            echo json_encode($ajax);
            exit();
        }
		
        $a = extract($this->vars, EXTR_REFS);
        $d = DIRECTORY_SEPARATOR;
        $core = Core::getInstance();
        include_once TEMPLATE_DIR.$this->template."{$d}header.php";
        include_once WWW_DIR."{$core->zone}{$d}view{$d}{$this->view}";
        include_once TEMPLATE_DIR.$this->template."{$d}footer.php";
		
       
    }
    
    protected function addVar($name,$value){
        $this->vars[$name]=$value;
    }
	
	protected function output($array){
		echo json_encode($array);
		die;
    }
	
}