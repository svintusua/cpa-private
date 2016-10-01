<?
class Offers {
	
	static public function getOffers(){
		$q = 'select o.id, oi.name, o.logo, oi.caption, group_concat(op.location_name) as l_price, group_concat(op.price) as price, group_concat(op.payments) as payments from offers as o join offer_info as oi on o.id=oi.offer_id left join offer_price as op on o.id=op.offer_id where o.activated=2 GROUP by op.offer_id';
		return IOMysqli::table($q);
	}
	
	static public function getInfoOfferByID($id, $user_id){
		if(isset($id) && !empty($id) && filter_var($id, FILTER_VALIDATE_INT)){
			$q = 'select o.id, oi.name, o.logo, oi.description, oi.caption, group_concat(op.location_name) as l_price, group_concat(op.price) as price, group_concat(op.payments) as payments from offers as o join offer_info as oi on o.id=oi.offer_id left join offer_price as op on o.id=op.offer_id where o.id='.$id.' and o.activated=2 GROUP by op.offer_id';
			return IOMysqli::row($q);
		}else{
			return false;
		}	
	}
	static public function getLinksOfferByID($id){
		if(isset($id) && !empty($id) && filter_var($id, FILTER_VALIDATE_INT)){
			$q = 'SELECT * FROM `offer_links` WHERE offer_id='.$id.$s;
			return IOMysqli::table($q);
		}else{
			return false;
		}	
	}
	static public function getLinksIframeOfferByID($id){
		if(isset($id) && !empty($id) && filter_var($id, FILTER_VALIDATE_INT)){
			$q = 'SELECT id FROM `offer_links` WHERE offer_id='.$id.' and type=2';
			return IOMysqli::one($q);
		}else{
			return false;
		}	
	}
	static public function createdLink($wm_id,$land_id,$fields, $iframe){
		if(isset($wm_id) && !empty($wm_id) && filter_var($wm_id, FILTER_VALIDATE_INT) && isset($land_id) && !empty($land_id) && filter_var($land_id, FILTER_VALIDATE_INT)){

			if(isset($fields) && !empty($fields)){
				$subid = array();
				foreach($fields as $k=>$v){
					$subid[] = ' `'.$k.'`="'.$v.'" ';
				}
				$s = ' and '.join(' and ', $subid);
			}else{
				$s = '';
			}
			
			$q = 'SELECT `identity` FROM `users_links` WHERE `wm_id`='.$wm_id.' and `land_id`='.$land_id.$s.' LIMIT 1';
			
			$identity = IOMysqli::one($q);
			
			if(!isset($identity) && empty($identity)){
				 $identity = static::identityGenerate();
				 if(isset($fields) && !empty($fields)){
					$q = 'INSERT INTO `users_links`(`wm_id`, `land_id`, `identity`,'.join(' ,', array_keys($fields)).') VALUES ('.$wm_id.','.$land_id.',"'.$identity.'","'.join('","', $fields).'")';
					
				 }else{
					$q = 'INSERT INTO `users_links`(`wm_id`, `land_id`, `identity`) VALUES ('.$wm_id.','.$land_id.',"'.$identity.'")';
				 }
				
				
				
				if(IOMysqli::query($q)){
					return $identity;
				}
			}else{
				return $identity;
			}
		}else{
			return false;
		}
		
	}
	static public function createdPrelandLink($wm_id,$land_id,$preland_id,$name){		
		if(isset($name) && !empty($name) && isset($wm_id) && !empty($wm_id) && filter_var($wm_id, FILTER_VALIDATE_INT) && isset($land_id) && !empty($land_id) && filter_var($land_id, FILTER_VALIDATE_INT) && isset($preland_id) && !empty($preland_id) && filter_var($preland_id, FILTER_VALIDATE_INT)){
			$q='SELECT `identity` FROM `users_links` WHERE `wm_id`='.$wm_id.' and `land_id`='.$land_id.' and `preland_id`='.$preland_id;
			
			$prov = IOMysqli::one($q);
			if(isset($prov) && !empty($prov)){
				return $prov;
			}else{
				$identity = static::identityGenerate();
				$q = 'INSERT INTO `users_links`(`wm_id`, `land_id`, `preland_id`, `identity`, `name`) VALUES ('.$wm_id.','.$land_id.','.$preland_id.',"'.$identity.'","'.$name.'")';
				
				if(IOMysqli::query($q) == true){
					
					return $identity;
				}else{
					return false;
				}
			}
		}else{
			return false;
		}
	}
	static public function identityGenerate(){
		$str='123456789qwertyuiopasdfghjklzxcvbnm';
		$identity = '';
		for($i=0;$i<7;$i++){
			$identity .= $str[rand(0,strlen($str)-1)];
		}
		return $identity;
	}
	static public function setRetargetingCode($user_id, $land_id, $ret){
		if(isset($user_id) && !empty($user_id) && isset($ret) && !empty($ret) && is_array($ret)){
			foreach($ret as $k=>$v){
				$q = 'SELECT id FROM `users_metrika` WHERE `name`="'.$k.'" and `offer_links_id`='.$land_id.' and `user_id`='.$user_id;
				
				$p = IOMysqli::one($q);
				if($p){
					$q = 'UPDATE `users_metrika` SET `value`="'.$v.'" WHERE `id`='.$p;
				}else{
					$q = 'INSERT INTO `users_metrika`(`user_id`, `offer_links_id`, `name`, `value`) VALUES ('.$user_id.','.$land_id.',"'.$k.'","'.$v.'")';
				}
				IOMysqli::query($q);
			}
		}
	}
	static public function getRetargetingCode($user_id, $land_id){
		if(isset($user_id) && !empty($user_id)){

				$q = 'SELECT name, value FROM `users_metrika` WHERE `offer_links_id`='.$land_id.' and `user_id`='.$user_id;
				
				$p = IOMysqli::table($q);
				$arr = array();
				foreach($p as $v){
					$arr[$v['name']]=$v['value'];
				}
				return $arr;
		}
	}
	// static public function getRetargetingCode($user_id, $offer_id){
		// if(isset($user_id) && !empty($user_id) && isset($offer_id) && !empty($offer_id)){

				// $q = 'SELECT * FROM `users_retargeting` WHERE `offer_id`='.$offer_id.' and `user_id`='.$user_id;				
				// $r = IOMysqli::table($q);
				// $ret = array();
				// foreach($r as $v){
					// $ret[$v['name']] = $v['r_id'];
				// }
				// return $ret;
		// }		
	// }
	static function setTbLink($user_id,$offer_id,$link){
		if(isset($user_id) && !empty($user_id) && isset($offer_id) && !empty($offer_id)){
			$q = 'SELECT `id` FROM `users_tb_links` WHERE user_id='.$user_id.' and offer_id='.$offer_id;
			$id = IOMysqli::one($q);
			if(isset($id) && !empty($id)){
				if(isset($link) && !empty($link)){
					$q = 'UPDATE `users_tb_links` SET `link`="'.$link.'" WHERE id='.$id;
				}else{
					$q = 'DELETE FROM `users_tb_links` WHERE id='.$id;
				}
				return IOMysqli::query($q);
			}else{
				if(isset($link) && !empty($link)){
					$q = 'INSERT INTO `users_tb_links`(`user_id`, `offer_id`, `link`) VALUES ('.$user_id.','.$offer_id.',"'.$link.'")';
					return IOMysqli::query($q);
				}else{
					return false;
				}				
			}
		}else{
			return false;
		}
	}
	static function getTbLink($user_id,$offer_id){
		if(isset($user_id) && !empty($user_id) && isset($offer_id) && !empty($offer_id)){
			$q = 'SELECT `link` FROM `users_tb_links` WHERE user_id='.$user_id.' and offer_id='.$offer_id;
			return IOMysqli::one($q);			
		}else{
			return false;
		}
	}
	static public function specialPrice($user, $offer_price_id){
		
	}
}