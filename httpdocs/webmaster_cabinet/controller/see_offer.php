<?php

class C_See_offer extends Controller {

    protected $template = "wm";
	
	public function main() {
		//<?=$this->vars['img_all']
		// var_dump(Offers::getOffers());
		// exit;
		$this->view = 'see_offer.php';
		$this->addVar("title", 'Офферы');
		$cookie = Cookie::get("hash");
		if(isset($cookie) && !empty($cookie)){
			$info = User::getInfoByHash($cookie);
			if(filter_var($info['type'], FILTER_VALIDATE_INT)){
				$type_user = $info['type'];
				$wm_id = $info['id'];
				$this->addVar("refid", $wm_id);
				$this->addVar("name", explode('@',$info['email'])[0]);
			}else{
				header('Location: /');
			}	
			
			if($type_user == 2 || $type_user == 3){
				header('Location: /');
			}				
		}else{
			header('Location: /');
		}
		if(isset($_GET['offer_id']) && !empty($_GET['offer_id']) && filter_var($_GET['offer_id'], FILTER_VALIDATE_INT)){
			$info = Offers::getInfoOfferByID($_GET['offer_id'],$wm_id);
		}else{
			header('Location: /webmaster_cabinet/offers');
		}
			$q = 'SELECT `url` FROM users_postbacks where `user_id`='.$wm_id.' and `scope`=ifnull((select `scope` FROM users_postbacks where `user_id`='.$wm_id.' and `scope`='.$_GET['offer_id'].'),"global")';
			$postback = IOMysqli::one($q);
			
			if(isset($postback) && !empty($postback)){
				$this->addVar("link", explode('?',$postback)[0]);
				$this->addVar("postback", $postback);
			}else{
				$this->addVar("link", '');
				$this->addVar("postback", '');
			}
			
			$location = explode(',',$v['l_price']);
			$price = explode(',',$v['price']);
			$payments = explode(',',$v['payments']);
			
			$vp = '';
			
			foreach($location as $k=>$v){
				$vp = $v.': '.$price[$k].'/'.$payments[$k].';<br>';				
			}
			// unset($info['l_price']);
			// unset($info['price']);
			// unset($info['payments']);
			$all_links = Offers::getLinksOfferByID($_GET['offer_id']);
			$land = '';
			$land2 = '';
			$pre_land = '';
			$land_id = 0;
			$lands_id = array();
			$s = 0;
			foreach($all_links as $v){
				$lands_id[] = $v['id'];
				if($land_id == 0){
					if($v['type'] == 0){
						$land_id = $v['id'];
						
					}
				}
				if($s==0){
					$s_c = 'selected';
					$s = 1;
				}else{
					$s_c = '';
				}
				if($v['type']==0){
					$land_id_o .= '<option value="'.$v['id'].'">'.$v['name'].'</option>';
					$land .= '<li><h4>'.$v['name'].'</h4> <a href="'.$v['url'].'" target="_blank">Просмотр</a> <span class="select_land '.$s_c.'" data-land_id="'.$v['id'].'">Выбрать</span></li>';
					$land2 .= '<li><input type="checkbox" class="lsel" value="'.$v['id'].'"><h4>'.$v['name'].'</h4> <a href="'.$v['url'].'" target="_blank">Просмотр</a></li>';
					$for_select_land .= '<li><label><input type="radio" value="land-'.$v['id'].'"> <span>'.$v['name'].'</span></label></li>';
				}else if($v['type']==1){
					$pre_land .= '<li><h4>'.$v['name'].'</h4> <a href="'.$v['url'].'" target="_blank">Просмотр</a></li>';
					$for_select_pre_land .= '<li><label><input type="radio" disabled value="preland-'.$v['id'].'"> <a href="'.$v['url'].'">'.$v['name'].'</a></label></li>';
				}
			}
			$inf = User::getOfferPreland($wm_id,$_GET['offer_id']);
			$preland_links = '';
			foreach($inf as $v){
				$preland_links .= '<li><a class="prl_link" data-link="http://link.cpa-private.biz/?i='.$v['identity'].'" style="cursor: pointer;">'.$v['name'].'</a></li>';
			}
			$identity = Offers::createdLink($wm_id,$land_id);
			
			$lin = User::getUserLinks($wm_id, $lands_id);
			$tr = '';
			$tr = '';
			foreach($lin as $v){
				$links .= '<option value="'.$v['identity'].'">http://link.cpa-private.biz/?i='.$v['identity'].'</option>';
				$tr .= '<tr><td>'.$v['land_id'].'</td><td>'.$v['preland_id'].'</td><td><input class="upd_subs" value="'.$v['subid1'].'" data-sub="subid1" data-ind="'.$v['identity'].'"></td><td><input class="upd_subs" value="'.$v['subid2'].'" data-sub="subid2" data-ind="'.$v['identity'].'"></td><td><input class="upd_subs" value="'.$v['subid3'].'" data-sub="subid3" data-ind="'.$v['identity'].'"></td><td>http://link.cpa-private.biz/?i='.$v['identity'].'</td><td><span class="del_link" data-ind="'.$v['identity'].'">del</span></td></tr>';
				
			}
			$special_payments = IOMysqli::one('SELECT `payments` FROM `user_payments` WHERE `country`="Россия" AND `user_id`='.$wm_id.' AND `offer_id`='.$_GET['offer_id']);
				if(isset($special_payments) && !empty($special_payments)) {
					$info['payments'] = $special_payments;
				}
			// if(isset($info['special_price']) && !empty($info['special_price'])){
				// $info['payments'] = $info['special_price'];
			// }
			$info['vp'] = $vp;
			$info['lin'] = $tr;
			$info['links'] = $links;
			$info['land'] = $land;
			$info['land2'] = $land2;
			$info['lando'] = $land_id_o;
			$info['pre_land'] = $pre_land;
			$info['preland_links'] = $preland_links;
			$info['for_select_land'] = $for_select_land;
			$info['for_select_pre_land'] = $for_select_pre_land;
			$info['link'] = 'http://link.cpa-private.biz/?i='.$identity;
			// $info['ret'] = Offers::getRetargetingCode($wm_id,$_GET['offer_id']);
			$info['tb_link'] = Offers::getTbLink($wm_id,$_GET['offer_id']);

			$iframe_id = Offers::getLinksIframeOfferByID($_GET['offer_id']);
			if($iframe_id){
				$iframe_link = Offers::createdLink($wm_id,$iframe_id);
				$info['iframe_link'] = 'http://link.cpa-private.biz/?i='.$iframe_link;
			}else{
				$info['iframe_link'] = '';
			}
			
			
			$this->addVar("info", $info);
		// if(isset($cookie) && !empty($cookie)){        http://link.cpa-private.biz/
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
	public function createdLink(){
		$cookie = Cookie::get("hash");
		if(isset($cookie) && !empty($cookie)){
			$info = User::getInfoByHash($cookie);
			if(filter_var($info['type'], FILTER_VALIDATE_INT)){
				$type_user = $info['type'];
			}else{
				header('Location: /');
			}	
			
			if($type_user == 2 && $type_user == 3){
				header('Location: /');
			}else if($type_user == 1){
				$wm_id=$info['id'];
			}				
			if(isset($_POST['land_id']) && !empty($_POST['land_id']) && filter_var($_POST['land_id'], FILTER_VALIDATE_INT)){
				$land_id=$_POST['land_id'];
			}
			unset($_POST['land_id']);
			$params = $_REQUEST;
			foreach ($params as $key => $value){
					if(in_array($key, array('subid1', 'subid2', 'subid3')) && !empty($value)) {
						$fields[$key] = $value;
					}				
			}
			$identity = Offers::createdLink($wm_id,$land_id,$fields);
			
			if(isset($identity) && !empty($identity)){
				$this->output(array("response"=>'success',"text"=>"Ссылка обновлена","identity"=>$identity));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка при обновлении ссылки"));
			}
		}else{
			header('Location: /');
		}
		
	}
	public function setPostback(){
		$fields = array();
		$errors = array();
		do{
			if(isset($_POST['link']) && !empty($_POST['link']) && isset($_POST['params']) && !empty($_POST['params'])){
				
				$fields['url'] = $_POST['link'].'?'.join('&',explode(',',$_POST['params']));
			}else{
				$errors[] = 'отсутсвует ссылка postback';
			}
			if(isset($_POST['for_offer']) && !empty($_POST['for_offer'])){
				$fields['scope'] = $_POST['for_offer'];
			}else{
				$errors[] = 'error 1';
			}
			if((isset($_POST['s_new']) && !empty($_POST['s_new'])) || (isset($_POST['s_conf']) && !empty($_POST['s_conf'])) || (isset($_POST['s_rej']) && !empty($_POST['s_rej']))){
				$fields['status_new'] = $_POST['s_new'];
				$fields['status_confirm'] = $_POST['s_conf'];
				$fields['status_reject'] = $_POST['s_rej'];
			}else{
				$errors[] = 'Укажите статус срабатывания postback';
			}

			if($errors){
				break;
			}

			$cookie = Cookie::get("hash");
			$info = User::getInfoByHash($cookie);
			$fields['user_id'] = $info['id'];
			
			if(User::setPostback($fields)){
				$this->output(array("response"=>'success',"text"=>"Postback добавлен"));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка при добавлении постбека"));
			}
			
		}while(false);
		if($errors){
			$this->output(array("response"=>'error',"text"=>"Ошибка: ".join(', ', $errors)));
		}
	}
	public function createPelandLink(){
		$fields = array();
		$errors = array();
		do{
			if(isset($_POST['land_id']) && !empty($_POST['land_id']) && filter_var($_POST['land_id'], FILTER_VALIDATE_INT)){
				$land_id = $_POST['land_id'];
			}else{
				$errors[] = 'отсутсвует ID ландинга';
			}
			
			if(isset($_POST['preland_id']) && !empty($_POST['preland_id']) && filter_var($_POST['preland_id'], FILTER_VALIDATE_INT)){
				$preland_id = $_POST['preland_id'];
			}else{
				$errors[] = 'отсутсвует ID преландинга';
			}
			if(isset($_POST['name']) && !empty($_POST['name'])){
				$name = $_POST['name'];
			}else{
				$errors[] = 'отсутсвует название связки';
			}
			
			if($errors){
				break;
			}
			$cookie = Cookie::get("hash");
			if(isset($cookie) && !empty($cookie)){
				$info = User::getInfoByHash($cookie);
				if(filter_var($info['type'], FILTER_VALIDATE_INT)){
					$type_user = $info['type'];
				}else{
					header('Location: /');
				}	
				
				if($type_user == 2 && $type_user == 3){
					header('Location: /');
				}else if($type_user == 1){
					$wm_id=$info['id'];
				}
			}else{
				header('Location: /');
			}
			$i = Offers::createdPrelandLink($wm_id,$land_id,$preland_id,$name);

			if(isset($i) && !empty($i)){
				$this->output(array("response"=>'success',"identy"=>$i,"text"=>'Связка создана', "name"=>$name));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка при создании связки"));
			}
		
	}while(false);
		if($errors){
			$this->output(array("response"=>'error',"text"=>"Ошибка: ".join(', ', $errors)));
		}
	}
	public function setRetargeting(){
		if(isset($_POST['land_id']) && !empty($_POST['land_id'])){
			$cookie = Cookie::get("hash");
			if(isset($cookie) && !empty($cookie)){
				$info = User::getInfoByHash($cookie);
				if(filter_var($info['type'], FILTER_VALIDATE_INT)){
					$type_user = $info['type'];
				}else{
					header('Location: /');
				}	
				
				if($type_user == 2 && $type_user == 3){
					header('Location: /');
				}else if($type_user == 1){
					$wm_id=$info['id'];
				}
			}else{
				header('Location: /');
			}
			$land_id = $_POST['land_id'];
			unset($_POST['land_id']);
			unset($_POST['is_ajax']);
			$ret_id = array();
			foreach($_POST as $k=>$v){
				$ret_id[$k] = $v;
			}
			Offers::setRetargetingCode($wm_id,$land_id,$ret_id);
			$this->output(array("response"=>'success',"text"=>'Ретаргентинг обновлен'));
		}else{
			$this->output(array("response"=>'error',"text"=>"Ошибка: отсутсвует ID ленда"));
		}
	}
	public function getRetargeting(){
		if(isset($_POST['land_id']) && !empty($_POST['land_id'])){
			$cookie = Cookie::get("hash");
			if(isset($cookie) && !empty($cookie)){
				$info = User::getInfoByHash($cookie);
				if(filter_var($info['type'], FILTER_VALIDATE_INT)){
					$type_user = $info['type'];
				}else{
					header('Location: /');
				}	
				
				if($type_user == 2 && $type_user == 3){
					header('Location: /');
				}else if($type_user == 1){
					$wm_id=$info['id'];
				}
			}else{
				header('Location: /');
			}
			$land_id = $_POST['land_id'];
			$ret = Offers::getRetargetingCode($wm_id,$land_id);
			$this->output(array("response"=>'success',"ym"=>$ret['ym'],"rm"=>$ret['rm'],"vk"=>$ret['vk']));
		}else{
			$this->output(array("response"=>'error',"text"=>"Ошибка: отсутсвует ID ленда"));
		}
	}
	
	public function updlinkland(){
		if(isset($_POST['ind']) && !empty($_POST['ind']) && isset($_POST['l_id']) && !empty($_POST['l_id'])){
			$ind = $_POST['ind'];
			$l_id = $_POST['l_id'];
			if(User::updlinkland($ind,$l_id)){
				$this->output(array("response"=>'success',"text"=>'Ссылка обновленна'));
			}else{
				$this->output(array("response"=>'error',"text"=>'Ошибка при изменении ссылки'));
			}
		}else{
			$this->output(array("response"=>'error',"text"=>'Не выбран ленд или отсутсвует идентификатор ссылки'));
		}			
	}
	public function updSub(){
		if(isset($_POST['ind']) && !empty($_POST['ind']) && isset($_POST['sub']) && !empty($_POST['sub']) && isset($_POST['val']) && !empty($_POST['val'])){
			$ind = $_POST['ind'];
			$sub = $_POST['sub'];
			$val = $_POST['val'];
			
			$q = 'UPDATE `users_links` SET `'.$sub.'`="'.$val.'" WHERE `identity`="'.$ind.'"';
			
			if(IOMysqli::query($q)){
				$this->output(array("response"=>'success',"text"=>'Ссылка обновленна'));
			}else{
				$this->output(array("response"=>'error',"text"=>'Ошибка при изменении ссылки'));
			}
		}else{
			$this->output(array("response"=>'error',"text"=>'error'));
		}			
	}
	public function delLink(){
		if(isset($_POST['ind']) && !empty($_POST['ind'])){
			$ind = $_POST['ind'];
			
			$q = 'DELETE FROM `users_links` WHERE `identity`="'.$ind.'"';
			
			if(IOMysqli::query($q)){
				$this->output(array("response"=>'success',"text"=>'Ссылка удалена'));
			}else{
				$this->output(array("response"=>'error',"text"=>'Ошибка при удалении ссылки'));
			}
		}else{
			$this->output(array("response"=>'error',"text"=>'error'));
		}			
	}
}