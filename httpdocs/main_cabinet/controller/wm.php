<?php  
class C_Wm extends Controller {

    protected $template = "partner";
	
    public function main() {		
		$this->view = 'wm.php';
		$this->addVar("title", 'Вебмастера');
		$cookie = Cookie::get("hash");
		
				
		if(isset($cookie) && !empty($cookie)){
			$info = User::getInfoByHash($cookie);
			
			if(filter_var($info['type'], FILTER_VALIDATE_INT)){
				$user_id = $info['id'];
			}else{
				header('Location: /');
			}	

			if($user_id == 11 || $user_id == 10){						
				$data = Mainpartner::getAllWm();			
				$tr = '';
				foreach($data as $v){
					$class='';
					$btn_activ='';
					if($v['ban'] == 1){
						$class='style_for_banned';
					}else if($v['activate'] == 0){
						$class='no_active';
						$btn_activ = '<span class="a_b activeted"><i class="zmdi zmdi-hc-fw"></i></span>';
					}else{
						$class='';
						$btn_activ = '';
					}
					$tr .= '<tr data-partner_id="'.$v['id'].'" class="'.$class.'">
					<td>'.$v['id'].'</td>
					<td>'.$v['email'].'</td>
					<td>'.$v['refid'].'</td>
					<td>'.$v['balans'].'</td>
					<td><input type="number" value="0"></td>
					<td><span class="a_b add_balans"><i class="zmdi zmdi-hc-fw"></i></span><span class="a_b subtract_balans"><i class="zmdi zmdi-hc-fw"></i></span></td>
					<td>'.$btn_activ.'<span class="a_b delete"><i class="zmdi zmdi-hc-fw"></i></span></td>
					<td><span class="payments_wm">$</span></td>
					<td><a class="go_on_us" data-wm="'.$v['id'].'"><i class="zmdi zmdi-hc-fw"></i></a></td>
					</tr>		
					';
				}
				$this->addVar("t_u", $tr);
			}else{
				header('Location: /');
			}	
		}else{
			header('Location: /');
		}
	   parent::main();

    } 
	public function changeHash(){
		$q = 'SELECT `hash` FROM `users_hash` WHERE `user_id`='.$_REQUEST['user_id'].' LIMIT 1';
		$hash = IOMysqli::one($q);
		Cookie::deleteCookie("hash");	
		Cookie::set('hash',  $hash, strtotime("1 day"));		
		header ("Location: /");

	}

}
