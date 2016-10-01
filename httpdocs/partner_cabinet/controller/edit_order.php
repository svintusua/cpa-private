<?php

class C_Edit_order extends Controller {

    protected $template = "partner";
	
	public function main() {
		$this->view = 'edit_order.php';
		$this->addVar("title", 'Редактирование заказа');
		$cookie = Cookie::get("hash");
		if(isset($cookie) && !empty($cookie)){
			$info = User::getInfoByHash($cookie);
			
			if(filter_var($info['type'], FILTER_VALIDATE_INT)){
				$type_user = $info['type'];
			}else{
				header('Location: /');
			}	
			if($type_user == 1){
				header('Location: /');
			}else if($type_user == 2){
				$offers = Partner::offersPartnerByHash($cookie);
				$id_by_offer = $info['id'];
				$partner_id = $info['id'];
				$this->addVar("display", 'inline');
			}else if($type_user == 3){
				$partner_id = Partner::getPartnerIDByManagerId($info['id']);				
				$offers = Partner::offersPartnerByID($partner_id);
				$id_by_offer = $partner_id;
				$this->addVar("display", 'none');
				
			}		
		}else{
			header('Location: /');
		}
		$this->addVar("partner_id", $id_by_offer);
		
		
		
		
		
		$messages = Sms::getSmsTextByUserId($id_by_offer);

		foreach($messages as $v){			
			$this->addVar("message_".$v['type'], $v['message']);
		}
		$order_id = $_GET['order_id'];
		// $offers = Partner::offersPartnerByHash($cookie);
		$offers_arr=explode(',',$offers);
		$option_offer = '';
		foreach($offers_arr as $of_id){
			$option_offer .= '<option value="'.$of_id.'">'.$of_id.'</option>';
		}		
		$this->addVar("offers", $option_offer);
		$this->addVar("user_id", $info['id']);
		if(filter_var($order_id, FILTER_VALIDATE_INT)){
			$info_order = Order::getInfoOrderByIdAndPartnerId($order_id, $id_by_offer);
			// var_dump($info_order);
			// exit;
			$geo = Ipgeo::geoByIp($info_order['ip']);
			$timezone = json_decode($geo, true)['region']['timezone'];
			$this->addVar("timeold", $timezone);
			date_default_timezone_set($timezone);
			$this->addVar("time", date("d.m.Y H:i",time()+3600));
			
			if($info_order != false && is_array($info_order)){
				$this->addVar("info_order", $info_order);
				if($info_order["phone"][0] == '8' || $info_order["phone"][0] == '7'){
                                    $info_order["phone"]=  substr($info_order["phone"],1);
                                }else if($info_order["phone"][0] == '+'){
                                    $info_order["phone"] =  substr($info_order["phone"], 2);
                                }
				$count_phone=count(Order::history('params', $info_order["phone"]));
                                $count_m_name=count(Order::history('params', $info_order["middle_name"]));				
				$count_ip=count(Order::history('ip', $info_order["ip"]));
				
				$this->addVar("count_m_name", $count_m_name);
				$this->addVar("count_phone", $count_phone);
				$this->addVar("count_ip", $count_ip);
			}else{
				header('Location: /partner_cabinet');
			}
		}else{
			header('Location: /partner_cabinet');
		}
		if(isset($info_order['city']) && !empty($info_order['city'])){
			$sities = file_get_contents('http://api.cdek.ru/city/getListByTerm/jsonp.php?q='.$info_order['city']);
			$sity_id = json_decode($sities, true)['geonames'][0]['id'];
			$this->addVar("sity_id", $sity_id);
			
		}
		
		
		$senders = Senders::getSendersByParentId($partner_id);

		if($senders){
			foreach($senders as $v){
				$senders_blocks .= '
				<span class="fiz_lic">'.$v['name_short'].'
					<div>
						<span class="postmail" data-blank="f7" data-from="'.$v['id'].'" data-order_id="'.$info_order['order_id'].'">ф.7</span>
						<span class="postmail" data-blank="f112" data-from="'.$v['id'].'" data-order_id="'.$info_order['order_id'].'">112 ЭП</span>
						<span class="postmail" data-blank="2f" data-from="'.$v['id'].'" data-order_id="'.$info_order['order_id'].'">оба</span>
					</div>
				</span>						
				';
			}
		}else{
			$senders_blocks = '
			<span class="fiz_lic">Отправителей нет</span>
			';
		}
		$this->addVar("senders_blocks", $senders_blocks);
		
		
		
		$not_goods = '<table>
				<tr>
					<th>картинка</th>
					<th>название</th>
					<th>артикул</th>
					<th>цена</th>
					<th>закупочная цена</th>
					<th>остаток на складе</th>				
				</tr>
				<tr class="notclick">
				<td colspan="6">у вас еще пока нет товаров</td>
				</tr>
				</table>';
                                
		$table = Goods::getGoodsInfoByUserId($partner_id, 1);//$info['id']
		
		$category = Goods::getCategory();
		$goods_category = array();
		$goods_apical = array();
		
		if(isset($table) && !empty($table) && is_array($table)){
			$tr = '';
			foreach($table as $v){
				if($v['apical'] == 0){
					// $goods_category[$v['category_id']][] = $v;
					$goods_category[] = $v;
				}
				if($v['apical'] > 0){
					$goods_apical[$v['apical']][] = $v;
				}
			}
							$g_c .= '<div class="g_tr th">'.
								'<div class="add" data-goods_id="0"></div>'.
								'<div class="g_img">Картинка</div>'.
								'<div class="g_name">Название</div>'.
								'<div class="g_id">Артикул</div>'.
								'<div class="g_price">Цена</div>'.
								'<div class="g_purchase_price">Зак. цена</div>'.
								'<div class="g_count">Кол.</div></div>';
			foreach($goods_category as $k=>$v){
				
				if($v['img'] == 'no_img.png' ){
						$img = '../img/goods/'.$v['img'];
					}else{
//						$img = '../img/goods/'.$info['id'].'/'.$v['img'];
                                                $img = '../img/goods/'.$info_order['partner_id'].'/'.$v['img'];
					}
					if($v['count'] <= 0){
						$class = 'not_goods';
						$data_goods = 0;
					}else{
						$data_goods = $v['id'];
						$class="";
					}
					$g_c .= '<div class="g_tr '.$class.'">'.
								'<div class="add" data-goods_id="'.$data_goods.'"><span>+</span></div>'.
								'<div class="g_img"><img src="'.$img.'" alt="'.$v['name'].'"></div>'.
								'<div class="g_name">'.$v['name'].'</div>'.
								'<div class="g_id">'.$v['id'].'</div>'.
								'<div class="g_price">'.$v['price'].' руб.</div>'.
								'<div class="g_purchase_price">'.$v['purchase_price'].' руб.</div>'.
								'<div class="g_count">'.$v['count'].' шт.</div>';
				if(array_key_exists($v['id'],$goods_apical)){
					$g_c .= '<div class="apical">';
					$g_a = '';
					foreach($goods_apical[$v['id']] as $a){
						if($a['img'] == 'no_img.png' ){
							$img = '../img/goods/'.$a['img'];
						}else{
							$img = '../img/goods/'.$info['id'].'/'.$a['img'];
						}
						$g_a .= '<div class="g_tr">'.
								'<div class="add" data-goods_id="'.$a['id'].'"><span>+</span></div>'.
								'<div class="g_img"><img src="'.$img.'" alt="'.$a['name'].'"></div>'.
								'<div class="g_name">'.$a['name'].'</div>'.
								'<div class="g_id">'.$a['id'].'</div>'.
								'<div class="g_price">'.$a['price'].' руб.</div>'.
								'<div class="g_purchase_price">'.$a['purchase_price'].' руб.</div>'.
								'<div class="g_count"></div>'.//.$a['count'].' шт.</div>'.
							'</div>';
					}
					$g_c .= $g_a.'</div></div>';
				}else{
					$g_c .= '</div>';
				}
			}
			$tr = $g_c;
			// foreach($category as $v){
				// $tr .= '<div class="tr"><div class="cat"><span>'.$v['name'].'</span></div>';	
				// $g_c = '';
				// foreach($goods_category[$v['id']] as $c){
					// if($c['img'] == 'no_img.png' ){
						// $img = '../img/goods/'.$c['img'];
					// }else{
						// $img = '../img/goods/'.$info['id'].'/'.$c['img'];
					// }
					// $g_c .= '<div class="g_tr"><div class="add" data-goods_id="'.$c['id'].'"><span>+</span></div>'.
							// '<div class="g_img"><img src="'.$img.'" alt="'.$c['name'].'"></div>'.
							// '<div class="g_name">'.$c['name'].'</div>'.
							// '<div class="g_id">'.$c['id'].'</div>'.
							// '<div class="g_price">'.$c['price'].'</div>'.
							// '<div class="g_purchase_price">'.$c['purchase_price'].'</div>'.
							// '<div class="g_count">'.$c['count'].'</div><div class="apical">';
					// $g_a = '';	
					// foreach($goods_apical[$c['id']] as $a){
						// if($a['img'] == 'no_img.png' ){
							// $img = '../img/goods/'.$a['img'];
						// }else{
							// $img = '../img/goods/'.$info['id'].'/'.$a['img'];
						// }
						// $g_a .= '<div class="g_tr"><div class="add" data-goods_id="'.$a['id'].'"><span>+</span></div>'.
							// '<div class="g_img"><img src="'.$img.'" alt="'.$a['name'].'"></div>'.
							// '<div class="g_name">'.$a['name'].'</div>'.
							// '<div class="g_id">'.$a['id'].'</div>'.
							// '<div class="g_price">'.$a['price'].'</div>'.
							// '<div class="g_purchase_price">'.$a['purchase_price'].'</div>'.
							// '<div class="g_count">'.$a['count'].'</div></div>';
					// }
					// $g_c .=	$g_a.'</div>';
					// $g_c .= '</div>';
				// }
				// $tr .= '<div class="category_goods">'.$g_c.'</div></div>';
			// }
			
			
			// $tr .= '<div class="tr"><div class="cat"><span>Без категории</span></div><div class="category_goods">';
	
			// foreach($goods_category[0] as $c){
					// if($c['img'] == 'no_img.png' ){
						// $img = '../img/goods/'.$c['img'];
					// }else{
						// $img = '../img/goods/'.$info['id'].'/'.$c['img'];
					// }
					// $g_c .= '<div class="g_tr"><div class="add" data-goods_id="'.$c['id'].'"><span>+</span></div>'.
							// '<div class="g_img"><img src="'.$img.'" alt="'.$c['name'].'"></div>'.
							// '<div class="g_name">'.$c['name'].'</div>'.
							// '<div class="g_id">'.$c['id'].'</div>'.
							// '<div class="g_price">'.$c['price'].'</div>'.
							// '<div class="g_purchase_price">'.$c['purchase_price'].'</div>'.
							// '<div class="g_count">'.$c['count'].'</div><div class="apical">';
					// $g_a = '';			
					// foreach($goods_apical[$c['id']] as $a){
						// if($a['img'] == 'no_img.png' ){
							// $img = '../img/goods/'.$a['img'];
						// }else{
							// $img = '../img/goods/'.$info['id'].'/'.$a['img'];
						// }
						// $g_a .= '<div class="g_tr"><div class="add" data-goods_id="'.$a['id'].'"><span>+</span></div>'.
							// '<div class="g_img"><img src="'.$img.'" alt="'.$a['name'].'"></div>'.
							// '<div class="g_name">'.$a['name'].'</div>'.
							// '<div class="g_id">'.$a['id'].'</div>'.
							// '<div class="g_price">'.$a['price'].'</div>'.
							// '<div class="g_purchase_price">'.$a['purchase_price'].'</div>'.
							// '<div class="g_count">'.$a['count'].'</div></div>';
					// }
					// $g_c .=	$g_a.'</div></div>';
					// $tr .= $g_c;
				// }
				// $tr .='</div>';
			// $tr = '';
			// foreach($table as $v){				
				// if($v['img'] == 'no_img.png' ){
					// $img = '../img/goods/'.$v['img'];
				// }else{
					// $img = '../img/goods/'.$info['id'].'/'.$v['img'];
				// }
				// if($v['count'] <= 0){
					// $tr .= '<tr class="item_missing" data-goods_id="0">'.
					// '<td><img src="'.$img.'" alt="'.$v['name'].'"></td>'.
					// '<td>'.$v['name'].'</td>'.
					// '<td>'.$v['id'].'</td>'.
					// '<td>'.$v['price'].'</td>'.
					// '<td>'.$v['purchase_price'].'</td>'.					
					// '<td>'.$v['count'].'</td>'.
					// '</tr>';
				// }else{
					// $tr .= '<tr data-goods_id="'.$v['id'].'">'.
						// '<td><img src="'.$img.'" alt="'.$v['name'].'"></td>'.
						// '<td>'.$v['name'].'</td>'.
						// '<td>'.$v['id'].'</td>'.
						// '<td>'.$v['price'].'</td>'.
						// '<td>'.$v['purchase_price'].'</td>'.						
						// '<td>'.$v['count'].'</td>'.
						// '</tr>';
				// }
			// }
			// $this->addVar("goods", '<table><tr>
					// <th>картинка</th>
					// <th>название</th>
					// <th>артикул</th>
					// <th>цена</th>
					// <th>закупочная цена</th>
					// <th>остаток на складе</th>				
				// </tr>'.$tr.'</table>');
				
				$this->addVar("goods", '<div id="all_goods">'.$tr.'</div>');
		}else{
			$this->addVar("goods", $not_orders);
		}
		
		$phones = Order::getAdditionalPhoneByOrderId($order_id);
		if(isset($phones) && !empty($phones)){
			$li = '';
			$s = 'block';
			foreach($phones as $v){
				// $li .= '<li>'.$v.'</li>';			
				$li .= '<p><input class="for_info_data_phone e_phone" type="text" value="'.$v.'" placeholder="Номер доп телефона"><img src="https://cdn3.iconfinder.com/data/icons/linecons-free-vector-icons-pack/32/trash-512.png"></p>';			
			}
			$this->addVar("e_phone", $li);
			$this->addVar("s", $s);
		}else{
			$s = 'none';
			$this->addVar("e_phone", '');
			$this->addVar("s", $s);
		}
		$goods_id_all = Goods::getIdGoodsByOrders($order_id);
		$goods = array();
		foreach($goods_id_all as $v){
			$goods[] = $v['goods_id'];
		}
		$goods_info = Goods::getGoodsInfoByIds($goods, $order_id);
                
		$tr = '';
		$all_price = $info_order['order_sum'];
		foreach($goods_info as $v){
			$tr .= '<tr id="goods_id_'.$v['id'].'"><td>'.$v['name'].'</td>'.
			'<td><input type="text" class="not_style" name="Goods[id]" value="'.$v['id'].'" disabled></td>'.
			'<td>'.$v['price'].'</td>'.
			//'<td>'.$v['goods_count'].'</td>'.
			'<td><input type="number" name="Goods[count]" value="'.$v['goods_count'].'"></td>'.
			'<td>'.$v['price']*$v['goods_count'].'</td>';
			// $all_price += $v['price']*$v['goods_count'];
//                        $this->addVar("shop", $tr);
		}	
		
		$this->addVar("goods_table", $tr);
		$this->addVar("all_price", $all_price);
						
		parent::main();
	}
}