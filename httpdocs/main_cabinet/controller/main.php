<?php  
class C_Main extends Controller {

    protected $template = "partner";
	
    public function main() {		
		
		$this->addVar("title", 'Главный кабинет');
		$cookie = Cookie::get("hash");
		if(isset($cookie) && !empty($cookie)){
			$info = User::getInfoByHash($cookie);
			
			if(filter_var($info['type'], FILTER_VALIDATE_INT)){
				$user_id = $info['id'];
			}else{
				header('Location: /');
			}	

			// if($user_id == 11 || $user_id == 10){						
				$data = Mainpartner::getAllBalansPartner();			
				$tr = '';
				foreach($data as $v){
					$tr .= '<tr data-partner_id="'.$v['id'].'">
					<td>'.$v['id'].'</td>
					<td>'.$v['email'].'</td>
					<td>'.$v['balans'].'</td>
					<td><input type="number" value="0"></td>			
					<td><span class="a_b add_balans"><i class="zmdi zmdi-hc-fw"></i></span><span class="a_b subtract_balans"><i class="zmdi zmdi-hc-fw"></i></span></td>
					</tr>
					<tr data-history_partner_id="'.$v['id'].'" class="history_operation">
					<td colspan="5">
						<div class="history_operation_div"></div>				
					</td>
					</tr>			
					';
				}
				$this->addVar("t_u", $tr);
				// }else{	
					// header('Location: /');
				// }				
		}else{
			header('Location: /');
		}	
		
	   parent::main();

    }
	public function operationBalans(){
		$errors = array();
		$fields = array();
		do{
			if($_POST['p_id']){
				$fields['pid'] = $_POST['p_id'];
			}else{
				$errors[] = 'Отсутсвует ID партнера';
			}
			if($_POST['sum']){
				$fields['sum'] = $_POST['sum'];
			}else{
				$fields['sum'] = 0;
			}
			if($_POST['operation']){
				$fields['operation'] = $_POST['operation'];
			}else{
				$errors[] = 'Отсутсвует тип операции';
			}
			if($errors){
				break;
			}
			$res = User::operationBalans($fields);
			if($res){
				switch($fields['operation']){
					case 1:
						$this->output(array("response"=>'success',"text"=>'Баланс пополнен'));
					break;
					case 2:
						$this->output(array("response"=>'success',"text"=>'Списание с баланса произошло успешно'));
					break;			
				}
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка при операции"));
			}
		}while(false);
		if($error){
			$this->output(array("response"=>'error',"text"=>"Ошибка: ".join(',',$errors)));
		}
	}
	public function getHistoryOperation(){
		$errors = array();
		do{
			if(!$pid = $_POST['p_id']){
				$errors[] = 'Отсутсвует ID партнера';
			}
			
			$res = User::getOperationBalans($pid);
			$head = '<table><tr><th>Сумма</th><th>Дата</th></tr>';
			$tr = '';
			if($res){
				foreach($res as $v){
					if($v['action'] == 1){
						$class = 'b_add';
					}else if($v['action'] == 2){
						$class = 'b_subtract';
					}
					$tr .= '<tr class="'.$class.'"><td>'.$v['sum'].'</td><td>'.$v['date'].'</td></tr>';
				}
				$this->output(array("response"=>'success',"text"=>$head.$tr."</table>"));
			}else{
				$this->output(array("response"=>'error',"text"=>"Данные отсутсвуют"));
			}
		}while(false);
		if($error){
			$this->output(array("response"=>'error',"text"=>"Ошибка: ".join(',',$errors)));
		}
	}
	
	public function wmActivated(){
		$errors = array();
		do{
			if(!$pid = $_POST['wm_id']){
				$errors[] = 'Отсутсвует ID веба';
			}
			if($errors){
				break;
			}
			$res = Mainpartner::activateWm($pid);
			
			if($res){				
				$this->output(array("response"=>'success',"text"=>"Веб активирован"));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка при активации"));
			}
		}while(false);
		if($error){
			$this->output(array("response"=>'error',"text"=>"Отсутвует id веба"));
		}
	}
	public function wmBaned(){
		$errors = array();
		do{
			if(!$pid = $_POST['wm_id']){
				$errors[] = 'Отсутсвует ID веба';
			}
			if($errors){
				break;
			}
			$res = Mainpartner::banWm($pid);
			
			if($res){				
				$this->output(array("response"=>'success',"text"=>"Веб забанен"));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка при бане"));
			}
		}while(false);
		if($error){
			$this->output(array("response"=>'error',"text"=>"Отсутвует id веба"));
		}
	}
	public function wmDelete(){
		$errors = array();
		do{
			if(!$pid = $_POST['wm_id']){
				$errors[] = 'Отсутсвует ID веба';
			}
			if($errors){
				break;
			}
			$res = Mainpartner::delWm($pid);
			
			if($res){				
				$this->output(array("response"=>'success',"text"=>"Веб удален"));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка при удалении"));
			}
		}while(false);
		if($error){
			$this->output(array("response"=>'error',"text"=>"Отсутвует id веба"));
		}
	}
	public function infoWM(){
		$errors = array();
		do{
			if(!$pid = $_POST['wm_id']){
				$errors[] = 'Отсутсвует ID веба';
			}
			if($errors){
				break;
			}
			$resp = Mainpartner::infoWM($pid);

			if($resp){				
				$this->output(array("response"=>'success',"clicks"=>$resp['clicks']['clicks'], "uniq"=>$resp['clicks']['uniq'], "all"=>$resp['leads']['all'], "appr"=>$resp['leads']['2'], "del"=>$resp['leads']['0'], "hold"=>$resp['leads']['1'], "balans"=>$resp['balans']));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка при получении данных"));
			}
		}while(false);
		if($error){
			$this->output(array("response"=>'error',"text"=>"Отсутвует id веба"));
		}
	}
	public function infoPayments(){
		$errors = array();
		do{
			if(!$pid = $_POST['wm_id']){
				$errors[] = 'Отсутсвует ID веба';
			}
			if($errors){
				break;
			}
			
			$resp = Mainpartner::infoPayments($pid);

			if($resp){				
				$this->output(array("response"=>'success',"table"=>$resp));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка при получении данных"));
			}
		}while(false);
		if($error){
			$this->output(array("response"=>'error',"text"=>"Отсутвует id веба"));
		}
	}
	
}
