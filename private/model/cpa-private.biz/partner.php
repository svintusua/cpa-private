<?php
class Partner extends Model {
	public static $status_array = array(
		'new' => array('name'=>'Новый','group'=>1,'user_status'=>1),
		'new_hot' => array('name'=>'Новый горячий','group'=>1,'user_status'=>1),
		'new_cold' => array('name'=>'Новый холодный','group'=>1,'user_status'=>1),
		'exact_time' => array('name'=>'Точное время','group'=>1,'user_status'=>1),
		// 'call' => array('name'=>'Звонок с сайта','group'=>1,'user_status'=>1),
		// 'new_frod' => array('name'=>'Новый подозрение на фрод','group'=>1,'user_status'=>1),
		
		// 'adopted' => array('name'=>'Принят','group'=>2,'user_status'=>2),
		// 'call_back' => array('name'=>'Перезвонить','group'=>2,'user_status'=>1),		
		// 'pre_payment' => array('name'=>'Ждем предоплату','group'=>2,'user_status'=>1), 
		// 'coordinated' => array('name'=>'На согласовании','group'=>2,'user_status'=>1),
		// 'resale' => array('name'=>'Вторичка','group'=>2,'user_status'=>1),
		// 'call_not' => array('name'=>'Недозвон','group'=>2,'user_status'=>1),
		'prepayment' => array('name'=>'Предоплата','group'=>2,'user_status'=>1),
		'spb_courier' => array('name'=>'Спб курьер','group'=>2,'user_status'=>1),
		'pending' => array('name'=>'Отложено','group'=>2,'user_status'=>1),
		'on_check' => array('name'=>'На проверку','group'=>2,'user_status'=>1),
		'confirmed' => array('name'=>'Подтвержден','group'=>2,'user_status'=>2),
		
		// 'courier' => array('name'=>'Курьер','group'=>3),
		// 'completed' => array('name'=>'Подготовлен в комплектацию','group'=>3,'user_status'=>2),
		// 'equipped_post' => array('name'=>'Укомплектован почта','group'=>3,'user_status'=>2),
		// 'equipped_kc' => array('name'=>'Укомплектован КС','group'=>3,'user_status'=>2),
		// 'equipped_k_city' => array('name'=>'Укомплектован курьер по городу','group'=>3,'user_status'=>1),
		// 'waiting_goods' => array('name'=>'Ждет поступления товара','group'=>3,'user_status'=>1),
		// 'send_for_date' => array('name'=>'Отложено','group'=>3,'user_status'=>1),
		'on_sending' => array('name'=>'На отправку','group'=>3,'user_status'=>2),
		'equipped' => array('name'=>'Укомплектовано','group'=>3,'user_status'=>2),
		// 'deferred' => array('name'=>'Отложено','group'=>3,'user_status'=>1),
		
		'sent' => array('name'=>'Отправлено','group'=>4,'user_status'=>2),
		'delivered' => array('name'=>'Доставлено','group'=>4,'user_status'=>2),
		'awarded' => array('name'=>'Вручено','group'=>4,'user_status'=>2),
		// 'collector' => array('name'=>'Коллектор','group'=>4,'user_status'=>2),
		// 'get_to_delivered' => array('name'=>'Передан в доставку','group'=>4,'user_status'=>2),
		// 'pay_date' => array('name'=>'Выкупит в определенную дату','group'=>4,'user_status'=>2),
		// 'redial_to_navicopa' => array('name'=>'Автодозвон до невыкупа','group'=>4,'user_status'=>2),
		
		// 'made' => array('name'=>'Выполнен','group'=>5,'user_status'=>2),
		'money_received' => array('name'=>'Деньги получены','group'=>5,'user_status'=>2),		
		// 'payed' => array('name'=>'Оплачено','group'=>5,'user_status'=>2),		
		// 'return' => array('name'=>'Возврат','group'=>5,'user_status'=>2),		
		// 'return_get' => array('name'=>'Возврат получен','group'=>5,'user_status'=>2),		
		// 'payed_courier' => array('name'=>'Оплачено курьер по городу','group'=>5,'user_status'=>2),		
		// 'refund_courier' => array('name'=>'Возврат курьер по городу','group'=>5,'user_status'=>0),		
		
		// 'сancelled_call_not' => array('name'=>'Отменен по недозвону','group'=>6,'user_status'=>0),
		// 'double_unconfirmed' => array('name'=>'Не подтвержден дважды','group'=>6,'user_status'=>0),		
		// 'repeal' => array('name'=>'Отмена','group'=>6,'user_status'=>0),		
		// 'curiosities_double' => array('name'=>'Неформат/дубль','group'=>6,'user_status'=>0),		
		// 'not_satisfied_price' => array('name'=>'Не устроила цена','group'=>6,'user_status'=>0),		
		// 'not_satisfied_delivery' => array('name'=>'Не устроила доставка','group'=>6,'user_status'=>0),		
		// 'bought_elsewhere' => array('name'=>'Купил в др. месте','group'=>6,'user_status'=>0),		
		// 'cooperation' => array('name'=>'Сотрудничество','group'=>6,'user_status'=>0),		
		'claims' => array('name'=>'Претензии','group'=>6,'user_status'=>0),
		'autofac' => array('name'=>'Автофейк','group'=>6,'user_status'=>0),
		'cancelled_failure' => array('name'=>'Отменен (отказ)','group'=>6,'user_status'=>0),
		'call_not' => array('name'=>'Недозвон','group'=>6,'user_status'=>0),
		'cancelled_after_confirmation' => array('name'=>'Отменен после подтверждения','group'=>6,'user_status'=>0),
		'frod_proven' => array('name'=>'Фрод проверенный','group'=>6,'user_status'=>0),
		
		'return' => array('name'=>'Возврат','group'=>7,'user_status'=>2),
		'return_received' => array('name'=>'Возврат получен','group'=>7,'user_status'=>2)
		
		
		
	);
	
	public static function getCountStatisticOrders($offers_id){
		$q = 'SELECT count(id) FROM `orders` WHERE `offer_id` in ('.$offers_id.')';
		$all_count_orders = IOMysqli::one($q);	
		if($all_count_orders != false){
			
		}else{
			
		}
	}
	public static function addOffer($fields){
		if(isset($fields) && !empty($fields) && is_array($fields)){
			$q = 'INSERT INTO `offers` (`'.join('`,`',array_keys($fields)).'`) VALUES ("'.join('","',$fields).'")';
			return IOMysqli::query($q, 1);	
		}else{
			return false;
		}
	}
	public static function offersPartnerByHash($hash){
		if(strlen($hash) == 32){
			$user_info = User::getInfoByHash($hash);
			if($user_info['type'] == 2){
				$p_id = $user_info['id'];
			}else if($user_info['type'] == 3){
				$q = 'SELECT GROUP_CONCAT(`partner_id`) FROM `managers` WHERE `manager_id`='.$user_info['id'];
				$p_id = IOMysqli::one($q);
			}
			if($p_id == 11){
				$p_id .=',28,46';
			}
			$q = 'SELECT GROUP_CONCAT(id) FROM `offers` WHERE `partner_id` in ('.$p_id.')';

			return IOMysqli::one($q);			
		}else{
			return false;
		}
	}
        public static function getNameIDoffersPartnerByHash($hash){
		if(strlen($hash) == 32){
			$user_info = User::getInfoByHash($hash);
			if($user_info['type'] == 2){
				$p_id = $user_info['id'];
			}else if($user_info['type'] == 3){
				$q = 'SELECT GROUP_CONCAT(`partner_id`), FROM `managers` WHERE `manager_id`='.$user_info['id'];
				$p_id = IOMysqli::one($q);
			}
			if($p_id == 11){
				$p_id .=',28,46';
			}
			$q = 'SELECT id, name FROM `offers` WHERE `partner_id` in ('.$p_id.') ORDER BY name ASC';

			return IOMysqli::table($q);			
		}else{
			return false;
		}
	}
	public static function offersPartnerByID($id){
		if(filter_var($id, FILTER_VALIDATE_INT)){
			if($id == 11){
				$id .=',28,46';
			}
			$q = 'SELECT GROUP_CONCAT(id) FROM `offers` WHERE `partner_id` in ('.$id.')';
			return IOMysqli::one($q);			
		}else{
			return false;
		}
	}
	public static function getPartnerIDByManagerId($id){
		if(filter_var($id, FILTER_VALIDATE_INT)){
			$q = 'SELECT `partner_id` FROM `managers` WHERE `manager_id`='.$id;
			return IOMysqli::one($q);			
		}else{
			return false;
		}
	}
	public static function getManagersByPartnerID($id){
		if(filter_var($id, FILTER_VALIDATE_INT)){
			$q = 'SELECT `manager_id` FROM `managers` WHERE `partner_id`='.$id;
			
			$manager_all = IOMysqli::table($q);			
			$managers = array();
			foreach($manager_all as $v){
				$managers[] = $v['manager_id'];				
			}
			return $managers;
		}else{
			return false;
		}
	}
	public static function getWMFromOffer($offers_id){
			$user_arr = array();
			$q = 'SELECT DISTINCT  user_id FROM `orders` WHERE `offer_id` in('.$offers_id.')';
			$user_id = IOMysqli::table($q);
			foreach($user_id as $u_id){	
				$user_arr[] = $u_id['user_id'];
			}
			return $user_arr;			
	}
	public static function getInfoOrdersByOffer($offers_id,$page, $manager = 0, $manager_type = 0, $c = 0, $status){
		if(isset($c) && !empty($c) && filter_var($c, FILTER_VALIDATE_INT)){
				$size = $c;
			}else{
				$size = 30;
		}
		if(isset($page) && !empty($page) && filter_var($page, FILTER_VALIDATE_INT)){			
			$max = $page*$size;
			$min = $max-$size;
			$limit = $min.','.$max;
		}else{
			$limit = $size;
		} 
		if($status){
			$s=' and status="'.$status.'"';
		}else{
			$s = '';
		}
		$q = 'SELECT io.post_status,o.*,FROM_UNIXTIME(o.`date`,"%d.%m.%Y %H:%i:%s") as d, FROM_UNIXTIME(o.`status_date`,"%d.%m.%Y %H:%i:%s") as s_d, FROM_UNIXTIME(o.`order_status_date`,"%d.%m.%Y %H:%i:%s") as o_s_d FROM `orders` as o join info_orders as io on o.id=io.order_id WHERE o.`offer_id` in ('.$offers_id.') '.$s.' ORDER BY o.`date` DESC LIMIT '.$limit;

		$all_orders = IOMysqli::table($q);
		if($all_orders != NULL){
			$table='<table>
			<tr>
					<th><input type="checkbox" class="select_all_orders" data-action="select"></th>
					<th class="sort" data-order_by_type="DESC" data-order_by_col="date">дата</th>
					<th class="t offer_id">id оффера</th>
					<th class="t wm_id">id вебмастера</th>
					<th class="t pay">ставка</th>
					<th class="t wm_status">статус вебмастера</th>
					<th class="t date_status">дата статуса</th>
					<th class="t payout_id">выплата</th>
					<th class="sort" data-order_by_type="DESC" data-order_by_col="id">id заказа</th>
					<th>ФИО</th>
					<th>телефон</th>
					<th>товар</th>				
					<th class="sort" data-order_by_type="DESC" data-order_by_col="order_sum">сумма заказа</th>				
					<th class="sort" data-order_by_type="DESC" data-order_by_col="status">статус</th>
					<th class="sort" data-order_by_type="DESC" data-order_by_col="order_status_date">последние изменение статуса</th>
					<th>комментарий</th>				
					<th>местное время</th>				
					<th class="sort" data-order_by_type="DESC" data-order_by_col="target">ресурс</th>				
					<th>статус почты</th>				
				</tr>
				';
				$tr ='';
				$q = '';
				$order_arr = array();
				if($manager != 0 && $manager_type == 3){
					$q = 'select order_id from `manager_orders` where manager_id='.$manager;
					$oi = IOMysqli::table($q);
					
					foreach($oi as $v){
						$order_arr[] = $v['order_id'];
					}
				}else if($manager != 0 && $manager_type == 2){
					$q = 'select mo.manager_id,mo.order_id from `manager_orders` as mo join managers as m on m.manager_id = mo.manager_id where m.partner_id='.$manager;
					
					$oi = IOMysqli::table($q);
					
					$m_color = array();
					foreach($oi as $v){
						$order_arr[$v['order_id']] = $v['manager_id'];
						$m_color[$v['manager_id']] = rand(130,255).','.rand(130,255).','.rand(130,255).',0.6';
					}
				}
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
					$goods_id = $params[3];
					unset($params[1]);
					unset($params[2]);
					unset($params[3]);
					if(filter_var($goods_id, FILTER_VALIDATE_INT)){
						$q='SELECT name, price, currency FROM `goods` WHERE `id`='.$goods_id;
						$goods_info = IOMysqli::row($q);
						
						if($goods_info != false){
							$goods_name=$goods_info['name'];
							$goods_price=$goods_info['price'];							
							$goods_currency=$goods_info['currency'];
							switch($goods_currency){
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
						}else{
							$goods_name='-';
							$goods_price='-';							
							$goods_currency='-';							
						}
					}
					$goods_ar = Goods::getArrGoodsByOrders($orders['id']);
				
					$goods_info = Goods::getGoodsInfoByIds($goods_ar,$orders['id']);
					
					 $ip = '';
					foreach($goods_info as $v){
						$ip[] = $v['name'];
					}
					$info_params = join(', ',$ip);
				
					/*$info_params = '<p class="goods_name">товар:<span>'.$goods_name.'</span>;</p><p class="goods_price">цена:<span>'.$goods_price.$type_currency.'</span>;</p>';
					if(count($params)>0){
						$q='SELECT * FROM `offer_fields` WHERE `id` in ('.join(',',array_keys($params)).')';
						$fields = IOMysqli::table($q);						
						foreach($fields as $f){
							$info_params .= '<p>'.$f['field_name'].':'.$params[$f['id']].';</p> ';
						}						
					}*/
					if($manager_type == 3 && in_array($orders['id'],$order_arr)){
						$style = 'style="background: rgba(100,240,163,0.5);"';
					}else if($manager_type == 2){
						$color = $m_color[$order_arr[$orders['id']]];
						$style = 'style="background: rgba('.$color.');"';
						$title = 'title="оператор №'.$order_arr[$orders['id']].'"';
					}else{
						$style = '';
						$title = '';
					}
					$status = '<span class="gruop_status_'.static::$status_array[$orders['status']]['group'].'">'.static::$status_array[$orders['status']]['name'].'</span>';
					
					$geo = Ipgeo::geoByIp($$orders['ip']['ip']);
					$timezone = json_decode($geo, true)['region']['timezone'];
					date_default_timezone_set($timezone);
					$time = date('d.m.Y H:s');
					
					$tr .= '<tr '.$style.' data-order_id="'.$orders['id'].'" '.$title.'>'.
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
					'<td>'.$orders['order_sum'].' Р</td>'.
					'<td>'.$status.'</td>'.
					'<td>'.$orders['o_s_d'].'</td>'.
					'<td><textarea>'.$orders['comment'].'</textarea></td>'.
					'<td>'.$time.'</td>'.
					'<td>'.$orders['target'].'</td>'.
					'<td>'.$orders['post_status'].'</td>'.
					'</tr>';
				}
				return $table.=$tr.'</table>';
				
		}else{
			return false;
		}
	}
	
	public static function addManager($partner_id, $manadger_info = array()){
		if(is_array($manadger_info) && filter_var($partner_id, FILTER_VALIDATE_INT)){
			$arr = array('a', 'b', 'c', 'd', 'e', 'f',
                     'g', 'h', 'i', 'j', 'k', 'l',
                     'm', 'n', 'o', 'p', 'r', 's',
                     't', 'u', 'v', 'x', 'y', 'z',
                     'A', 'B', 'C', 'D', 'E', 'F',
                     'G', 'H', 'I', 'J', 'K', 'L',
                     'M', 'N', 'O', 'P', 'R', 'S',
                     'T', 'U', 'V', 'X', 'Y', 'Z',
                     '1', '2', '3', '4', '5', '6',
                     '7', '8', '9', '0');

			$password = "";

			for ($i = 0; $i < 8; $i++) {
				$index = rand(0, count($arr) - 1);
				$password .= $arr[$index];
			}
			$q = 'INSERT INTO `users`(`email`, `password`, `date`, `activate`, `ban`, `type`) VALUES ("'.$manadger_info['email'].'","'.md5(md5($password+'HyBmna194#$@djJ')).'",UNIX_TIMESTAMP(),1,0,3)';
			$id = IOMysqli::query($q,1);			
			$q = 'INSERT INTO `partner_info`(`user_id`, `surname`, `name`, `lastname`, `phone`, `about`) VALUES ('.$id.',"'.$manadger_info['surname'].'","'.$manadger_info['name'].'","'.$manadger_info['lastname'].'","'.$manadger_info['phone'].'","'.$manadger_info['about'].'")';
			IOMysqli::query($q);
			$q = 'INSERT INTO `managers`(`partner_id`, `manager_id`) VALUES ('.$partner_id.','.$id.')';			
			$msg = '<html>
            <head>
            <meta charset="urf-8"/>
            <title>Востановление пароля</title>
            </head>
				<body style="width:100%;height:100%;">
					<div id="content" style="width:85%;border:2px solid #fff;margin: auto;position: relative;">					
					<div class="text" style="width:100%;box-sizing: border-box;padding:10px;color: #4a4a4a;">
						<p>Ваш логин: <b style="color:#64f0a3;">'.$manadger_info['email'].'</b></p>
						<p>Ваш пароль: <b style="color:#64f0a3;">'.$password.'</b></p>
					</div>
				</div>
            </body>
            </html>';
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers  .= "Content-type: text/html; charset=utf-8 \r\n";
            $headers .= "From: Приватная партнерская программа <no-reply@cpa-private.biz>\r\n"; 
            $rrr=Smtpmails::smtpmail($manadger_info['email'], "Регистрация на ППП", $msg, $headers);
			return IOMysqli::query($q);
		}else{
			return false;
		}
	}
/*
	
	public static function belongsOrderUser($order_id, $hash){
		if(strlen($hash) == 32 && filter_var($order_id, FILTER_VALIDATE_INT)){
			$offers = Partner::offersPartnerByHash($cookie);
			$q = 'SELECT * from order where id='.$order_id.' and offer_id in('.$offers.') limit 1';
			$order = IOMysqli::row($q);
			if($order != false){
				
			}else{
				return false;
			}
		}else{
			return false
		}
	}*/
}
