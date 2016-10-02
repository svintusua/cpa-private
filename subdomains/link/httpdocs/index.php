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
			$mysqli->set_charset("utf8");
			// $identity = array_keys(array_shift($_GET));

			if(isset($_GET['i']) && preg_match('/^[0-9a-zA-Z]{7}$/',$_GET['i']) == 1){
				$subid = array();
				if(isset($_GET['subid1']) && !empty($_GET['subid1'])){
					$subid['subid1'] = $_GET['subid1'];
					$subid2[] = '&subid1='.$_GET['subid1'];
				}else{
					$subid2[] = '';
				}
				if(isset($_GET['subid2']) && !empty($_GET['subid2'])){
					$subid['subid2'] = $_GET['subid2'];
					$subid2[] = '&subid2='.$_GET['subid2'];
				}else{
					$subid2[] = '';
				}
				if(isset($_GET['subid3']) && !empty($_GET['subid3'])){
					$subid['subid3'] = $_GET['subid3'];
					$subid2[] = '&subid3='.$_GET['subid3'];
				}else{
					$subid2[] = '';
				}
				$ip = $_SERVER['REMOTE_ADDR'];
				// $geo = file_get_contents('http://api.sypexgeo.net/json/'.$ip);				
				$geo = file_get_contents('http://7oclock.ru/sypexgeo.php?ip='.$ip);				
				$country = json_decode($geo, true)['country']['name_ru'];
				
				$identity = $_GET['i'];
								
				$query = 'SELECT ol.`used_link`,ul.wm_id, o.postclick, ul.land_id, ul.preland_id, o.id, ul.id as link_id, o.location_name FROM `offer_links` as ol join `users_links` as ul on ul.land_id=ol.id join `offers` as o on o.id=ol.offer_id WHERE ul.identity="'.$identity.'"';
				
				$info = $mysqli->query($query);
				$data = array();
				 while ($row = $info->fetch_assoc())
					$data[] = $row;
				$data = $data[0];

				if($data['preland_id'] == 0 || (isset($_GET['from']) && !empty($_GET['from']) && $_GET['from'] == 'preland')){
					// $html=preg_replace('/@@submit@@/','',$html);
					$link = $data['used_link'];
					$click = md5(md5($data['wm_id'].$data['used_link'].date('YmdHis').'5u4KLJ45ASd)#@%45#@'));
					// setcookie('arb_id', $identity, strtotime('+30 days'));
					// var_dump($_COOKIE['utm_source']);
					// exit;
					// exit;
					$link=preg_replace('/{click}/',$click,$link);
					$link=preg_replace('/{wm}/',$data['wm_id'],$link);
					$link=preg_replace('/{postclick}/',$data['postclick'],$link);
					
					
					if(isset($subid) && !empty($subid)){
						$query = 'SELECT `identity` FROM `users_links` WHERE  `subid1`="'.$subid['subid1'].'" and `subid2`="'.$subid['subid2'].'" and `subid3`="'.$subid['subid3'].'" LIMIT 1';
						$id= $mysqli->query($query);					
						// while ($row = $id->fetch_assoc())
							// $identity = $row;
						// var_dump($id);
							// exit;
							
						if(mysqli_num_rows($id) > 0){
							while ($row = $id->fetch_assoc())
								$identity = $row['identity'];
						}else{
							$str='123456789qwertyuiopasdfghjklzxcvbnm';
							$identity = '';
							for($i=0;$i<7;$i++){
								$identity .= $str[rand(0,strlen($str)-1)];
							}
							$wm_id = $data['wm_id'];
							$land_id = $data['land_id'];
							
							$q = 'INSERT INTO `users_links`(`wm_id`, `land_id`, `identity`,'.join(' ,', array_keys($subid)).') VALUES ('.$wm_id.','.$land_id.',"'.$identity.'","'.join('","', $subid).'")';
				
							$mysqli->query($q);
							$data['link_id'] = $mysqli->insert_id;
							
						}
						
					}									
					
				}else{
					$query = 'SELECT ol.`used_link`,ul.wm_id, o.postclick, ul.land_id, ul.preland_id, o.id, ul.id as link_id, o.location_name FROM `offer_links` as ol join `users_links` as ul on ul.preland_id=ol.id join `offers` as o on o.id=ol.offer_id WHERE ul.identity="'.$identity.'"';
					
					$info = $mysqli->query($query);
					$data2 = array();
					 while ($row = $info->fetch_assoc())
						$data2[] = $row;
					$data2 = $data2[0];
					$link = $data2['used_link'];
					$click = md5(md5($data2['wm_id'].$data2['used_link'].date('YmdHis').'5u4KLJ45ASd)#@%45#@'));
					$link=preg_replace('/{click}/',$click,$link);
					$link=preg_replace('/{wm}/',$data2['wm_id'],$link);
					$link=preg_replace('/{postclick}/',$data2['postclick'],$link);
					$link.='&i='.$identity.'&from=preland'.join('',$subid2); 				

				}
				$q = 'SELECT * FROM `users_metrika` WHERE `offer_links_id`='.$data['land_id'].' and `user_id`='.$data['wm_id'];				
					$r = $mysqli->query($q);

					while ($row = $r->fetch_assoc()){
						$link.='&'.$row['name'].'='.$row['value'];
					}

				// if(in_array($country,explode(',',$data['location_name']))){
						$source = $_SERVER['HTTP_REFERER'];						
						$repeat = $mysqli->query('SELECT `id` FROM `clicks` WHERE `offer_id`='.$data['id'].' and `ip`="'.$ip.'" and `identity`="'.$identity.'" and click_id="'.$click.'" LIMIT 1');
						if($repeat->fetch_assoc()){
							$mysqli->query('UPDATE `clicks` SET `repeat`=`repeat`+1 WHERE `offer_id`='.$data['id'].' and `ip`="'.$ip.'" and `identity`="'.$identity.'" and click_id="'.$click.'" LIMIT 1');
						}else{
							$q ='INSERT INTO `clicks`(`offer_id`, `user_id`, `link_id`, `date`, `source`, `ip`, `click_id`, `identity`) VALUES ('.$data['id'].','.$data['wm_id'].','.$data['link_id'].',UNIX_TIMESTAMP(),"'.$source.'","'.$ip.'","'.$click.'","'.$identity.'")';
							
							$mysqli->query($q);
						}
						header('Location: '.$link);
					// }else{
						// $mysqli->query('INSERT INTO `clicks_tb`(`offer_id`, `link_id`, `user_id`, `click`, `ip`, `date`) VALUES ('.$data['id'].','.$data['link_id'].','.$data['wm_id'].', "'.$click.'","'.$ip.'",UNIX_TIMESTAMP())');
						// $q = 'SELECT `link` FROM `users_tb_links` WHERE user_id='.$data['wm_id'].' and offer_id='.$data['id'];
						// $r = $mysqli->query($q);
						// $link = $r->fetch_assoc()['link'];
						// if(isset($link) && !empty($link)){
							// if(preg_match('/^http/',$a) == 1){
								// header('Location: '.$link);
							// }else{
								// header('Location: http://'.$link);
							// }
							
						// }else{
							// echo 'Не возможно осуществить переход';
							// exit;
						// }
						
					// }
			}
			
			
		}
		