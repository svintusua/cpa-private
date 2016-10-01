<?
define("SITE", 'дымчик.рф');
include '../site/config.php';
$conf = $GLOBALS["CONFIG"]["mysql"];
$db = new mysqli($conf["host"], $conf["user"], $conf["password"], $conf["database"]);
if ($db->connect_errno){
    echo json_encode(array('Error'=>"Fatal error database"));
	die;	
}
$db->set_charset("utf8");

if($_POST['promocode']){
	if(strlen($_POST['promocode']) == 9){
		$resp = mysqli_query($db, 'SELECT `used` FROM `promo` WHERE `promo` = "'.$_POST['promocode'].'" LIMIT 1');
		
		if(mysqli_num_rows($resp)==1){
				$data = mysqli_fetch_assoc($resp);
			if($data['used'] == 0){
				$used = 'noused';
			}else if($data['used'] == 1){
				$used = 'used';
			}
		}else{
			$used = 'Такой промокод не найден!';
		}
	}else{
		$used = 'Такого промокода не существует!';
	}
	echo json_encode(array('response'=>utf8_encode($used)));
	die;
}else{
	echo json_encode(array('response'=>utf8_encode('Промокод отсутсвует')));
	die;
}