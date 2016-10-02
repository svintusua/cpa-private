<?
class C_Handler extends Controller{
	protected $template = "download";
	
	public function main() {
				
		if($_REQUEST['fio'] && $_REQUEST['phone'] && $_REQUEST['click']){
				if($_REQUEST['click'] && strlen($_REQUEST['click'])){
				$q = 'SELECT `offer_id`, `user_id`, `link_id`, `ip` FROM `clicks` WHERE `click_id`="'.$_REQUEST['click'].'" LIMIT 1';
				$info_by_click = IOMysqli::row($q);
				
				$geo = Ipgeo::geoByIp($info_by_click['ip']);
				
				$country = json_decode($geo, true)['country']['name_ru'];
				if(!$country){
					$country='Россия';
				}
				$q = 'SELECT `price`, `payments` FROM `offer_price` WHERE `offer_id`='.$info_by_click['offer_id'].' and `location_name`="'.$country.'" LIMIT 1';
				
				$p_p = IOMysqli::row($q);
				$special_payments = IOMysqli::one('SELECT `payments` FROM `user_payments` WHERE `country`="'.$country.'" AND `user_id`='.$info_by_click['user_id'].' AND `offer_id`='.$info_by_click['offer_id']);
				if(isset($special_payments) && !empty($special_payments)) {
					$p_p['payments'] = $special_payments;
				}
				$q = 'SELECT id FROM `orders` WHERE `offer_id`='.$info_by_click['offer_id'].' and `params` like \'%'. urldecode($_REQUEST['fio']).'%\' and `params` like \'%'.urldecode($_REQUEST['phone']).'%\' and `user_id`='.$info_by_click['user_id'].' LIMIT 1';
				
				$dubl = IOMysqli::one($q);
				
				if(isset($dubl) && !empty($dubl)){
					$q = 'INSERT INTO `double_orders`(`user_id`, `link_id`, `offer_id`, `params`, `click_id`, `order_id`) VALUES ('.$info_by_click['user_id'].','.$info_by_click['link_id'].','.$info_by_click['offer_id'].',\''.json_encode(array(1=>urldecode($_REQUEST['fio']),2=>urldecode($_REQUEST['phone']))).'\',"'.$_REQUEST['click'].'",'.$dubl.')';

					return IOMysqli::query($q);
				}

		$fields = array();
		$goods = array();
					// $goods_ar = explode(',',$_REQUEST['goods']);						
					// foreach($goods_ar as $v){
						// list($id,$count) = explode(':',$v);
						// $goods[$id] = $count;
					// }
					
				// $info = Goods::getGoodsById(array_shift(array_keys($goods)));	
				
				$info = Goods::getGoodsByOfferId($info_by_click['offer_id']);		
				
				if(isset($_REQUEST['target']) && !empty($_REQUEST['target'])){
                                    $fields['orders']['target'] = $_REQUEST['target'];
                                }else{
                                    $fields['orders']['target'] = '';
                                }
				
				// $parent_id = $info['partner_id'];
				$parent_id = $info_by_click['user_id'];
				$goods[$info['id']] = 1;
				$fio = urldecode($_REQUEST['fio']);
				list($fields['orders']['first_name'],$fields['orders']['middle_name'],$fields['orders']['last_name']) = explode(' ', $_REQUEST['fio']);	
				$fields['orders']['phone'] = urldecode($_REQUEST['phone']);
				$fields['orders']['order_id'] = urldecode($_REQUEST['order_id']);
				$fields['orders']['referer'] = $_SERVER['HTTP_REFERER'];	
				$fields['orders']['ip'] = $_SERVER['REMOTE_ADDR'];
				$fields['orders']['payments'] = $p_p['payments'];
				$fields['orders']['link_id'] = $info_by_click['link_id'];
				$fields['orders']['offer_id'] = $info_by_click['offer_id'];
				$fields['orders']['click'] = $_REQUEST['click'];
				$fields['info_orders']['delivery'] = 1;
				// $fields['orders']['offer_id'] = $info['offer_id'];
				// $geo = Ipgeo::geoByIp($_SERVER['REMOTE_ADDR']);
				$fields['info_orders']['country'] = json_decode($geo, true)['country']['name_ru'];
				$fields['info_orders']['city'] = json_decode($geo, true)['city']['name_ru'];
				$fields['info_orders']['region'] = json_decode($geo, true)['region']['name_ru'];
				
				
				$responce = Order::insertUpdateOrder($parent_id,$fields,$goods,array('type'=>'partner','id'=>$parent_id));
				Order::postback($parent_id,$info_by_click['offer_id'],'new',$_REQUEST['click']);
				echo $responce;
				}else{
					echo 'error 001';
				}
				
		}else if($_REQUEST['fio'] || $_REQUEST['phone'] && !$_REQUEST['click']){
			$geo = Ipgeo::geoByIp($info_by_click['ip']);
			$fields = array();
			$goods = array();
					$goods_ar = explode(',',$_REQUEST['goods']);						
					foreach($goods_ar as $v){
						list($id,$count) = explode(':',$v);
						$goods[$id] = $count;
					}
					
				$info = Goods::getGoodsById(array_shift(array_keys($goods)));	
				
				if($_REQUEST['fio']){
					list($fields['orders']['first_name'],$fields['orders']['middle_name'],$fields['orders']['last_name']) = explode(' ', $_REQUEST['fio']);	
				}else{
					$fields['orders']['first_name']='';
					$fields['orders']['middle_name']='';
					$fields['orders']['last_name']='';
				}
				$partner_id = $info["partner_id"];
				
                                if(isset($_REQUEST['target']) && !empty($_REQUEST['target'])){
                                    $fields['orders']['target'] = $_REQUEST['target'];
                                }else{
                                    $fields['orders']['target'] = '';
                                }
                                if(isset($_REQUEST['additional']) && !empty($_REQUEST['additional'])){
                                    
                                    if (preg_match("/^[a-zA-Z0-9]/", $_REQUEST['additional']) == 1){                                       
                                        $fields['orders']['additional'] = urldecode($_REQUEST['additional']); 
                                    }                                   
                                }
				$fields['orders']['phone'] = urldecode($_REQUEST['phone']);
				$fields['orders']['order_id'] = urldecode($_REQUEST['order_id']);
				$fields['orders']['referer'] = $_SERVER['HTTP_REFERER'];	
				$fields['orders']['ip'] = $_SERVER['REMOTE_ADDR'];
				$fields['orders']['payments'] = 0;
				$fields['orders']['link_id'] = 0;
				$fields['orders']['offer_id'] = $info['offer_id'];
				$fields['orders']['click'] = 0;
				$fields['info_orders']['delivery'] = 1;
				// $fields['orders']['offer_id'] = $info['offer_id'];
				// $geo = Ipgeo::geoByIp($_SERVER['REMOTE_ADDR']);
				$fields['info_orders']['country'] = json_decode($geo, true)['country']['name_ru'];
				$fields['info_orders']['city'] = json_decode($geo, true)['city']['name_ru'];
				$fields['info_orders']['region'] = json_decode($geo, true)['region']['name_ru'];
				$responce = Order::insertUpdateOrder($partner_id,$fields,$goods,array('type'=>'partner','id'=>$partner_id));
				echo $responce;
		}else{
			 echo 'error';
		}
	}
	
}