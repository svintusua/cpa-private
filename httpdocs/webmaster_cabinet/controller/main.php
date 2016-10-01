<?php
class C_Main extends Controller {

    protected $template = "wm";
	
    public function main() {		
		$this->addVar("title", 'Статистика');
		if(isset($_GET['wid']) && !empty($_GET['wid']) && filter_var($_GET['wid'], FILTER_VALIDATE_INT) && $_GET['cpa']=='private'){
			
			$adm = 1;
		}else{
			$cookie = Cookie::get("hash");
			$adm=0;
		}		
		if(isset($cookie) && !empty($cookie) || $adm == 1){
			if($adm == 1){
				$type_user = 1;
				$user_id = $_GET['wid'];
			}else{
				$info = User::getInfoByHash($cookie);
				if(filter_var($info['type'], FILTER_VALIDATE_INT)){
					$type_user = $info['type'];
					$user_id = $info['id'];
					$this->addVar("refid", $user_id);
				}else{
					header('Location: /');
				}	
			}
			if($type_user == 2 || $type_user == 3){
				header('Location: /');
			}				
		}else{
			header('Location: /');
		}
			$all_table = Offers::getOffers();
			$o = '<option></opton>';
			foreach($all_table as $v){
				$o .=  '<option value="'.$v['id'].'">'.$v['name'].'</opton>';
			}
			$this->addVar("name", explode('@',$info['email'])[0]);
			$stat = User::statistics($user_id);
			$tr = '';
			foreach($stat as $k=>$v){
				$approve = ceil(($v['apr_count']/($v['apr_count']+$v['hold_count']+$v['deny_count']))*100);
				$cr = ceil((($v['apr_count']+$v['hold_count']+$v['deny_count'])/($v['clicks']))*100);
				$epc = ceil($v['apr_sum']/$v['clicks']);
				$tr .= '<tr class="search-row">
                        <td>'.$k.'</td>
                        <td class="clicks">'.$v['clicks'].'</td>
                        <td>'.$v['uniq'].'</td>
                        <td>'.$v['tb'].'</td>
                        <td>'.$cr.'%</td>
                        <td>'.$epc.'</td>
                        <td>'.$approve.'%</td>
                        <td class="color-green">'.$v['apr_count'].'</td>
                        <td>'.$v['hold_count'].'</td>
                        <td class="color-red">'.$v['deny_count'].'</td>
                        <td class="color-green">'.$v['apr_sum'].'</td>
                        <td>'.$v['hold_sum'].'</td>
                        <td class="no-border color-red">'.$v['deny_sum'].'</td>
                    </tr>';				
			}
			
			$this->addVar("stat_tr", $tr);
			$b = User::getBalansByUserId($user_id);
			if(isset($b[1]) && !empty($b[1])){
				$hold = $b[1];
			}else{
				$hold = 0;
			} 
			if(isset($b[2]) && !empty($b[2])){
				$balans = $b[2];
			}else{
				$balans = 0;
			}
			
			$this->addVar("balans", $balans);
			$this->addVar("hold", $hold);
			$this->addVar("op", $o);
		parent::main();
	}
	public function getStatisticByDay(){
		if(isset($_POST['day']) && !empty($_POST['day'])){
			if(isset($_POST['subs']) && !empty($_POST['subs'])){
				$subs = $_POST['subs'];
			}else{
				$subs = '';
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
			if($subs == 'undefined'){
				$subs='';
			}
			$data = User::getStatisticByDay($_POST['day'], $user_id, $subs);
			if($data){
				$tr = '';
				foreach($data as $v){
					$geo = json_decode(Ipgeo::geoByIp($v['ip']), true);
					switch($v['user_status']){
						case 0:
							$status = 'Отменен';
						break;
						case 1:
							$status = 'В ожидании';
						break;
						case 2:
							$status = 'Подтвержден';
						break;
					}
					$tr .='<tr><td>'.date("d.m.Y H:i:s", $v['date']).'</td><td>'.$geo['country']['name_ru'].' - '.['city']['name_ru'].'</td><td>'.$v['name'].'</td><td>'.$v['subid1'].'</td>'.				
					'<td>'.$v['subid2'].'</td><td>'.$v['subid3'].'</td><td>'.$status.'</td><td>'.$v['pay'].'</td></tr>';
				}
				
			}else{
				$tr = '<tr><td colspan="8">Лидов за этот день нет</td></tr>';
			}
			$t_head = '<table><tr><th>Дата</th><th>Гео</th><th>Оффер</th><th>SubID1</th><th>SubID2</th><th>SubID3</th><th>Статус</th><th>Сумма</th></tr>';
			$this->output(array("response"=>'success',"text"=>$t_head.$tr.'</table>'));
		}else{
			$this->output(array("response"=>'error',"text"=>"Отсутсвуйет дата"));
		}
	}
	public function getStatisticClicksByDay(){
		
		if(isset($_POST['day']) && !empty($_POST['day'])){			
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
			$data = User::getStatisticClicksByDay($_POST['day'], $user_id);
			if($data){
				foreach($data['clicks'] as $v){
					$c_tr .= '<tr><td>'.$v['date'].'</td><td>'.$v['identity'].'</td><td>'.$v['count'].'</td><td>'.$v['subid1'].'</td><td>'.$v['subid2'].'</td><td>'.$v['subid3'].'</td></td>';
				}
			}else{
				$tr = '<tr><td colspan="6">Кликов за этот день нет</td></tr>';
			}
			$t_head = '<table><tr><th>дата</th><th>ID ссылки</th><th>кол-во</th><th>SubID1</th><th>SubID2</th><th>SubID3</th></tr>'.$c_tr.'</table>';
			$this->output(array("response"=>'success',"text"=>$t_head));
		}else{
			$this->output(array("response"=>'error',"text"=>"Отсутсвуйет дата"));
		}
	}
	public function filterStat(){
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
		unset($_POST['is_ajax']);
		$filter = array();
		$date = array();
		
		foreach($_POST as $k=>$v){
					
			if($k=='date_from'){
				list($d,$m,$y) = explode('.', $_POST['date_from']);
				$date['from'] = $y.$m.$d;
			}else if($k=='date_to'){
				list($d,$m,$y) = explode('.', $_POST['date_to']);
				$date['to'] = $y.$m.$d;
			}else{
				$filter[$k]=$v;
			}
			
		}
		$stat = User::statistics($user_id,$date,$filter);
			$tr = '';
			foreach($stat as $k=>$v){
				$approve = ceil(($v['apr_count']/($v['apr_count']+$v['hold_count']+$v['deny_count']))*100);
				$cr = ceil((($v['apr_count']+$v['hold_count']+$v['deny_count'])/($v['clicks']))*100);
				$epc = ceil($v['apr_sum']/$v['clicks']);
				$tr .= '<tr class="search-row"><td>'.$k.'</td><td>'.$v['clicks'].'</td><td>'.$v['uniq'].'</td><td>'.$v['tb'].'</td><td>'.$cr.'%</td><td>'.$epc.'</td><td>'.$approve.'%</td><td class="color-green">'.$v['apr_count'].'</td><td>'.$v['hold_count'].'</td><td class="color-red">'.$v['deny_count'].'</td><td class="color-green">'.$v['apr_sum'].'</td><td>'.$v['hold_sum'].'</td><td class="no-border color-red">'.$v['deny_sum'].'</td></tr>';				
			}

			$this->output(array("response"=>'success',"text"=>$tr));
	}
	public function setTbLink(){
		if(isset($_POST['offer_id']) && !empty($_POST['offer_id'])){
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
			$tb_link = $_POST['tb_link'];			
			$offer_id = $_POST['offer_id'];			
			$resp = Offers::setTbLink($user_id,$offer_id,$tb_link);
			
			if(isset($resp) && !empty($resp)){
				$this->output(array("response"=>'success',"text"=>'Ссылка создана/изменена успешно'));
			}else{
				$this->output(array("response"=>'errors',"text"=>'Ошибка при создании/изменении ссылки'));
			}
		}else{
			$this->output(array("response"=>'errors',"text"=>'Отсутсвуйет ID оффера'));
		}
	}
	
}