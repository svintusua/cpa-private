<?php
class Goods extends Model {

	public static function deleteGoods($orders = array()){
		if(isset($orders) && !empty($orders) && is_array($orders)){
			$q = 'DELETE FROM `goods` WHERE id in ('.join(',',$orders).')';
			return IOMysqli::query($q);			
		}
		
	}
	public static function getApicalByGoodsId($goods_id){
		if(isset($goods_id) && !empty($goods_id)){
			$q = 'SELECT * FROM `goods` WHERE `apical`='.$goods_id;
			return IOMysqli::query($q);			
		}else{
			return false;
		}
		
	}
	public static function getGoodsByOffer($offer_id){
		//if(filter_var($offer_id, FILTER_VALIDATE_INT)){
			$q = 'select id, name from `goods` where offer_id in ('.$offer_id.') and `apical`=0 ORDER BY `id` DESC';
			return IOMysqli::table($q);
		//}else{
	//		return false;
	//	}
	}
	public static function setCategory($name){
		if(isset($name) && !empty($name)){
			$q = 'INSERT INTO `category`(`name`) VALUES ("'.$name.'")';
			return IOMysqli::query($q, 1);
		}else{
			return false;
		}
	}
	public static function delGoods($id){
		if(isset($id) && !empty($id) && filter_var($id, FILTER_VALIDATE_INT)){
			$q = 'DELETE FROM `goods` WHERE id='.$id;
			return IOMysqli::query($q);
		}else{
			return false;
		}
	}
	public static function getCategory(){
		$q = 'SELECT * FROM `category`';
		return IOMysqli::table($q);
	}
	public static function goodsCountUpd($goods_id,$count,$simfol){
		if(filter_var($goods_id, FILTER_VALIDATE_INT)){
			//$q = 'Select sum(`count`) from `order_goods` where goods_id='.$goods_id;
			//$count = IOMysqli::one($q);
			// if($count>0){
				// $simfol = '-';
			// }else if($count<0){
				// $simfol = '+';
			// }
			$q = 'SELECT `apical` FROM `goods` WHERE `id`='.$goods_id;
			$apical = IOMysqli::one($q);
			if($apical == 0){
				$g = $goods_id;
			}else{
				$g = $apical;
			}
			$q = 'UPDATE `goods` SET `count`=`count`-'.$count.' WHERE id='.$g;
			return IOMysqli::query($q);
		}
	}
	public static function addGoodsToOrder($order_id, $goods_id, $count){
		
		// if(filter_var($order_id, FILTER_VALIDATE_INT) && filter_var($goods_id, FILTER_VALIDATE_INT) && filter_var($count, FILTER_VALIDATE_INT)){
			$q = 'SELECT `apical` FROM `goods` WHERE `id`='.$goods_id;
			$apical = IOMysqli::one($q);
			if($apical == 0){
				$g = $goods_id;
			}else{
				$g = $apical;
			}
			
			$q = 'Select id, count from `order_goods` where order_id='.$order_id.' and goods_id='.$goods_id;
			$prov = IOMysqli::row($q);
			
			if(isset($prov) && !empty($prov)){
				if($count>$prov['count'] && $count!=0){
					$c = $count-$prov['count'];
					$q = 'UPDATE `order_goods` SET `count`=`count`+'.$c.' WHERE order_id='.$order_id.' and goods_id='.$goods_id;
					IOMysqli::query($q);	
					$q = 'UPDATE `goods` SET `count`=`count`-'.$c.' WHERE id='.$g;
					IOMysqli::query($q);					
				}else if($count<$prov['count'] && $count!=0){
					$c = $prov['count']-$count;
					$q = 'UPDATE `order_goods` SET `count`=`count`-'.$c.' WHERE order_id='.$order_id.' and goods_id='.$goods_id;
					IOMysqli::query($q);
					$q = 'UPDATE `goods` SET `count`=`count`+'.$c.' WHERE id='.$g;
					IOMysqli::query($q);					
				}else if($count==0){
					$q = 'DELETE FROM `order_goods` WHERE order_id='.$order_id.' and goods_id='.$goods_id;							
					IOMysqli::query($q);
					$q = 'UPDATE `goods` SET `count`=`count`+'.$prov['count'].' WHERE id='.$g;
					IOMysqli::query($q);		
				}
			}else{
				$q = 'INSERT INTO `order_goods` (`order_id`,`goods_id`,`count`) VALUES ('.$order_id.','.$goods_id.','.$count.')';
				IOMysqli::query($q);	 
				$q = 'UPDATE `goods` SET `count`=`count`-'.$count.' WHERE id='.$g;
				 IOMysqli::query($q);					
			}
			return Order::updateOrderSum($order_id);
			// if($count != 0){
			//	return static::goodsCountUpd($goods_id, $c);
			// }else{
				// return true;
			// }
		// }else{
			// return false;
		// }
	}
	public static function addGoods($fields){
		if(isset($fields) && !empty($fields) && is_array($fields)){
			$q = 'INSERT INTO `goods` (`date`,`'.join('`,`',array_keys($fields)).'`) VALUES (UNIX_TIMESTAMP(),"'.join('","',$fields).'")';
			return IOMysqli::query($q, 1);	
		}else{
			return false;
		}
	}
	public static function getGoodsInfoByIds($goods, $order_id){		
		if(isset($goods) && !empty($goods) && is_array($goods)){
			$q = 'select g.*, og.count as goods_count from `goods` as g join `order_goods` as og on g.id=og.goods_id where g.id in ('.join(',',$goods).') and og.order_id='.$order_id;				
			return IOMysqli::table($q);
		}else{
			return false;
		}			
	}
	public static function getGoodsById($goods){		
		if(isset($goods) && !empty($goods) && filter_var($goods, FILTER_VALIDATE_INT)){
			$q = 'select g.*, o.partner_id from `goods` as g join offers as o on o.id=g.offer_id where g.id='.$goods.' limit 1';			
			return IOMysqli::row($q);
		}else{
			return false;
		}			
	}	
	public static function getGoodsByOfferId($offer_id){		
		if(isset($offer_id) && !empty($offer_id) && filter_var($offer_id, FILTER_VALIDATE_INT)){
			$q = 'select g.*, o.partner_id from `goods` as g join offers as o on o.id=g.offer_id where o.id='.$offer_id.' and g.apical=0 limit 1';			
			return IOMysqli::row($q);
		}else{
			return false;
		}			
	}
	public static function getIdGoodsByOrders($order_id){
		if(filter_var($order_id, FILTER_VALIDATE_INT)){
			$q = 'select goods_id from `order_goods` where order_id='.$order_id;	
			
			return IOMysqli::table($q);
		}else{
			return false;
		}			
	}
	public static function getArrGoodsByOrders($order_id){
		if(filter_var($order_id, FILTER_VALIDATE_INT)){
			$goods_ar = static::getIdGoodsByOrders($order_id);
			$goods = array();
			foreach($goods_ar as $v){
				$goods[] = $v['goods_id'];				
			}
			return $goods;
			
		}else{
			return false;
		}		
	}
	public static function getCountGoods($goods_id){
		if(filter_var($goods_id, FILTER_VALIDATE_INT)){
			$q = 'select apical from `goods` where id='.$goods_id;	
			$apical = IOMysqli::one($q);
			if($apical == 0){
				$q = 'select count from `goods` where id='.$goods_id;	
			}else{
				$q = 'select count from `goods` where id='.$apical;	
			}
			
			return IOMysqli::one($q);
		}else{
			return false;
		}			
	}
	public static function getGoodsInfoById($goods_id, $offers, $more=0){
		if($more==1 && is_array($goods_id)){
			$q = 'select * from `goods` where id in ('.join(',',$goods_id).')';				
			return IOMysqli::table($q);
		}else if(filter_var($goods_id, FILTER_VALIDATE_INT)){
			$q = 'select * from `goods` where id='.$goods_id.' and offer_id in ('.$offers.')';				
			return IOMysqli::row($q);
		}else{
			return false;
		}			
	}
	public static function getGoodsInfoByUserId($user_id, $not_parse = 0){
		
		if($not_parse == 1 && filter_var($user_id, FILTER_VALIDATE_INT)){
			if($user_id == 11){
				$user_id .= ',28,46';
			}
			$q = 'select g.*,c.icon from `goods` as g join `offers` as o on o.id=g.offer_id join `currency` as c on c.id=g.currency where o.partner_id in ('.$user_id.') ORDER BY `id` DESC';
			return IOMysqli::table($q);		
			
		}else if(filter_var($user_id, FILTER_VALIDATE_INT)){
			if($user_id == 11){
				$user_id .= ',28,46';
			}
			$q = 'select g.*,c.icon from `goods` as g left join `offers` as o on o.id=g.offer_id left join `currency` as c on c.id=g.currency where o.partner_id in ('.$user_id.') and g.apical=0 ORDER BY `id` DESC LIMIT 30';

			$goods = IOMysqli::table($q);
			if(isset($goods) && !empty($goods)){
				$table='<table>
				<tr>
					<th><input type="checkbox" class="select_all_orders" data-action="select"></th>
					<th></th>
					<th>название</th>
					<th>артикул</th>
					<th class="t offer_id">ID оффера</th>
					<th class="t purchase_price">закупочная цена</th>
					<th>розничная цена</th>										
					<th class="t weight">вес</th>										
					<th>остаток по складу</th>					
					<th class="t barcode">остаток по складу</th>					
				</tr>
				';
				$tr ='';
				foreach($goods as $v){
					$dimensions = $v['height'].'x'.$v['width'].'x'.$v['long'];
					if($v['img'] == 'no_img.png' ){
						$img = '../img/goods/'.$v['img'];
					}else{
						if($user_id == 11){
							$users = explode(',',$user_id);
							foreach($users as $u){
								$file_exist = file_exists('/home/httpd/vhosts/cpa-private.biz/httpdocs/img/goods/'.$u.'/'.$v['img']);
								if($file_exist == true){
									$img = '../img/goods/'.$u.'/'.$v['img'];
									break;
								}
							}
						}else{
							$img = '../img/goods/'.$user_id.'/'.$v['img'];
						}
						
					}
					
					/*$filename = '../img/goods/'.$v['id'].'.png';					
					if (file_exists($filename)) {
						$img = $v['id'].'.png';
					} else {
						$img = 'no_img.png';
					}
					*/
					$currency=$v['icon'];
					$tr .= '<tr data-goods_id="'.$v['id'].'">'.
					'<td><input type="checkbox" class="select_order" value="'.$v['id'].'"></td>'.
					'<td><img src="'.$img.'" alt="'.$v['name'].'"></td>'.
					'<td>'.$v['name'].'</td>'.
					'<td>'.$v['id'].'</td>'.
					'<td class="t offer_id">'.$v['offer_id'].'</td>'.
					'<td class="t purchase_price">'.$v['purchase_price'].'</td>'.
					'<td>'.$v['price'].'</td>'.
					'<td class="t weight">'.$v['weight'].'</td>'.
					'<td>'.$v['count'].'</td>'.
					'<td class="t barcode">'.$v['barcode'].'</td>'.
					'</tr>';
				}
				return $table.=$tr.'</table>';
			}
		}else{
			return false;
		}
	}
	public static function addDelLink($goods_id, $link, $action){
		if(isset($goods_id) && !empty($goods_id) && filter_var($goods_id, FILTER_VALIDATE_INT)){
			switch($action){
				case 1:
					$q = 'INSERT INTO `goods_link`(`goods_id`, `link`) VALUES ('.$goods_id.',"'.$link.'")';					
				break;
				case 2:
					$q = 'DELETE FROM `goods_link` WHERE `goods_id` = '.$goods_id.' and `link` = "'.$link.'"';
				break;
			}
				return IOMysqli::query($q);
			}else{
				return false;
			}		
	}
	public static function updateInfoGoods($goods_id, $fields){
		if(isset($fields) && !empty($fields) && is_array($fields) && filter_var($goods_id, FILTER_VALIDATE_INT)){
			$upd_str = array();
			foreach($fields as $k=>$v){
				$upd_str[]='`'.$k.'`="'.$v.'"';
			}
			$q='UPDATE `goods` SET '.join(', ',$upd_str).' WHERE `id`='.$goods_id;
			return IOMysqli::query($q);
		}else{
			return false;
		}	
	}
	public static function filterGoods($fields, $hash){
		if(isset($fields) && !empty($fields) && is_array($fields)){
			$offers = Partner::offersPartnerByHash($hash);
			$user = User::getInfoByHash($hash);
			$q = 'SELECT * FROM `goods` WHERE `offer_id` in ('.$offers.') ';
			$q1 = '';
			if(isset($fields['goods_id']) && !empty($fields['goods_id'])){
				if(filter_var($fields['goods_id'], FILTER_VALIDATE_INT)){
					$q1 .= 'and id='.$fields['goods_id'];
				}
			}else{
				if(isset($fields['date_start']) && !empty($fields['date_start'])){
					$date_start_parce = explode('.',$fields['date_start']);
					$date_start = mktime(0, 0, 0, $date_start_parce[0], $date_start_parce[1], $date_start_parce[2]);
					if(isset($fields['date_end']) && !empty($fields['date_end'])){
						$date_end_parce = explode('.',$fields['date_end']);
						$date_end = mktime(0, 0, 0, $date_end_parce[0], $date_end_parce[1], $date_end_parce[2]);				
					}else{
						$date_end = $date_start;
					}
					$q1 .= ' and date BETWEEN "'.$date_start.'" AND "'.$date_end.'"';
				}
				if(isset($fields['purchase_price_start']) && !empty($fields['purchase_price_start'])){
					if(filter_var($fields['purchase_price_start'], FILTER_VALIDATE_INT)){
						$q1 .= ' and purchase_price >= '.$fields['purchase_price_start'];
					}
				}
				if(isset($fields['purchase_price_end']) && !empty($fields['purchase_price_end'])){
					if(filter_var($fields['purchase_price_end'], FILTER_VALIDATE_INT)){
						$q1 .= ' and purchase_price <= '.$fields['purchase_price_end'];
					}
				}
				if(isset($fields['date_start']) && !empty($fields['date_start'])){
					if(filter_var($fields['date_start'], FILTER_VALIDATE_INT)){
						$q1 .= ' and price >= '.$fields['date_start'];
					}
				}
				if(isset($fields['date_end']) && !empty($fields['date_end'])){
					if(filter_var($fields['date_end'], FILTER_VALIDATE_INT)){
						$q1 .= ' and price <= '.$fields['date_end'];
					}
				}
				if(isset($fields['count']) && !empty($fields['count'])){
					if(filter_var($fields['count'], FILTER_VALIDATE_INT)){
						$q1 .= ' and count <= '.$fields['count'];
					}
				}
				if(isset($fields['barcode']) && !empty($fields['barcode'])){
					$q1 .= ' and barcode like "%'.$fields['barcode'].'%"';
				}
				if(isset($fields['name']) && !empty($fields['name'])){
					$q1 .= ' and name like "%'.$fields['name'].'%"';
				}
				
			}

				$query = $q.$q1.' ORDER BY `date` DESC';					
				$all_goods = IOMysqli::table($query);
				
				if(isset($all_goods) && !empty($all_goods)){
					$table='<table>
					<tr>
						<th></th>
						<th>название</th>
						<th>артикул</th>
						<th class="t offer_id">ID оффера</th>
						<th class="t purchase_price">закупочная цена</th>
						<th>розничная цена</th>										
						<th class="t weight">вес</th>										
						<th>остаток по складу</th>					
						<th class="t barcode">остаток по складу</th>					
					</tr>
					';
					$tr ='';
					foreach($all_goods as $v){
						$dimensions = $v['height'].'x'.$v['width'].'x'.$v['long'];
						if($v['img'] == 'no_img.png' ){
							$img = '../img/goods/'.$v['img'];
						}else{
							$img = '../img/goods/'.$user['id'].'/'.$v['img'];
						}
						
						$currency=$v['icon'];
						$tr .= '<tr data-goods_id="'.$v['id'].'">'.
						'<td><img src="'.$img.'" alt="'.$v['name'].'"></td>'.
						'<td>'.$v['name'].'</td>'.
						'<td>'.$v['id'].'</td>'.
						'<td class="t offer_id">'.$v['offer_id'].'</td>'.
						'<td class="t purchase_price">'.$v['purchase_price'].'</td>'.
						'<td>'.$v['price'].'</td>'.
						'<td class="t weight">'.$v['weight'].'</td>'.
						'<td>'.$v['count'].'</td>'.
						'<td class="t barcode">'.$v['barcode'].'</td>'.
						'</tr>';
					}
					return $table.=$tr.'</table>';
				}else{
					return $table.= '<td colspan="7">По данному фильтру товаров нет</td></table>';
				}
				
			
		}else{
			return false;
		}
		
	}
	
  
}
