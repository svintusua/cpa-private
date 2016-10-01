<?php

class C_New_order extends Controller {

    protected $template = "partner";
	
	public function main() {
		$this->view = 'new_order.php';
		$this->addVar("title", 'Новый заказ');
		$geo = Ipgeo::geoByIp($_SERVER['REMOTE_ADDR']);
		$this->addVar("ip", $_SERVER['REMOTE_ADDR']);
		$this->addVar("country", json_decode($geo, true)['country']['name_ru']);
		$this->addVar("city", json_decode($geo, true)['city']['name_ru']);
		$this->addVar("region", json_decode($geo, true)['region']['name_ru']);
		
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
		$this->addVar("user_id", $info['id']);
		$status = '';
		$order_status = Partner::$status_array;
			foreach($order_status as $k=>$v){
				$status .= '<option class="gruop_status_'.$v['group'].'" value="'.$k.'">'.$v['name'].'</option>';
			}
		$this->addVar("status", $status);
		//$q = 'INSERT INTO `orders`(`date`,`user_id`) VALUES (UNIX_TIMESTAMP(),'.$info['id'].')';
		//$order_id = IOMysqli::query($q,1);	
		$this->addVar("order_id", $order_id);
		
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
		$table = Goods::getGoodsInfoByUserId($id_by_offer, 1);
				
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
						$img = '../img/goods/'.$id_by_offer.'/'.$v['img'];
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
							$img = '../img/goods/'.$id_by_offer.'/'.$a['img'];
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
			// $tr = '';
			// foreach($table as $v){
				// if($v['apical'] == 0){
					// $goods_category[$v['category_id']][] = $v;
				// }
				// if($v['apical'] > 0){
					// $goods_apical[$v['apical']][] = $v;
				// }
			// }
			// foreach($category as $v){
				// $tr .= '<div class="tr"><div class="cat"><span>'.$v['name'].'</span></div>';	
				// $g_c = '';
				// foreach($goods_category[$v['id']] as $c){
					// if($c['img'] == 'no_img.png' ){
						// $img = '../img/goods/'.$c['img'];
					// }else{
						// $img = '../img/goods/'.$id_by_offer.'/'.$c['img'];
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
							// $img = '../img/goods/'.$id_by_offer.'/'.$a['img'];
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
						// $img = '../img/goods/'.$id_by_offer.'/'.$c['img'];
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
							// $img = '../img/goods/'.$id_by_offer.'/'.$a['img'];
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
		// if(isset($table) && !empty($table) && is_array($table)){
			// $tr = '';
			// foreach($table as $v){				
				// if($v['img'] == 'no_img.png' ){
					// $img = '../img/goods/'.$v['img'];
				// }else{
					// $img = '../img/goods/'.$id_by_offer.'/'.$v['img'];
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
		}else{
			$this->addVar("goods", $not_orders);
		}
		
		// $goods_id_all = Goods::getIdGoodsByOrders($order_id);
		// $goods = array();
		// foreach($goods_id_all as $v){
			// $goods[] = $v['goods_id'];
		// }
		// $goods_info = Goods::getGoodsInfoByIds($goods, '', 1);
		
		// $tr = '';
		// foreach($goods_info as $v){
			// $tr .= '<tr id="goods_id_'.$v['id'].'"><td>'.$v['name'].'</td>'.
			// '<td><input type="text" class="not_style" name="Goods[id]" value="'.$v['id'].'" disabled></td>'.
			// '<td>'.$v['price'].'</td>'.
			// '<td>'.$v['goods_count'].'</td>'.
			// '<td><input type="text" name="Goods[count]"></td>';
		// }	
		
		// $this->addVar("goods_table", $tr);
		
		//$offers = Partner::offersPartnerByHash($cookie);
		$offers_arr=explode(',',$offers);
		$option_offer = '';
		foreach($offers_arr as $of_id){
			$option_offer .= '<option value="'.$of_id.'">'.$of_id.'</option>';
		}		
		$this->addVar("offers", $option_offer);
		
		parent::main();
	}	
	
	public function getGoodsInfo(){
		if(isset($_POST['goods_id']) && !empty($_POST['goods_id'])){
			$q = 'select g.* from `goods` as g where g.id='.$_POST['goods_id'];				
			$goods_info = IOMysqli::row($q);
			//$tr = '';
			//foreach($goods_info as $v){
				// $tr = '<tr id="goods_id_'.$goods_info['id'].'"><td>'.$goods_info['name'].'</td>'.
				// '<td><input type="text" class="not_style" name="Goods[id]" value="'.$goods_info['id'].'" disabled></td>'.
				// '<td>'.$goods_info['price'].'</td>'.
				// '<td class="count">1</td>'.
				// '<td><input type="text" id="'.$goods_info['id'].'"></td></tr>';
				$tr .= '<tr id="goods_id_'.$goods_info['id'].'"><td>'.$goods_info['name'].'</td>'.
					'<td><input type="text" class="not_style" name="Goods[id]" value="'.$goods_info['id'].'" disabled></td>'.
					'<td>'.$goods_info['price'].'</td>'.
					//'<td>'.$v['goods_count'].'</td>'.
					'<td><input type="number" name="Goods[count]" data-goods_id="'.$goods_info['id'].'" value="1"></td>'.
					'<td>'.$goods_info['price'].'</td>';
			//}
			$this->output(array("response"=>'success',"text"=>$tr,"goods_id"=>$goods_info['id'],"price"=>$goods_info['price']));
		}else{
			$this->output(array("response"=>'error',"text"=>"Ошибка : отсутсвует ID товара"));
		}
		
	}
}