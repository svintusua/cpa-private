<?php
// phpinfo(); /test commit
// exit;
define("SITE", "cpa-private.biz");
include $p = dirname(__DIR__)  . "/private/global/init.php";
$core = core::getInstance();
$core->run();
 