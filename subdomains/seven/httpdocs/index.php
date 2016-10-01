<?
    $conf = array(
        "mysql" => array(
            "host" => "a134180.mysql.mchost.ru",
            "database" => "a134180_cpa",
            "user" => "a134180_cpa",
            "password" => "cpaa134180"
        )
    );

$mysqli = new mysqli($conf["mysql"]["host"], $conf["mysql"]["user"], $conf["mysql"]["password"], $conf["mysql"]["database"]);
if ( $mysqli->connect_errno){
    throw new Exception("Fatal error database",E_USER_ERROR);
}else{
	$res = $mysqli->query('SELECT `id` FROM `offers` WHERE `partner_id`=11');


	$query = 'SELECT `id` FROM `orders` WHERE `user_status`=1 and `date`<='.strtotime('-7 days');

	$info = $mysqli->query($query);
	
				$orders = array();
				 while ($row = $info->fetch_assoc()){
					
					$orders[] = $row['id'];
				 }

		if(empty($orders)){
			continue;
		}
		

		$orders = array_chunk($orders, 30);
		foreach($orders as $order){
			$mysqli->query('UPDATE `orders` SET `user_status`=0 WHERE `id` in ('.join(',',$order).')');
		}
		
}
echo 'the end';
		
		
				
	
