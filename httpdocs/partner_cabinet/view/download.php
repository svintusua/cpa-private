<?php
$filename=$_GET['filename'];

//$file=  array_pop(explode('/', $filename));   
header("Content-type: application/vnd.ms-excel"); 
header('Content-Disposition: attachment; filename="'.$filename.'"'); 
readfile(WWW_DIR.'export/'.$filename);