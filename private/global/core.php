<?php

class Core {

    public $request, $zone;

    private function __construct() {
        $this->parseUrl();
        //todo авторизация пользователя User::Auth
    }

    public static function getInstance() {         
        static $instance;
        if ($instance === NULL)
            $instance = new self;       
        return $instance;
    }

    public static function log($string, $level = IOLog::LEVEL_INFO, $file = "", $row = "") {
        static $log;
        if ($log === NULL)
            $log = new IOLog("log_core", IOLog::LEVEL_INFO);
        $log->log($text, $level, $file, $line);
    }

    private function parseUrl() {
        $arr = explode("?", $_SERVER["REQUEST_URI"]);
        $path = $arr[0];
        
        $parts = explode("/", $path);
        $this->zone = "main";
        array_shift($parts);
        if ($parts[0] && is_dir(WWW_DIR . $parts[0])) {
            $this->zone = $parts[0];
            array_shift($parts);
        }
        $this->request = $parts;
        
    }

    private function runControllerMethod() {
        $d = DIRECTORY_SEPARATOR;
 
        $script = "main";
        $tmp = $this->request[0] ? basename(strtolower($this->request[0])) : "";
        $zone_postcard=  explode("/", $_SERVER['REQUEST_URI']);
		
        if((count($zone_postcard)>=4 && $zone_postcard[1]=='postcard') || (count($zone_postcard)>=3 && $zone_postcard[1]=='postcard' && $down=  explode('?', $zone_postcard[2])[0]=='dowload.php')){
               
            if($down=explode('?', $zone_postcard[2])[0]=='dowload.php'){
               
                $filename = WWW_DIR . 'postcard/dowload.php';
                
            }else{
                $filename = WWW_DIR . $_SERVER['REQUEST_URI']."index.html";
            }
           include_once $filename;            
        }else{
			 
            if ($tmp) {
                $filename = WWW_DIR . "{$this->zone}{$d}controller{$d}{$tmp}.php";

                if (is_readable($filename)) {
                    $script = $tmp;
                    array_shift($this->request);
                }else{
                    //include_once WWW_DIR ."404.html";
                    //return false;
                }
            }

            $filename = WWW_DIR . "{$this->zone}{$d}controller{$d}{$script}.php";
            
            if (!is_readable($filename))
                trigger_error("Script $script not exists");
            include_once $filename;			
            $this->cname = "C_" . ucfirst($script);
            $controller = class_exists($this->cname, false) ? new $this->cname : false;	
		
            if ($controller == false || !is_object($controller)){
                
                trigger_error("Controller $controller not exists ({$_SERVER['REQUEST_URI']})", E_USER_ERROR);
                include_once WWW_DIR ."404.html";
                return false;
            }
	
            $method = "main";

            if ($this->request[0] && is_callable(array($controller, $this->request[0]))) {               
                $method = $this->request[0];				
                array_shift($this->request);
            }else if(!empty($this->request[0])){
				include_once WWW_DIR ."404.html";
                return false;
			}

            if (!is_callable(array($controller, $method))) {
                trigger_error("Controller $controller method $method not exists", E_USER_ERROR);
				include_once WWW_DIR ."404.html";
                return false;
            }

        call_user_func(array($controller, $method));
        }
    }

    public function run() {
        
        ob_start(array($this,"output"));
        $this->runControllerMethod();

    }
    
    public function output(&$content){
        header("Pragma:no-cache");
        return $content;
    }

}
