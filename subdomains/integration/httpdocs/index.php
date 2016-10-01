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
	
	$offer_ids = array();
	while($row = $res->fetch_assoc()){
		$offer_ids[]=$row['id'];
	}
	foreach($offer_ids as $offer_id){
		if($offer_id == 5){
			$status = array( 
				"availability-confirmed" => 1,	
				"offer-analog" => 1,	
				"client-confirmed" => 2,	
				"prepayed" => 1,	
				"perezvonit" => 1,	
				"blacklist" => 1,	
				"soglasovanie" => 1,	
				"send-to-assembling" => 2,	
				"assembling" => 2,	
				"assembling-complete" => 2,	
				"send-kurer" => 1,	
				"zhdettovar" => 1,	
				"send-post" => 2,	
				"komplect1" => 2,	
				"komplect2" => 2,	
				"send-to-delivery" => 1,	
				"delivering" => 2,	
				"redirect" => 2,	
				"data-vykup" => 2,	
				"marketer" => 2,	
				"collector" => 2,	
				"avtodozvon" => 2,	
				"nedozvon-popal" => 2,	
				"complete" => 2,	
				"vrucheno" => 2,	
				"oplachen" => 2,	
				"vozvrat" => 2,	
				"vrucheno-iz-kollektora" => 2,	
				"v-vozvrat" => 2,	
				"vozvrat-kurer" => 0,	
				"oplachen-kurer" => 2,	
				"no-call" => 0,	
				"ne-podtverghden2" => 0,	
				"no-product" => 0,	
				"already-buyed" => 0,	
				"delyvery-did-not-suit" => 0,	
				"prices-did-not-suit" => 0,	
				"cancel-other" => 0,	
				"pretenzii" => 0,	
				"otloghen" => 0,	
				"na-vozvrat-monsram" => 0	
		);
		$l = 'https://dvad.retailcrm.ru/api/v3/orders?apiKey=ENElXeEnXWZseoW1TIy5xTmvPLcR9rGD&';

		}else if($offer_id == 2 || $offer_id == 6 || $offer_id == 20){
			$status = array( 
				"new" => 1,
				"call-back" => 1,
				"auto-new" => 1,
				"auto-hot" => 1,
				"auto-cold" => 1,
				"auto-priority" => 1,
				"auto-test" => 1,
				"prepayment" => 1,
				"spbcourier" => 1,
				"frodcontrol" => 1,
				"client-confirmed" => 2,
				"assembling" => 2,
				"send" => 2,
				"send-to-delivery" => 2,
				"delivering" => 2,
				"arrived" => 2,
				"complete" => 2,
				"paid" => 2,
				"cancel-other" => 0,
				"no-call" => 0,
				"already-buyed" => 0,
				"auto-fake" => 0,
				"cancel-after-confirmed" => 0,
				"frod" => 0,
				"returns" => 0,
				"returns-complete" => 0,
				"claim" => 0
			);
			$l = 'https://skidki90.retailcrm.ru/api/v3/orders?apiKey=DhU9Jxa3yiM7c15fbhjejRNpVIsOhehe&';
		}else{
			$status = array( 
		"new" => 1,
		"new-frod" => 1,
		"vtorichka" => 1,
		"availability-confirmed" => 1,
		"offer-analog" => 1,
		"client-confirmed" => 2,
		"prepayed" => 1,
		"perezvonit" => 1,
		"blacklist" => 1,
		"soglasovanie" => 1,
		"send-to-assembling" => 2,
		"assembling" => 2,
		"assembling-complete" => 2,
		"send-kurer" => 1,
		"zhdettovar" => 1,
		"send-post" => 2,
		"komplect1" => 2,
		"komplect2" => 2,
		"send-to-delivery" => 2,
		"delivering" => 2,
		"redirect" => 2,
		"data-vykup" => 2,
		"marketer" => 2,
		"collector" => 2,
		"complete" => 2,
		"vrucheno" => 2,
		"oplachen" => 2,
		"vozvrat" => 2,
		"vrucheno-iz-kollektora" => 2,
		"v-vozvrat" => 2,
		"oplachen-kurer" => 2,
		"vozvrat-kurer" => 0,
		"no-call" => 0,
		"ne-podtverghden2" => 0,
		"no-product" => 0,
		"already-buyed" => 0,
		"delyvery-did-not-suit" => 0,
		"prices-did-not-suit" => 0,
		"cancel-other" => 0,
		"otloghen" => 0,
		"na-vozvrat-monsram" => 0
	);
	$l = 'https://dvad.retailcrm.ru/api/v3/orders?apiKey=ENElXeEnXWZseoW1TIy5xTmvPLcR9rGD&';
		}
		

	$query = 'SELECT `id`,`params` FROM `orders` WHERE `user_status`=1';
	$info = $mysqli->query($query);
				$leads = array();
				 while ($row = $info->fetch_assoc())
					$leads[] = $row;
				


		$orders = array();

		if($leads != false && !empty($leads)) {
			foreach($leads as $lead) {
				
				$mas = json_decode(iconv("windows-1251", "UTF-8",$lead['params']), true);
				// $mas = json_decode($lead['params'], true);

				
				if(isset($mas[3]) && !empty($mas[3])){
					
					$orders[] = 'filter[externalIds][]='.$mas[3];
				}
				
			}
		}

		if(empty($orders)){
			continue;
		}
		

		$orders = array_chunk($orders, 10);
		

		foreach($orders as $order_part) {
			
			$link = $l.join('&', $order_part);
			

			$response = file_get_contents($link);
				
			$response = json_decode($response, true);	
			
		
			
			
			foreach($response['orders'] as $order){
				
				$state = 1;
				$order_id = $order['externalId'];
				$order_status = $order['status'];

				if(isset($order['managerComment']) && !empty($order['managerComment'])){
					$rejection = $order['managerComment'];//.'('.$order_status.')';
				}else{
					$rejection = '';//$order_status;
				}
				
				
				if(isset($status[$order_status])){	
					$state = $status[$order_status]; 
				}else{
					$state = 1;
				}

				if($state != 1){
					$rSql = $mysqli->query('SELECT id, user_id, click_id, offer_id FROM orders WHERE params LIKE "%'.$order_id.'%" AND `user_status` IN (1) LIMIT 1');

					if($rSql && $rSql->num_rows == 1) {
						$data = $rSql->fetch_assoc();

						if($state == 2) {
							$comfirm_leads_ids[] = $data['id'];
							file_get_contents('http://cpa-private.biz/postback?user_id='.$data['user_id'].'&offer_id='.$data['offer_id'].'&click_id='.$data['click_id']);
							// Order::postback($data['user_id'],$data['offer_id'],'confirm',$data['click_id']);
						}

						if($state == 0){
							$deny_leads_ids[] = $data['id'];
							$mysqli->query('UPDATE `orders` SET `user_status`=0, `comment`="'.$rejection.'" WHERE `id`='.$data['id']);
							// $oLeads->denyLeads(array($data['id']), $rejection);
							// Order::postback($data['reject'],$data['offer_id'],'r',$data['click_id']);
						}
					}
				}
			}

		}
		if(isset($comfirm_leads_ids) && !empty($comfirm_leads_ids)){
			$mysqli->query('UPDATE `orders` SET `user_status`=2 WHERE `id` in ('.join(',',$comfirm_leads_ids).')');
			echo 'Comfirm - '. count($comfirm_leads_ids);
		}else{
			echo 'Comfirm - 0';
		}
		if(isset($deny_leads_ids) && !empty($deny_leads_ids)){
			// $mysqli->query('UPDATE `orders` SET `user_status`=0 WHERE `id` in ('.join(',',$deny_leads_ids).')');
			echo '<br>Deny - '. count($deny_leads_ids);
		}else{
			echo '<br>Deny - 0';
		}
}
		
		
				
	
	file_get_contents('http://cpa-private.biz/partner_balans_update');
	
}