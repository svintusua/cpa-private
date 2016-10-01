<?php
class Order extends Model {
	protected static $key = 'cpa_private encode data order';
	
	public static function getInfoOrders($orders_id){
		if(isset($orders_id) && !empty($orders_id) && is_array($orders_id)){
			$q = 'SELECT o.*, io.sender,io.country,io.state,io.city,io.street,io.house,io.flat,io.index,io.track_number,io.delivery,io.sale_type,io.sale FROM `orders` as o join `info_orders` as io on io.order_id=o.id WHERE o.id in('.join(',',$orders_id).')';
			return IOMysqli::table($q);
		}else{
			return false;
		}
		
	}
	public static function deleteOrders($orders = array()){
		if(isset($orders) && !empty($orders) && is_array($orders)){
			$q = 'DELETE FROM `orders` WHERE id in ('.join(',',$orders).')';
			IOMysqli::query($q);
			$q = 'DELETE FROM `info_orders` WHERE id in ('.join(',',$orders).')';
			IOMysqli::query($q);
			$q = 'SELECT goods_id, sum(count) as count_goods FROM `order_goods` WHERE order_id in ('.join(',',$orders).') group by `goods_id`';
			$a = IOMysqli::table($q);
			if(isset($a) && !empty($a)){				
				foreach($a as $v){
					Goods::goodsCountUpd($v['goods_id'],'-'.$v['count_goods']);
				}
			}
			return true;
		}
		
	}
	public static function postback($user_id, $offer_id, $status,$click_id){
		$q='SELECT url FROM `users_postbacks` WHERE `user_id`='.$user_id.' and `status_'.$status.'`=1 and `scope`="global" ORDER by id DESC limit 1';
		
		 $url=IOMysqli::one($q);
		 
		 $q='SELECT o.`offer_id`,o.`pay`,o.id,o.`user_status`,ul.subid1,ul.subid2,ul.subid3,oi.name FROM `orders` as o join clicks as c on o.click_id=c.click_id join users_links as ul on c.link_id=ul.id join offer_info as oi on o.offer_id=oi.offer_id WHERE o.click_id="'.$click_id.'" LIMIT 1';
		
		 $data = IOMysqli::row($q);
		
		// $link = $data['used_link'];
					 $url=preg_replace('/{click_id}/',$click_id,$url);
					 $url=preg_replace('/{status}/',$data['user_status'],$url);
					 $url=preg_replace('/{subid1}/',$data['subid1'],$url);
					 $url=preg_replace('/{subid2}/',$data['subid2'],$url);
					 $url=preg_replace('/{subid3}/',$data['subid3'],$url);
					 $url=preg_replace('/{lead_id}/',$data['lead_id'],$url);
					 $url=preg_replace('/{sum}/',$data['pay'],$url);
					 $url=preg_replace('/{offer}/',$data['name'],$url);
					 $url=preg_replace('/{campaign_id}/',$data['offer_id'],$url);
					 $url=preg_replace('/{currency}/',1,$url);

		return file_get_contents($url);
	}
	public function distributionGoodsByManagers($partner_id){		
		if(isset($partner_id) && !empty($partner_id) && filter_var($partner_id, FILTER_VALIDATE_INT)){
			$m_list = Partner::getManagersByPartnerID($partner_id);
			if(isset($m_list) && !empty($m_list)){
				$q = 'SELECT manager_id, count(id) as c FROM `manager_orders` WHERE manager_id in('.join(',',$m_list).') group by manager_id order by c limit 1';
				return IOMysqli::one($q);
			}else{
				return false;
			}			
		}else{
			return false;
		}
		
	}
	public static function forExport($fields, $period, $partner_id, $orders = array()){		
		if(isset($period) && !empty($period)){
			$p = array();
			if(isset($period['start']) && !empty($period['start'])){
				// $p[] = 'o.date >= '.$period['start'];
				$p[] = 'FROM_UNIXTIME(o.date, "%Y-%m-%d") >= "'.$period['start'].'" ';
			}
			if(isset($period['end']) && !empty($period['end'])){
				// $p[] = 'o.date <= '.$period['end'];
				$p[] = 'FROM_UNIXTIME(o.date, "%Y-%m-%d") <= "'.$period['end'].'" ';
			}
			$where = ' and '.join(' and ',$p);
		}else if(isset($orders) && !empty($orders) && is_array($orders)){
			$where = ' and o.id in('.join(',',$orders).')';
		}else{
			$where = '';
		}
		$q = 'SELECT o.id as g_id,FROM_UNIXTIME(o.date) as order_date,o.*,io.*,GROUP_CONCAT(g.name) as goods_names,GROUP_CONCAT(og.count) as goods_count FROM `orders` as o left join `info_orders` as io on io.order_id=o.id left join `order_goods` as og on og.order_id=o.id left join `goods` as g on og.goods_id=g.id left join `offers` as of on of.id=o.offer_id WHERE of.partner_id='.$partner_id.' '.$where. ' group by o.id';

		$data = IOMysqli::table($q);
		
		$for_export = array();
		$for_export[0][] = '№ заказа';
		if(isset($fields['date']) && !empty($fields['date'])){
			$for_export[0][] = 'дата';
			$date = 1;
		}else{
			$date = 0;
		}
		if(isset($fields['fio']) && !empty($fields['fio'])){
			$for_export[0][] = 'ФИО';
			$fio = 1;
		}else{
			$fio = 0;
		}
		if(isset($fields['phone']) && !empty($fields['phone'])){
			$for_export[0][] = 'Телефон';
			$phone = 1;
		}else{
			$phone = 0;
		}
		if(isset($fields['address']) && !empty($fields['address'])){
			$for_export[0][] = 'Страна';
			$for_export[0][] = 'Регион';
			$for_export[0][] = 'Город';
			$for_export[0][] = 'Улица';
			$for_export[0][] = 'Дом';
			$for_export[0][] = 'Квартира';
			$address = 1;
		}else{
			$address = 0;
		}
		if(isset($fields['type_delivery']) && !empty($fields['type_delivery'])){
			$for_export[0][] = 'Тип доставки';
			$type_delivery = 1;
		}else{
			$type_delivery = 0;
		}
		if(isset($fields['zip']) && !empty($fields['zip'])){
			$for_export[0][] = 'Индекс';
			$zip = 1;
		}else{
			$zip = 0;
		}
		if(isset($fields['sum']) && !empty($fields['sum'])){
			$for_export[0][] = 'Сумма заказа';
			$sum = 1;
		}else{
			$sum = 0;
		}
		if(isset($fields['wm']) && !empty($fields['wm'])){
			$for_export[0][] = 'ID вебмастера';
			$wm = 1;
		}else{
			$wm = 0;
		}
		if(isset($fields['time_delyvery']) && !empty($fields['time_delyvery'])){
			$for_export[0][] = 'Время доставки';
			$time_delyvery = 1;
		}else{
			$time_delyvery = 0;
		}
		$for_export[0][] = 'Статус заказа';
		$status = Partner::$status_array;
		//for($i = 0; $i<=count($data); $i++){	
			foreach($data as $v){
			
				$pod = array();			
				$pod[]= $v['g_id'];
					
				if(isset($date) && !empty($date)){
					$pod[] = $v['order_date'];
				}
				
				if(isset($fio) && !empty($fio)){
					$info = json_decode($v['params'], true);					
					$pod[] = $info[1];
				}
				
				if(isset($phone) && !empty($phone)){
					$info = json_decode($v['params'], true);
					$pod[] = $info[2];
				}
				if(isset($address) && !empty($address)){
					if(isset($v['country']) && !empty($v['country'])){
						$pod[] = $v['country'];
					}else{
						$pod[] = '-';
					}
					
					if(isset($v['state']) && !empty($v['state'])){
						$pod[] = $v['state'];
					}else{
						$pod[] = '-';
					}
					
					if(isset($v['city']) && !empty($v['city'])){ 
						$pod[] = $v['city'];
					}else{
						$pod[] = '-';
					}
					
					if(isset($v['street']) && !empty($v['street'])){
						$pod[] = $v['street'];
					}else{
						$pod[] = '-';
					}
					
					if(isset($v['house']) && !empty($v['house'])){
						$pod[] = $v['house'];
					}else{
						$pod[] = '-';
					}
					
					if(isset($v['flat']) && !empty($v['flat'])){
						$pod[] = $v['flat'];
					}else{
						$pod[] = '-';
					}
				}
										
					if(isset($zip) && !empty($zip)){
						if(isset($v['index']) && !empty($v['index'])){
							$pod[] = $v['index'];
						}else{
							$pod[] = '-';
						}
					}
					
					if(isset($sum) && !empty($sum)){
						if(isset($v['order_sum']) && !empty($v['order_sum'])){
							$pod[] = $v['order_sum'];
						}else{
							$pod[] = '-';
						}
					}
					
					if(isset($wm) && !empty($wm)){
						if(isset($v['user_id']) && !empty($v['user_id'])){
							$pod[] = $v['user_id'];
						}else{
							$pod[] = '-';
						}
					}
				
				$pod[]= $status[$v['status']]['name'];
				$for_export[] = $pod;				
			}
		//}
		
		return $for_export;
	}
	
	public static function quickEdit($update_string, $order_id, $table, $dt, $post=0){
		
		if(isset($update_string) && !empty($update_string)){
			$p = '';
			$p_up = '';
			if($table == 'orders'){
				if(isset($dt) && !empty($dt)){
					$st = ' ,`order_status_date`=UNIX_TIMESTAMP() ';
				}else{
					$st = ' ';
				}				
				$w_id = 'id';
				if(isset($post) && !empty($post)){
					$p = ' and `post_status_update`=0';
					$p_up = ', `post_status_update`=1';
				}
			}else{
				$st = ' ';
				$w_id = 'order_id';
			}
			if(is_array($order_id)){
				$s = ' in (';
				$sl = ')';
				$order_id = join(',',$order_id);
			}else{
				$s = '=';
				$sl = '';	
			}
			$q='UPDATE `'.$table.'` SET '.$update_string.$st.$p_up.' WHERE `'.$w_id.'`'.$s.$order_id.$sl.$p;
//                        var_dump($q);
//                        exit;
			return IOMysqli::query($q);
		}else{
			return false;
		}
		
	}
	public static function countOrdersByOffers($offers,$size = 0, $where=''){                
                if($where){
                    $pos = strpos($where, ' FROM ');
                    $where = substr($where, $pos);
                    $pos = strpos($where, ' LIMIT ');
                    $where = substr($where, 0, $pos);                    
                }else{
                    $where = 'from `orders` as o where offer_id in ('.$offers.')';
                }
		$q = 'select count(o.id) '.$where;
		
                $count = IOMysqli::one($q);
		if(isset($size) && !empty($size) && filter_var($size, FILTER_VALIDATE_INT)){
			$c = $size;
		}else{
			$c = 30;
		}
		$page = ceil($count/$c);
		
		$page_arr = array();
		for($i = 1; $i<$page; $i++){
			$page_arr[] = $i;
		}
		return $page_arr;
	}
	public static function traffs(){
		$q='SELECT * from `traffs` ';
		return IOMysqli::query($q);
	}
	public static function updateOrderSum($order_id, $return_sum = 0){
		if(isset($order_id) && !empty($order_id) && filter_var($order_id, FILTER_VALIDATE_INT)){
			$q = 'SELECT g.price, og.count FROM `goods` as g join `order_goods` as og on og.goods_id=g.id WHERE og.order_id='.$order_id;
			$p_c = IOMysqli::table($q);
			$order_sum = 0;
			foreach($p_c as $v){
				$order_sum += $v['price']*$v['count'];				
			}
			$q = 'SELECT delivery,sale_type,sale FROM `info_orders` WHERE order_id='.$order_id;
			
			$info_orders = IOMysqli::row($q);						
			$for_sale = $order_sum;
			if($info_orders['delivery'] == 1){
				//if(isset($delyvery_sum) && !empty($delyvery_sum)){
					//$order_sum += $delyvery_sum;
				//}else{
					$order_sum += 350;
				//}				
			}		
			$sale_sum = 0;
			switch($info_orders['sale_type']){
				case 1:
					$order_sum -= ($info_orders['sale']*0.01)*$order_sum;	
					$sale_sum = ($info_orders['sale']*0.01)*$for_sale;
				break;
				case 2:
					$order_sum -= $info_orders['sale'];
					$sale_sum = $info_orders['sale'];
				break;
			}
			$q = 'UPDATE `info_orders` SET `sale_sum`='.$sale_sum.' WHERE `order_id`='.$order_id;
			IOMysqli::query($q);
			$q = 'UPDATE `orders` SET `order_sum`='.$order_sum.' WHERE `id`='.$order_id;
			if($return_sum == 1){
				$resp = IOMysqli::query($q);
				if($resp == true){
					return $order_sum; 
				}else{
					return false;
				}
			}else{
				return IOMysqli::query($q);
			}
		}
	}
	public static function getInfoStatusOrder($offers_id){
		$q = 'SELECT `status`, count(id) as c FROM `orders` where offer_id in('.$offers_id.') group by `status`';
		$data = IOMysqli::table($q);
		$table = array();
		foreach($data as $v){
			$table[$v['status']] = $v['c'];			
		}
		return $table;
	}
	public static function getAdditionalPhoneByOrderId($order_id){
		if(isset($order_id) && !empty($order_id) && filter_var($order_id,FILTER_VALIDATE_INT)){
			$q = 'SELECT `phones` FROM `additional_phone_order` WHERE `order_id`='.$order_id.' limit 1';
			$pones = IOMysqli::one($q);
			if(isset($pones) && !empty($pones)){
				$arr = json_decode($pones, true);				
				$table = array();
				foreach($arr as $v){
					$table[] = $v;			
				}
				return $table;
			}else{
				return false;
			}
			
		}else{
				return false;
			}
	}
	public static function insertUpdateOrder($user_id,$fields, $goods, $partner = array()){		
		if(is_array($fields)){
			if(isset($fields['info_orders']['order_id']) && !empty($fields['info_orders']['order_id'])){
				$upd_str = array();
				foreach($fields['info_orders'] as $k=>$v){
					$upd_str[] = '`'.$k.'`="'.$v.'"';
				}
				$q='select id from `info_orders` WHERE `order_id`='.$fields['info_orders']['order_id'].' limit 1';
				$id = IOMysqli::one($q);				
				if(isset($id) && !empty($id)){
					$q='UPDATE `info_orders` SET '.join(', ',$upd_str).' WHERE `order_id`='.$fields['info_orders']['order_id'];
				}else{
					$q = 'INSERT INTO `info_orders` (`'.join('`,`',array_keys($fields['info_orders'])).'`) VALUES ("'.join('","',$fields['info_orders']).'")';											
				}
				IOMysqli::query($q);
				
				$fio=$fields['orders']['middle_name'].' '.$fields['orders']['first_name'].' '.$fields['orders']['last_name'];
			
				$phone=$fields['orders']['phone'];
				$status=$fields['orders']['status'];
				$comment=$fields['orders']['comment'];
				$q='select params, status, comment from `orders` WHERE `id`='.$fields['info_orders']['order_id'].' limit 1';

				$data = IOMysqli::row($q);
				
				$param_ar = array();
				if(isset($data) && !empty($data)){
					$param_ar = json_decode($data['params'], true);
				}
				if(isset($fio) && !empty($fio)){
					$param_ar[1] = $fio;					
				}
				if(isset($phone) && !empty($phone)){
					$param_ar[2] = $phone;
				}
				$u_s = '';
				if($data['status']!=$status){
					$u_s = ' `status_date`=UNIX_TIMESTAMP(),`status`="'.$status.'", ';
				}
				$c ='';
				if($data['comment']!=$comment){
					$c = ' `comment`="'.$comment.'", ';
				}
				$q='UPDATE `orders` SET '.$c.''.$u_s.'`params`=\''.json_encode($param_ar,JSON_UNESCAPED_UNICODE).'\'  WHERE `id`='.$fields['info_orders']['order_id'];
				
				IOMysqli::query($q);
				if(isset($fields['e_phone']) && !empty($fields['e_phone'])){
						$q = 'select id from additional_phone_order where order_id='.$fields['info_orders']['order_id'];
						$prov = IOMysqli::one($q);
						if(isset($prov) && !empty($prov)){
							$q = 'UPDATE `additional_phone_order` SET `phones`=\''.$fields['e_phone'][0].'\' WHERE `order_id`='.$fields['info_orders']['order_id'];
							IOMysqli::query($q);
						}else{
							$q = 'INSERT INTO `additional_phone_order`(`order_id`, `phones`) VALUES ('.$fields['info_orders']['order_id'].',\''.$fields['e_phone'][0].'\')';
							IOMysqli::query($q);
						}
						
					}
					return json_encode(array('responce'=>'success'));
				
			}else{
				
				$fio=$fields['orders']['middle_name'].' '.$fields['orders']['first_name'].' '.$fields['orders']['last_name'];			
				$phone=$fields['orders']['phone'];	
				if(isset($fields['orders']['order_id']) && !empty($fields['orders']['order_id'])){
					$order_id=$fields['orders']['order_id'];	
				}else{
					$order_id = '';
				}
				$order_params = json_encode(array(1=>$fio,2=>$phone,3=>$order_id),JSON_UNESCAPED_UNICODE);
				if(isset($fields['orders']['status']) && !empty($fields['orders']['status'])){
					$status = $fields['orders']['status'];
				}else{
					$status = 'new';
				}
				if(isset($fields['orders']['referer']) && !empty($fields['orders']['referer'])){
					$source = $fields['orders']['referer'];
				}else{
					$source = $_SERVER['HTTP_REFERER'];
				}
				if(isset($fields['orders']['link_id']) && !empty($fields['orders']['link_id'])){
					$link_id = $fields['orders']['link_id'];
				}else{
					$link_id = 0;
				}
				if(isset($fields['orders']['payments']) && !empty($fields['orders']['payments'])){
					$payments = $fields['orders']['payments'];
				}else{
					$payments = 0;
				}
				if(isset($fields['orders']['additional']) && !empty($fields['orders']['additional'])){
                                    $additional = $fields['orders']['additional'];
                                }else{
                                    $additional = '';
                                }
				$q = 'INSERT INTO `orders`(`offer_id`, `user_id`, `link_id`, `user_status`, `status_date`, `pay`, `pay_type`, `click_id`, `params`, `order_sum`, `date`, `status`, `order_status_date`, `payout_id`, `source`, `comment`, `ip`, `target`,`additional`) 
					VALUES (					
					'.$fields['orders']['offer_id'].',
					'.$user_id.',
					'.$link_id.',
					1,
					0,
					'.$payments.',
					1,
					"'.$fields['orders']['click'].'",
					\''.$order_params.'\',
					0,
					UNIX_TIMESTAMP(),
					"'.$status.'",
					UNIX_TIMESTAMP(),
					0,
					"'.$source.'",
					"",
					"'.$fields['orders']['ip'].'",
                                        "'.$fields['orders']['target'].'",
                                        "'.$additional.'"
					)';

					$order_id = IOMysqli::query($q, 1);

					if(isset($goods) && !empty($goods)){
						$set = array();
						foreach($goods as $k=>$v){
							// $set[] = '('.$order_id.','.$k.','.$v.')';
							Goods::addGoodsToOrder($order_id, $k, $v);
						}
						// $q = 'INSERT INTO `order_goods`(`order_id`, `goods_id`, `count`) VALUES '.join(',',$set);
						
						// IOMysqli::query($q);
						
						// foreach($goods as $k=>$v){
							//Goods::goodsCountUpd($k,$v);
						// }
						
					}

					if($partner['type'] == 'partner'){
						$manager_id = static::distributionGoodsByManagers($partner['id']);	
					}else if($partner['type'] == 'manager'){
						$manager_id = $partner['id'];
					}
					//присвоение заказа менеджеру
					// if(isset($manager_id) && !empty($manager_id) && filter_var($manager_id, FILTER_VALIDATE_INT)){
						// $q = 'INSERT INTO `manager_orders`(`manager_id`, `order_id`) VALUES ('.$manager_id.','.$order_id.')';
						// IOMysqli::query($q);
					// }			
					
					if(!$fields['info_orders']['delivery']){
						$delivery = 0;
					}else{
						$delivery = $fields['info_orders']['delivery'];
					}
					if(!$fields['info_orders']['sale']){
						$sale = 0;
					}else{
						$sale = $fields['info_orders']['sale'];
					}
					if(!$fields['info_orders']['sale_type']){
						$sale_type = 0;
					}else{
						$sale_type = $fields['info_orders']['sale_type'];
					}
					if(!$fields['info_orders']['country']){
						$country = '';
					}else{
						$country = $fields['info_orders']['country'];
					}
					if(!$fields['info_orders']['state']){
						$state = '';
					}else{
						$state = $fields['info_orders']['state'];
					}
					if(!$fields['info_orders']['city']){
						$city = '';
					}else{
						$city = $fields['info_orders']['city'];
					}
					if(!$fields['info_orders']['street']){
						$street = '';
					}else{
						$street = $fields['info_orders']['street'];
					}
					if(!$fields['info_orders']['house']){
						$house = '';
					}else{
						$house = $fields['info_orders']['house'];
					}
					if(!$fields['info_orders']['flat']){
						$flat = '';
					}else{
						$flat = $fields['info_orders']['flat'];
					}
					if(!$fields['info_orders']['index']){
						$index = 0;
					}else{
						$index = $fields['info_orders']['index'];
					}
					
					$q = 'INSERT INTO `info_orders`(`order_id`, `delivery`, `sale`,`sale_type`,`index`,`country`,`state`,`city`,`street`,`house`,`flat`) VALUES ('.$order_id.','.$delivery.','.$sale.','.$sale_type.','.$index
					.',"'.$country.'","'.$state.'","'.$city.'","'.$street.'","'.$house.'","'.$flat.'")';

					IOMysqli::query($q);
					static::updateOrderSum($order_id);
					if(isset($fields['e_phone']) && !empty($fields['e_phone'])){
						$q = 'select id from additional_phone_order where order_id='.$order_id;
						$prov = IOMysqli::one($q);
						if(isset($prov) && !empty($prov)){
							// $q = 'UPDATE `additional_phone_order` SET `phones`=\''.$order_id.'\' WHERE `order_id`='.$fields['info_orders']['order_id'];
							$q = 'UPDATE `additional_phone_order` SET `phones`=\''.$fields['info_orders']['order_id'].'\' WHERE `order_id`='.$order_id;
							IOMysqli::query($q);
						}else{
							$q = 'INSERT INTO `additional_phone_order`(`order_id`, `phones`) VALUES ('.$order_id.',\''.$fields['e_phone'][0].'\')';
							IOMysqli::query($q);
						}
					}
					if($order_id){
						return json_encode(array('responce'=>'success', "id"=>$order_id));
					}else{
						return json_encode(array('responce'=>'error','code'=>2));
					}
					
			}
		}else{
			return json_encode(array('responce'=>'error','code'=>1));
		}
		
	}
	public static function encryptionString($str){		
		if(isset($str) && !empty($str)){
			$iv = mcrypt_create_iv(
				mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
				MCRYPT_DEV_URANDOM
			);

			$encrypted = base64_encode(
				$iv .
				mcrypt_encrypt(
					MCRYPT_RIJNDAEL_128,
					hash('sha256', static::$key, true),
					$str,
					MCRYPT_MODE_CBC,
					$iv
				)
			);
			return $encrypted;
		}else{
			return false;
		}
		
	}
	public static function history($history_by, $value){		
		if(isset($history_by) && !empty($history_by) && isset($value) && !empty($value)){
			$q = 'SELECT id, '.$history_by.', FROM_UNIXTIME(`date`,"%d.%m.%Y %H:%i:%s") as date FROM `orders` WHERE `'.$history_by.'` like \'%'.$value.'%\'';			
			
                        return IOMysqli::table($q);			
		}else{
			return false;
		}
	}
	public static function historyAdr($adr){		
		if(isset($adr) && !empty($adr) && is_array($adr)){
			$search = array();
			foreach($adr as $k=>$v){
				$search[] = '`'.$k.'` like "%'.$v.'%"';
			}
			$q = 'SELECT count(id) FROM `info_orders` WHERE '.join(' and ',$search);
		
			return IOMysqli::one($q);			
		}else{
			return false;
		}
	}
	public static function getInfoOrderByIdAndPartnerId($order_id,$partner_id){					
		if(filter_var($order_id, FILTER_VALIDATE_INT) && filter_var($partner_id, FILTER_VALIDATE_INT)){
			if($partner_id == 11){
				$partner_id .= ',28,46';
			}
			$q='SELECT of.partner_id as partner_id, ord.id as order_id, FROM_UNIXTIME(ord.date,"%d.%m.%Y %H:%i:%s") as date,ord.comment, ord.status, ord.offer_id, ord.params, ord.order_sum, ord.ip FROM `orders` as ord join `offers` as of on of.id=ord.offer_id WHERE ord.id='.$order_id.' and of.partner_id in('.$partner_id.') limit 1';
			$info = IOMysqli::row($q);
			$ar = array();
			
			if($info != false){
				foreach($info as $k=>$v){
					if($k == 'params'){						
						$params = json_decode($v, true);
						list($middle_nane, $first_name, $last_name) = explode(' ',$params[1]);
						$ar['middle_name'] = $middle_nane;
						$ar['first_name'] = $first_name;
						$ar['last_name'] = $last_name;
						$ar['phone'] = $params[2];
						$ar['goods_id'] = $params[3];
						
						// $info = file_get_contents('http://eduscan.net/help/phone_ajax.php?num='.$params[2]);
						list($phone_number,$status,$operator,$stat) = explode('~', $info);
						if(isset($operator) && !empty($operator) && isset($stat) && !empty($stat)){
							$ar['phone_state'] = $stat;
							$ar['phone_operator'] = $operator;
						}else{
							$ar['phone_state'] = 'Error. неккоректный номер телефона';
							$ar['phone_operator'] = 'Error. неккоректный номер телефона';
						}
					}else if($k == 'status'){
						$status_ar = Partner::$status_array;
						//$status_now = '<option class="gruop_status_'.$status_ar[$v]['group'].'" value="'.$v.'" selected>'.$status_ar[$v]['name'].'</option>';
						$option = '';
						foreach($status_ar as $key => $val){
							if($key == $v){
								$option .= '<option class="gruop_status_'.$val['group'].'" value="'.$key.'" selected>'.$val['name'].'</option>';
							}else{
								$option .= '<option class="gruop_status_'.$val['group'].'" value="'.$key.'">'.$val['name'].'</option>';
							}							
						}
						$ar[$k] = $option;
					}else{
						$ar[$k] = $v;
					}
				}
				$q='SELECT * FROM `info_orders` WHERE order_id='.$order_id.' limit 1';
				$data = IOMysqli::row($q);
				
				if($data != false){
					foreach($data as $k=>$v){						
						if($k == 'delivery'){
							
							switch($v){
								case 0:
									$ar[$k] = '';
								break;
								case 1:
									$ar[$k] = 'checked';
								break;								
							}
						}else{
							$ar[$k] = $v;
						}
					}
				}else{
					$ar['sender'] = '';
					$ar['country'] = Ipgeo::countryByIp($ar['ip']);
					$ar['state'] = Ipgeo::regionByIp($ar['ip']);
					$ar['street'] = '';
					$ar['sity'] = Ipgeo::cityByIp($ar['ip']);
					$ar['house'] = '';
					$ar['flat'] = '';
					$ar['index'] = '';
					$ar['index'] = '';
				}
				return $ar;
			}else{
				return false;
			}
			
		}else{
			return false;
		}
		
	}

  public static function addOrder($encrypted){
	 
		if(isset($encrypted) && !empty($encrypted)){
			$data = base64_decode($encrypted);
			$iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

			$decrypted = rtrim(
				mcrypt_decrypt(
					MCRYPT_RIJNDAEL_128,
					hash('sha256', static::$key, true),
					substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
					MCRYPT_MODE_CBC,
					$iv
				),
				"\0"
			);
			
			$fields = explode('/',$decrypted);
			$params = array();
			foreach($fields as $f){
				list($k, $v) = explode('=', $f);				
				$params[$k] = $v;
			}
			
			if(isset($params['click_id']) && !empty($params['click_id'])){
				if(strlen($params['click_id']) == 32){
					$click_id = $params['click_id'];
					unset($params['click_id']);
				}else if(filter_var($params['click_id'], FILTER_VALIDATE_INT)){
					$user_id = $params['click_id'];
					$click_id = 0;
					$link_id = 0;
					$pay = 0;
					$pay_type = 0;
					if(isset($params['offer_id']) && !empty($params['offer_id'])){
						if(filter_var($params['offer_id'], FILTER_VALIDATE_INT)){
							$offer_id = $params['offer_id'];
							unset($params['offer_id']);
						}else{
							return 'error#4';
						}
					}else{
						return 'error#3';
					}
				}else{
					return 'error#2';
				}
			}else{
				return 'error#1';		
				
			}
			
			$source = $_SERVER['HTTP_REFERER'];
			$order_params = static::getParams($params);
			if($order_params == false){
				return 'error#5';
			}
			$q = 'select id from `orders`  where `offer_id`='.$offer_id.' and params like \''.$order_params.'\' limit 1';							 
			$prov = IOMysqli::one($q);
		
			if(isset($prov) && !empty($prov) && $prov != false){
				$q = 'INSERT INTO `double_orders`( `user_id`, `link_id`, `offer_id`, `params`, `click_id`, `order_id`)'. 
				'VALUES ('.$user_id.','.$link_id.','.$offer_id.',\''.$order_params.'\',"'.$click_id.'",'.$prov.')';
				IOMysqli::query($q);
				return 'error#6';
			}else{
				$q = 'INSERT INTO `orders`(`offer_id`, `user_id`, `link_id`, `user_status`, `status_date`, `pay`, `pay_type`, `click_id`, `params`, `order_sum`, `date`, `status`, `payout_id`, `source`, `comment`) 
					VALUES (					
					'.$offer_id.',
					'.$user_id.',
					'.$link_id.',
					1,
					0,
					'.$pay.',
					'.$pay_type.',
					"'.$click_id.'",
					\''.$order_params.'\',
					0,
					UNIX_TIMESTAMP(),
					"new",
					0,
					"'.$source.'",
					"")';
					
					return $order_id = IOMysqli::query($q,1);					
			}
			
			
		}else{
			return false;
		}
	  
	}

	public static function getParams($params){
		if(isset($params) && !empty($params) && is_array($params)){
			$param_code = array();
			foreach($params as $k => $v){
				$param_code[] = $k;
			}
			$q = 'SELECT id,field_code  from `offer_fields` WHERE field_code  in("'.join('","',$param_code).'")';
			$fields = IOMysqli::table($q);
			$params_jsoon = array();
			
			foreach($fields as $v){
				if($v['field_code'] == 'fio'){
					$params_jsoon[$v['id']] = urldecode($params[$v['field_code']]);
				}else{
					$params_jsoon[$v['id']] = $params[$v['field_code']];
				}
			}			
			ksort($params_jsoon);
			return json_encode($params_jsoon,JSON_UNESCAPED_UNICODE);
			
		}else{
			return false;
		}
	  
	}
  public static function filterOrders($fields,$hash, $order_by){
		$offers = Partner::offersPartnerByHash($hash);
		$g = '';
		if(isset($fields['manager']) && !empty($fields['manager']) && filter_var($fields['manager'], FILTER_VALIDATE_INT)){
			$j = 'join `manager_orders` as mo on o.id=mo.order_id';
		}else{
			$j = '';
		}
		if(isset($fields['shop']) && !empty($fields['shop'])){
			$j .= ' join `goods` as g on o.offer_id=g.offer_id ';
		}else{
			$j .= '';
		}
		$q = 'SELECT DISTINCT(o.id),io.post_status,o.*,FROM_UNIXTIME(o.`date`,"%d.%m.%Y %H:%i:%s") as d, FROM_UNIXTIME(o.`status_date`,"%d.%m.%Y %H:%i:%s") as s_d, FROM_UNIXTIME(o.`order_status_date`,"%d.%m.%Y %H:%i:%s") as o_s_d FROM `orders` as o join `order_goods` as og on og.order_id=o.id join info_orders as io on o.id=io.order_id '.$j.' WHERE ';
		$q1 = '';
		if(isset($fields['id_order']) && !empty($fields['id_order'])){
			if(filter_var($fields['id_order'], FILTER_VALIDATE_INT)){
				$q1 .= ' o.id='.$fields['id_order']. ' and o.`offer_id` in ('.$offers.')';
			}
		}else{
			if(isset($fields['shop']) && !empty($fields['shop'])){
				$q1 .= ' g.`shop`="'.$fields['shop'].'" and';
			}
			if(isset($fields['manager']) && !empty($fields['manager']) && filter_var($fields['manager'], FILTER_VALIDATE_INT)){
				$q1 .= ' mo.`manager_id`='.$fields['manager'].' and ';
			}
                    
			if(isset($fields['offer_id']) && !empty($fields['offer_id'])){
				if(filter_var($fields['offer_id'], FILTER_VALIDATE_INT)){
					if($fields['offer_id']!='all'){
						$q1 .= ' o.offer_id='.$fields['offer_id'];
					}else{
						$q1 .=' o.`offer_id` in ('.$offers.')';
					}
				}else{
					$q1 .=' o.`offer_id` in ('.$offers.')';
				}
			}else{
					$q1 .=' o.`offer_id` in ('.$offers.')';
				}
                               
                        if($fields['status']=='undefined' || $fields['status']=='null' || $fields['status']=='all'){
                            unset($fields['status']);
                        }
			if(isset($fields['status']) && !empty($fields['status'])){
				if($fields['status']!='all' || $fields['status']!='null' || $fields['status']!='undefined'){
					$q1 .= ' and o.status="'.$fields['status'].'"';
				}
			}
                         
                        if(isset($fields['target']) && !empty($fields['target'])){
				$q1 .= ' and o.target="'.$fields['target'].'"';
			}
			if(isset($fields['fio_buyer']) && !empty($fields['fio_buyer'])){
					$q1 .= ' and o.params like "%'.$fields['fio_buyer'].'%"';
				
			}
			if(isset($fields['target']) && !empty($fields['target'])){
					$q1 .= ' and o.target="'.$fields['target'].'"';
				
			}
			if(isset($fields['phone']) && !empty($fields['phone'])){
                                    if($fields['phone'][0] == '8' || $fields['phone'][0] == '7'){
                                        $fields['phone']=  substr($fields['phone'],1);
                                    }else if($fields['phone'][0] == '+'){
                                        $fields['phone'] =  substr($fields['phone'], 2);
                                    }
					$q1 .= ' and o.params like "%'.$fields['phone'].'%"';
				
			}
			if(isset($fields['goods_id']) && !empty($fields['goods_id'])){
				if(filter_var($fields['goods_id'], FILTER_VALIDATE_INT)){
					$q1 .= ' and og.goods_id like "%'.$fields['goods_id'].'%"';
				}
			}
			
			if(isset($fields['date_start']) && !empty($fields['date_start'])){
				$date_start_parce = explode('.',$fields['date_start']);
				$date_start = mktime(0, 0, 0, $date_start_parce[1], $date_start_parce[0], $date_start_parce[2]);
				if(isset($fields['date_end']) && !empty($fields['date_end'])){
					$date_end_parce = explode('.',$fields['date_end']);
					$date_end = mktime(23, 59, 59, $date_end_parce[1], $date_end_parce[0], $date_end_parce[2]);				
				}else{
					$date_end = mktime(23, 59, 59, $date_start_parce[1], $date_start_parce[0], $date_start_parce[2]);
				}
				$q1 .= ' and o.date BETWEEN "'.$date_start.'" AND "'.$date_end.'"';
			}
			if(isset($fields['wm_id']) && !empty($fields['wm_id'])){
				if(filter_var($fields['wm_id'], FILTER_VALIDATE_INT)){
					if($fields['wm_id']!='all'){
						$q1 .= ' and o.user_id='.$fields['wm_id'];
					}
				}
			}
			
			if(isset($fields['sum_start']) && !empty($fields['sum_start'])){
				if(filter_var($fields['sum_start'], FILTER_VALIDATE_INT)){
					$q1 .= ' and o.order_sum >= '.$fields['sum_start'];
				}
			}
			if(isset($fields['sum_end']) && !empty($fields['sum_end'])){
				if(filter_var($fields['sum_end'], FILTER_VALIDATE_INT)){
					$q1 .= ' and o.order_sum <= '.$fields['sum_end'];
				}
			}			
			
		}
		if(isset($q1) && !empty($q1)){
				// $query = $q.$q1.' ORDER BY `date` DESC';
				$query = $q.$q1;
                                $query2 = 'SELECT count(DISTINCT(o.id)) as ct FROM `orders` as o join `order_goods` as og on og.order_id=o.id join info_orders as io on o.id=io.order_id '.$j.' WHERE '.$q1;
			}else{
				// $query = $q.' `offer_id` in ('.$offers.') ORDER BY `date` DESC';
				$query = $q.' o.`offer_id` in ('.$offers.')';
		}
		if(isset($order_by) && !empty($order_by) && is_array($order_by)){
			$query .= ' ORDER BY o.`'.$order_by['sort']['col'].'` '.$order_by['sort']['type'];
			if($order_by['sort']['type'] == 'DESC'){
				$sort_type = 'ASC';
			}else{
				$sort_type = 'DESC';
			}
		}else{
                    
			$query .= ' ORDER BY o.`date` DESC';
			$sort_type = 'DESC';
		}
                    if(isset($fields['limit']) && !empty($fields['limit'])){
						if($fields['size']){
							$size = $fields['size'];
						}else{
							$size = 30;
						}
							
                        $o = ($fields['limit']*$size)-$size;
                        $query .= ' LIMIT '.$o.','.$size;
                    }else{
						if($fields['size']){
							$size = $fields['size'];
						}else{
							$size = 30;
						}
                        $query .= ' LIMIT '.$size;
                    }
//			 var_dump($query);
//			 exit;
			$all_orders = IOMysqli::table($query);
                        $count = IOMysqli::one($query2);
//			 var_dump($count);
//			 exit;
			$table='<table>
				<tr>
					<th><input type="checkbox" class="select_all_orders" data-action="select"></th>	
					<th class="sort" data-order_by_type="'.$sort_type.'" data-order_by_col="date">дата</th>
					<th class="t offer_id">id оффера</th>
					<th class="t wm_id">id вебмастера</th>
					<th class="t pay">ставка</th>
					<th class="t wm_status">статус вебмастера</th>
					<th class="t date_status">дата статуса</th>
					<th class="t payout_id">выплата</th>
					<th class="sort" data-order_by_type="'.$sort_type.'" data-order_by_col="id">id заказа</th>
					<th>ФИО</th>
					<th>телефон</th>
					<th>товар</th>				
					<th class="sort" data-order_by_type="'.$sort_type.'" data-order_by_col="order_sum">сумма заказа</th>				
					<th class="sort" data-order_by_type="'.$sort_type.'" data-order_by_col="status">статус</th>
					<th class="sort" data-order_by_type="'.$sort_type.'" data-order_by_col="order_status_date">последние изменение статуса</th>
					<th>комментарий</th>				
					<th class="sort" data-order_by_type="'.$sort_type.'" data-order_by_col="target">ресурс</th>	
					<th>статус почты</th>					
				</tr>
				';
		if($all_orders != NULL){			
				$tr ='';
				
			
				foreach($all_orders as $orders){
					switch($orders['user_status']){
						case 0:
							$status_wm = 'отклонен';
						break;
						case 1:
							$status_wm = 'в холде';
						break;
						case 2:
							$status_wm = 'подтвержден';
						break;
					}
					$params = json_decode($orders['params'], true);
					$fio = $params[1];
					$phone = $params[2];					
					unset($params[1]);
					unset($params[2]);
					unset($params[3]);
					$goods = json_decode($orders['goods_id'], true);	
					if(isset($goods) && !empty($goods)){
						$q='SELECT name, price, currency FROM `goods` WHERE `id` in ('.join(',',$goods).')';
						$goods_info = IOMysqli::table($q);					
						
						if($goods_info != false){
							$goods_text = '';
						foreach($goods_info as $v){
							switch($v['currency']){
								case 1:
									$type_currency = '<span class="rub">Р</span>';
								break;
								case 2:
									$type_currency = '$';
								break;
								case 3:
									$type_currency = '&#8364;';
								break;
							}
							$goods_text = '<p>'.$v['name'].'('.$v['price'].$type_currency.')</p><br>';
						}
						}else{
							$goods_text = '-';
							/*$goods_name='-';
							$goods_price='-';							
							$goods_currency='-';							
							*/
						}						
						}else{
							$goods_text = '-';
							/*$goods_name='-';
							$goods_price='-';							
							$goods_currency='-';							
							*/
						}	
					
					// $info_params = '<p class="goods_name">товар:<span>'.$goods_name.'</span>;</p><p class="goods_price">цена:<span>'.$goods_price.$type_currency.'</span>;</p>';
					$goods_ar = Goods::getArrGoodsByOrders($orders['id']);
					$goods_info = Goods::getGoodsInfoByIds($goods_ar,$orders['id']);	
					
					$ip = '';
					foreach($goods_info as $v){
						$ip[] = $v['name'];
					}
					$info_params = join(', ',$ip);
					// var_dump($info_params);
					// exit;
					// if(count($params)>0){
						// $q='SELECT * FROM `offer_fields` WHERE `id` in ('.join(',',array_keys($params)).')';
						// $fields = IOMysqli::table($q);						
						// foreach($fields as $f){
							// $info_params .= '<p>'.$f['field_name'].':'.$params[$f['id']].';</p> ';
						// }						
					// }
					$status = '<span class="gruop_status_'.Partner::$status_array[$orders['status']]['group'].'">'.Partner::$status_array[$orders['status']]['name'].'</span>';

					$tr .= '<tr data-order_id="'.$orders['id'].'">'.
					'<td><input type="checkbox" class="select_order" value="'.$orders['id'].'"></td>'.
					'<td>'.$orders['d'].'</td>'.
					'<td class="t offer_id">'.$orders['offer_id'].'</td>'.
					'<td class="t wm_id">'.$orders['user_id'].'</td>'.
					'<td class="t pay">'.$orders['pay'].'</td>'.
					'<td class="t wm_status">'.$status_wm.'</td>'.
					'<td class="t date_status">'.$orders['s_d'].'</td>'.
					'<td class="t payout_id">'.$orders['payout_id'].'</td>'.
					'<td>'.$orders['id'].'</td>'.
					'<td>'.$fio.'</td>'.
					'<td><span>'.$phone.'</span></td>'.
					'<td>'.$info_params.'</td>'.
					'<td>'.$orders['order_sum'].'</td>'.
					'<td>'.$status.'</td>'.
					'<td>'.$orders['o_s_d'].'</td>'.
					'<td><textarea>'.$orders['comment'].'</textarea></td>'.
					'<td>'.$orders['target'].'</td>'.
					'<td>'.$orders['post_status'].'</td>'.
					'</tr>';				
				}
				
				$table.=$tr.'</table>';
//                                $page = ceil($count/30);
                                $pages = Order::countOrdersByOffers($offers, 0, $query);
                               
                                if(count($pages) >1){
                                    $page = '';
                                    foreach($pages as $v){
            //				$page .= '<a href="/partner_cabinet?page='.$v.'&size='.$size.'">'.$v.'</a>';
//                                        if($v == 1){
//                                            $cl = 'class="sel"';
//                                        }else{
//                                            $cl = '';
//                                        }    
                                        $page .= '<a '.$cl.' data-page="'.$v.'" data-size="30">'.$v.'</a>';
                                    }    
                                }else{
                                    $page = '';
                                }
                            
                                return array($table, $page);
		}else{
			return $table.= '<td colspan="15">По данному фильтру заказов нет</td></table>';
		}
	
	}
}