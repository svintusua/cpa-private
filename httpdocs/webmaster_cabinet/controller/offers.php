<?php

class C_Offers extends Controller {

    protected $template = "wm";
	
	public function main() {
		//<?=$this->vars['img_all']
		// var_dump(Offers::getOffers());
		// exit;
		$this->view = 'offers.php';
		$this->addVar("title", 'Офферы');
		$cookie = Cookie::get("hash");
		if(isset($cookie) && !empty($cookie)){
			$info = User::getInfoByHash($cookie);
			if(filter_var($info['type'], FILTER_VALIDATE_INT)){
				$type_user = $info['type'];
				$wm_id = $info['id'];
				$this->addVar("name", explode('@',$info['email'])[0]);
				$this->addVar("refid", $info['id']);
			}else{
				header('Location: /');
			}	
			
			if($type_user == 2 || $type_user == 3){
				header('Location: /');
			}				
		}else{
			header('Location: /');
		}
		$this->addVar("balans", User::getBalansByUserId($info['id'])[2]);
			$this->addVar("hold", User::getBalansByUserId($info['id'])[1]);

		$all_table = Offers::getOffers();
		
		$tr = '';
		
		foreach($all_table as $v){
			$colspan = count(explode(',',$v['l_price']))+1;
			
			$f_location = array_shift(explode(',',$v['l_price']));
			$f_price = array_shift(explode(',',$v['price']));
			$f_payments = array_shift(explode(',',$v['payments']));
			
			$location = explode(',',$v['l_price']);
			$price = explode(',',$v['price']);
			$payments = explode(',',$v['payments']);
			
			$t = '';
			
			foreach($location as $k=>$vv){
				$special_payments = IOMysqli::one('SELECT `payments` FROM `user_payments` WHERE `country`="'.$vv.'" AND `user_id`='.$wm_id.' AND `offer_id`='.$v['id']);
				if(isset($special_payments) && !empty($special_payments)) {
					$p = $special_payments;
				}else{
					$p = $payments[$k];
				}
				$t .= '<tr class="nobord"><td>'.$vv.'</td><td>'.$price[$k].'</td><td>'.$p.'</td></tr>';
				// $t .= '<td>'.$vv.'</td>
				// <td>'.$price[$k].'</td><td>'.$p.'</td>';
			}
			
			$tr .='<tr><td rowspan="'.$colspan.'"><img src="../img/offer_logo/'.$v['logo'].'" alt="'.$v['name'].'"></td>'.
			'<td rowspan="'.$colspan.'"><h2>'.$v['name'].'</h2><p>'.$v['caption'].'</p></td>'.			
			'<td></td>'.
			'<td></td>'.
			'<td></td>'.
			// '<td>'.$f_location.'</td>'.
			// '<td>'.$f_price.'</td>'.
			// '<td>'.$f_payments.'</td>'.
			'<td class="btn_view_body" rowspan="'.$colspan.'"><a class="btn_view" href="/webmaster_cabinet/see_offer?offer_id='.$v['id'].'">Просмотр</a> </td></tr>'.$t;
			// var_dump($tr);
		// exit;
			// '<td rowspan="'.$colspan.'"><a class="btn_view" href="/webmaster_cabinet/see_offer?offer_id='.$v['id'].'">Просмотр</a></p></td>';
		}
		
		$this->addVar("tr", $tr);
		// if(isset($cookie) && !empty($cookie)){
			// $info = User::getInfoByHash($cookie);
			// if(filter_var($info['type'], FILTER_VALIDATE_INT)){
				// $type_user = $info['type'];
			// }else{
				// header('Location: /');
			// }	
			// if($type_user == 1){
				// header('Location: /');
			// }else if($type_user == 2){
				// $offers = Partner::offersPartnerByHash($cookie);
				// $id_by_offer = $info['id'];
				// $partner_id = $info['id'];
				// $this->addVar("display", 'inline');
			// }else if($type_user == 3){
				// $partner_id = Partner::getPartnerIDByManagerId($info['id']);
				// $offers = Partner::offersPartnerByID($partner_id);
				// $id_by_offer = $partner_id;
				// $this->addVar("display", 'none');
				
			// }		
		// }else{
			// header('Location: /');
		// }
		$this->addVar("balans", User::getBalansByUserId($wm_id)[2]);
			$this->addVar("hold", User::getBalansByUserId($wm_id)[1]);
		parent::main();
	}
}