<?php

final class IOLog {

    private static $log_files;

    const LEVEL_FATAL = 0;
    const LEVEL_ERROR = 1;
    const LEVEL_WARNING = 2;
    const LEVEL_INFO = 3;
    const LEVEL_DEBUG = 4;

    private $file_name;

    private function checkLevel(&$level){
        if (filter_var($level, FILTER_VALIDATE_INT)===false) 
          $level=  self::LEVEL_INFO;
      elseif ($level<self::LEVEL_FATAL)
            $level=self::LEVEL_FATAL;
      elseif ($level>self::LEVEL_DEBUG)
            $level=self::LEVEL_DEBUG;
      return ;
    }
            
    function __construct($file_name, $level = self::LEVEL_INFO) {
        $file_name = $file_name ? : "noname";
        $this->checkLevel($level);              
        $this->file_name = LOG_DIR . strtolower(basename($file_name)) . ".log";
        self::$log_files[$this->file_name]["level"] = $level;
    }

    function log($text, $level = self::LEVEL_INFO, $file = "", $line = "") {
        $this->checkLevel($level);   
                
            
        if (self::$log_files[$this->file_name]["level"] < $level)
            return FALSE;
        if (!isset(self::$log_files[$this->file_name]["link"]) || !is_resource(self::$log_files[$this->file_name]["link"]))
            self::$log_files[$this->file_name]["link"] = fopen($this->file_name, 'a');
        if (self::$log_files[$this->file_name]["link"] === false)
            exit("error file open " . $this->file_name . "\n");
        $data = array(
            date("Y-m-d H:i:s"),
            "L{$level}",
            "(".basename($file).":{$line})",
            $text,
        );
        $res = implode(" ", $data)."\n"; //. fwrite(self::$log_files[$this->file_name]["link"], $level) . fwrite(self::$log_files[$this->file_name]["link"], $file) . fwrite(self::$log_files[$this->file_name]["link"], $line))."\n";
        fwrite(self::$log_files[$this->file_name]["link"],$res);
        if ($level===0)
            throw new Exception("Fatal error",E_USER_ERROR);
        
        return $res;
        
    }
    function __destruct() {
        if (is_array(self::$log_files)){
            foreach (self::$log_files as $params){
                if (is_resource($params["link"]))
                     fclose($params["link"]);
            }
        }
            
    }
}

