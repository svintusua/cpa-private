<?php

$filename=$_GET['filename'];
$file=  array_pop(explode('/', $filename));   
header("Content-type: image/jpeg"); 
header('Content-Disposition: attachment; filename="'.$file.'"'); 
readfile(WWW_DIR.$filename);