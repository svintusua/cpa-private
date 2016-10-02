<?php

define("HOSTING", basename(dirname(dirname(__DIR__)))=="jobtit"?false:true);
include 'config.php';
define("SITE_DIR", dirname(__DIR__) . DIRECTORY_SEPARATOR);
define("LOG_DIR", dirname(SITE_DIR).DIRECTORY_SEPARATOR."logs". DIRECTORY_SEPARATOR);
define("TMP_DIR", dirname(SITE_DIR).DIRECTORY_SEPARATOR."tmp". DIRECTORY_SEPARATOR . SITE . DIRECTORY_SEPARATOR);
define("TEMPLATE_DIR",SITE_DIR."template". DIRECTORY_SEPARATOR . SITE . DIRECTORY_SEPARATOR);
define("WWW_DIR", dirname(SITE_DIR).DIRECTORY_SEPARATOR.'httpdocs'. DIRECTORY_SEPARATOR);

define("SMSC_LOGIN", "roma.conect");			// логин клиента
define("SMSC_PASSWORD", "CgbhfktxrfVjz3455");	// пароль или MD5-хеш пароля в нижнем регистре
define("SMSC_POST", 0);					// использовать метод POST
define("SMSC_HTTPS", 0);				// использовать HTTPS протокол
define("SMSC_CHARSET", "utf-8");	// кодировка сообщения: utf-8, koi8-r или windows-1251 (по умолчанию)
define("SMSC_DEBUG", 0);				// флаг отладки
define("SMTP_FROM", "api@smsc.ru"); 

set_include_path(get_include_path().PATH_SEPARATOR.SITE_DIR."global".PATH_SEPARATOR.SITE_DIR."model/".SITE);
spl_autoload_register("autoload_class");
set_error_handler("error_handler");
register_shutdown_function("shutdown_function");
set_exception_handler("exception_handler");
date_default_timezone_set("Europe/Moscow");
function autoload_class($class_name){
    include_once strtolower($class_name).".php";
    if (!class_exists($class_name, FALSE))
        trigger_error ("Class {$class_name} not exists {$f}", E_USER_ERROR);
}
function error_handler($errno, $errstr, $errfile, $errline){
    if (in_array($errno, array(E_USER_ERROR, E_COMPILE_ERROR))){
        $l = new IOLog("fatal");
        $l->log($errstr,  IOLog::LEVEL_INFO,$errfile,$errline);
        return FALSE;
    }
  
}
function shutdown_function(){
    $error=  error_get_last();
    if (in_array($error["type"], array(E_USER_ERROR, E_COMPILE_ERROR)))
        return;
    error_handler($error["type"], $error["message"],$error["file"], $error["line"]);
}
function exception_handler($e){
	$details = $e->getTrace();
    trigger_error("exception_handler: ".$e->getMessage().'(file: "'.$details[0]['file'].'" line '.$details[0]['line'].' )', E_USER_ERROR );
}
