<?php  
class C_Payments extends Controller {

    protected $template = "partner";
	
    public function main() {		
		$this->view = 'payments.php';
		$this->addVar("title", 'Выплаты');
		$cookie = Cookie::get("hash");
		
				
		if(isset($cookie) && !empty($cookie)){
			$info = User::getInfoByHash($cookie);
			
			if(filter_var($info['type'], FILTER_VALIDATE_INT)){
				$user_id = $info['id'];
			}else{
				header('Location: /');
			}	

			if($user_id == 11 || $user_id == 10){						
				$data = Mainpartner::getPaments();			
				$tr = '';
				foreach($data as $v){
					switch ($v['status']) {
						case 0:
							$status = 'отклонена';
							break;
						case 1:
							$status = 'в ожидании';
							break;
						case 2:
							$status = 'подтверждена';
							break;
						case 3:
							$status = 'выплачена';
							break;
						
						default:
							# code...
							break;
					}
					$tr .= '<tr>
					<td>'.$v['user_id'].'</td>
					<td>'.$v['dt'].'</td>
					<td>'.$v['sum'].'</td>
					<td>'.$status.'</td>
					<td>
						<select class="status_payments" data-id="'.$v['id'].'">
							<option selected disabled>выберите статус</option>
							<option value="0">отклонить</option>
							<option value="1">в ожидании</option>
							<option value="2">подтвердить</option>
							<option value="3">выплачена</option>
						</select>
					</td>
					
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
    public function updatestatus(){
    	if($_POST['val'] && $_POST['p_id']){
    		Mainpartner::updStatusPayment($_POST['p_id'],$_POST['val']);
    	}
    }
}
