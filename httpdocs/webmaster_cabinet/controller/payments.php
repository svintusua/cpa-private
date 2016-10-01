<?php

class C_Payments extends Controller {

    protected $template = "wm";
	
	public function main() {
		//<?=$this->vars['img_all']
		// var_dump(Offers::getOffers());
		// exit;
		$this->view = 'payments.php';
		$this->addVar("title", 'Выплаты');
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
		$wallet = User::getUserWallets($wm_id);
		if($wallet){
			$option = '';
			foreach($wallet as $k=>$v){
				$option .= '<option value="'.$k.'">'.$v.'</option>';
			}
			$this->addVar("wallet", $option);
		}else{
			$this->addVar("wallet", '<option value="0">Вы еще не завели кошелек</option>');
		}
		$pay = User::getPaymentByUserId($wm_id);

		if($pay){
			$tr = '';
			foreach($pay as $v){
				switch($v['status']){
					case 0:
						$status = 'отклонен';
					break;
					case 1:
						$status = 'в ожидании';
					break;
					case 2:
						$status = 'подтвержден';
					break;
					case 3:
						$status = 'выплачен';
					break;
					
				}
				// $wallet = '';
				// switch($v['wallet_type']){
					// case 1:
						// $wallet = 'QIWI - '.$v['wallet_number'];
					// break;
					// case 2:
						// $wallet = 'R'.$v['wallet_number'];
					// break;
					// case 3:
						// $wallet = 'Z'.$v['wallet_number'];
					// break;
					// case 4:
						// $wallet = 'Яндекс - '.$v['wallet_number'];
					// break;
				// }
				//<td>'.$wallet.'</td>
				$tr .= '<tr>
							<td>'.date("d.m.Y H:i", $v['date']).'</td>
							<td>'.$v['sum'].'</td>
							<td>'.$status.'</td>
						</tr>';
			}
			$this->addVar("tr", $tr);
		}else{
			$this->addVar("tr", '<tr><td colspan="4">выплат еще не было</td></tr>');
		}
		$this->addVar("balans", User::getBalansByUserId($wm_id)[2]);
		$this->addVar("hold", User::getBalansByUserId($wm_id)[1]);
			if(!$summa=IOMysqli::one('select summa from withdrawal where user_id='.$wm_id)){
			$summa=0;
		}
		$this->addVar("summa", $summa);

		parent::main();
	}
	public function payout(){
		// if(isset($_POST['wallet_id']) && !empty($_POST['wallet_id'])){
			$w_id = $_POST['wallet_id'];
			if(!$summa = $_POST['summa']){
				$summa = 0;
			}
			$cookie = Cookie::get("hash");			
			if(isset($cookie) && !empty($cookie)){
				$info = User::getInfoByHash($cookie);
				if(filter_var($info['type'], FILTER_VALIDATE_INT)){
					$type_user = $info['type'];
					$user_id = $info['id'];
				}else{
					header('Location: /');
				}	
				
				if($type_user == 2 || $type_user == 3){
					header('Location: /');
				}				
			}else{
				header('Location: /');
			}
			$resp = User::setPayment($user_id,$summa,$w_id);
			if(isset($resp) && !empty($resp)){
				$this->output(array("response"=>'success',"text"=>"Баланс выведен. Теперь вы можете запросить выплату"));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ваш баланс равен 0"));
			}
			
		// }else{
			// $this->output(array("response"=>'error',"text"=>"Отсутсвуйет кошелек"));
		// }
	}
	public function giveMoney(){
		// if(isset($_POST['wallet_id']) && !empty($_POST['wallet_id'])){

			if(!$_POST['summa'] || $_POST['summa'] == 0){
				//$summa = 0;
				$this->output(array("response"=>'error',"text"=>"Сумма выпла отсутсвует или пустая"));
			}else{
				$summa = $_POST['summa'];
			$cookie = Cookie::get("hash");			
			if(isset($cookie) && !empty($cookie)){
				$info = User::getInfoByHash($cookie);
				if(filter_var($info['type'], FILTER_VALIDATE_INT)){
					$type_user = $info['type'];
					$user_id = $info['id'];
				}else{
					header('Location: /');
				}	
				
				if($type_user == 2 || $type_user == 3){
					header('Location: /');
				}				
			}else{
				header('Location: /');
			}
			$resp = User::giveMoney($user_id,$summa);
			if(isset($resp) && !empty($resp)){
				$this->output(array("response"=>'success',"text"=>"Запрос на выплату отправлен"));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка при запросе выплаты"));
			}
		}
			
		// }else{
			// $this->output(array("response"=>'error',"text"=>"Отсутсвуйет кошелек"));
		// }
	}
}