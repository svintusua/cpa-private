<?

class Mainpartner{
	static public function getAllBalansPartner(){
		$q = 'SELECT id,email,balans from users where type=2';// and id != 11';
		return IOMysqli::table($q);
	}
	static public function getAllWm(){
		$q = 'SELECT id,email,activate,ban,balans,refid from users where type=1';// and id != 11';
		return IOMysqli::table($q);
	}
	static public function activateWm($wm_id){
		if(isset($wm_id) && !empty($wm_id) && filter_var($wm_id, FILTER_VALIDATE_INT)){
			$q = 'UPDATE `users` SET `activate`=1 WHERE `id`='.$wm_id;// and id != 11';
			
			return IOMysqli::query($q);
		}else{
			return false;
		}
		
	}
	static public function banWm($wm_id){
		if(isset($wm_id) && !empty($wm_id) && filter_var($wm_id, FILTER_VALIDATE_INT)){
			$q = 'UPDATE `users` SET `ban`=1 WHERE `id`='.$wm_id;// and id != 11';
			
			return IOMysqli::query($q);
		}else{
			return false;
		}
		
	}
	static public function delWm($wm_id){
		if(isset($wm_id) && !empty($wm_id) && filter_var($wm_id, FILTER_VALIDATE_INT)){
			$q = 'DELETE FROM `users` WHERE `id`='.$wm_id;// and id != 11';
			
			return IOMysqli::query($q);
		}else{
			return false;
		}
		
	}
	static public function infoWm($wm_id){
		if(isset($wm_id) && !empty($wm_id) && filter_var($wm_id, FILTER_VALIDATE_INT)){
			$q = 'SELECT sum(c.repeat) as clicks, count(DISTINCT c.ip) as uniq FROM `clicks` as c WHERE c.user_id='.$wm_id;// and id != 11';
			$clicks = IOMysqli::row($q);
			$q = 'SELECT count(id) as l, user_status FROM `orders` WHERE user_id='.$wm_id.' and payout_id=0 and user_status != 5 Group BY user_status';
			$resp  = IOMysqli::table($q);
			$q = 'SELECT balans FROM users WHERE id='.$wm_id;
			$balans  = IOMysqli::one($q);
			$leads = array();
			$leads['all'] = 0;
			foreach($resp as $v){
				$leads[$v['user_status']] = $v['l'];
				$leads['all'] += $v['l'];
			}
			return array('clicks'=>$clicks, 'leads'=>$leads, 'balans'=>$balans);
		}else{
			return false;
		}
		
	}
	static public function infoPayments($wm_id){
		if(isset($wm_id) && !empty($wm_id) && filter_var($wm_id, FILTER_VALIDATE_INT)){
			$q = 'SELECT from_unixtime(`date`) as d,`sum`,`status` FROM `users_payments` WHERE `user_id`='.$wm_id.' ORDER BY d DESC';
			$data = IOMysqli::table($q);
			$tr = '';
			foreach($data as $v){
				$tr .='<tr><td>'.$v['d'].'</td><td>'.$v['sum'].'</td></tr>';//<td>'.$v['status'].'</td>
			}
			return '<table><th>дата</th><th>сумма</th></tr>'.$tr.'</table>';//<th>стат</th>
		}else{
			return false;
		}
		
	}
	static public function getPaments(){
		$q='SELECT id,user_id, from_unixtime(date) as dt, sum, status FROM users_payments WHERE sum!=0 ORDER BY id DESC';
		return IOMysqli::table($q);
	}
	static public function updStatusPayment($id,$status){
		if($id && $status && filter_var($id,FILTER_VALIDATE_INT) && filter_var($status,FILTER_VALIDATE_INT)){
			$q = 'UPDATE users_payments SET status='.$status.' WHERE id='.$id.' limit 1';
			return IOMysqli::query($q);
		}else{
			return false;
		}
	}
}