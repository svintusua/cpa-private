<?php

final class IOMysqli {

    private $link;

    private function __construct() {
        $conf = $GLOBALS["CONFIG"]["mysql"];
        $this->link = new mysqli($conf["host"], $conf["user"], $conf["password"], $conf["database"]);
        if ($this->link->connect_errno)
            throw new Exception("Fatal error database",E_USER_ERROR);
        $this->link->set_charset("utf8");

    }

    function __destruct() {
        if ($this->link !== NULL)
           $this->link->close();
    }

    private static function getInstance() {
        static $instance;
        if ($instance === NULL)
            $instance = new self;
        return $instance;
    }
    public static function insertId(){
		$db = self::getInstance();
        return $db->link->insert_id();		
	}
    public static function query($query, $return_id = 0){
        $db = self::getInstance();
        $res = $db->link->query($query);
        if ($db->link->errno)
            throw new Exception($db->link->error,E_USER_ERROR);
		if($return_id == 1){
			return $db->link->insert_id;	
		}else{
			return $res;
		}
        
    }


    /**
     * 
     * @param type $query
     * @return array Возвращает двухмерный массив
     * @throws Exception 
     */
    public static function table($query) {
        $db = self::getInstance();
        $res = $db->link->query($query);
        if ($db->link->errno)
            throw new Exception($db->link->error,E_USER_ERROR);
           // exit("db query error: " . $db->link->error . "\n");
        $table = array();
        if (!$res)
            return array();
        while ($row = $res->fetch_assoc())
            $table[] = $row;

        @$res->free();
        return $table;
    }

    /**
     * 
     * @param type $query
     * @return array Возвращает ассоциативный одномерный массив 
     */
    public static function row($query) {
        return reset(self::table($query));
    }

    /**
     * 
     * @param type $query
     * @return string Возвращает строку
     */
    public static function one($query) {
        return reset(self::row($query));
    }
    /**
     * удаляет специальные символы из строки для использования в sql запросе, с учетом текующей кодовой таблицы в соединении
     * @param string $str - строка 
     * @return string - безопасная строка для вставки в запрос
     */
    public static function esc($str){
        $db = self::getInstance();
        
        return $db->link->real_escape_string($str);
        
        
    }

}

