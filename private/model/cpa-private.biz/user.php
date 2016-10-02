<?php


class User extends Model {

   
    const COOKIE_ENTER = "hash";

    static $current;
    protected static $table = "users";
//    protected static $columes = array("firstname", "lastname", "birthday", "email", "phone", "password", "uid", "social_network");
    protected static $columes = array("email", "password", "date_reg");

    const USER_LOGIN = "login";
    const USER_PASSWORD = "password";
     
    protected static function getLinked(&$user) {
        //todo написать запрос на выборку id
        $query = "Select id from img where `user_id`='" . User::$current['id'] . "'";
        $user['picture_ids'] = IOMysqli::table($query);
    }

    protected static function hash($user_id, $domain) {
		$hash = md5($user_id . $domain . "khgfk*/43!@" . date("Y-m-d H:i:s"));
		$ip = $_SERVER['REMOTE_ADDR'];
		$query='INSERT INTO `users_hash`(`user_id`, `hash`, `date`, `ip`) VALUES (' . $user_id . ',"' . $hash . '",UNIX_TIMESTAMP(now()), "'.$ip.'" )';	
		IOMysqli::query($query);           
        return $hash;
    }

    protected static function generatePassword() {
        $arr = array('a', 'b', 'c', 'd', 'e', 'f',
                     'g', 'h', 'i', 'j', 'k', 'l',
                     'm', 'n', 'o', 'p', 'r', 's',
                     't', 'u', 'v', 'x', 'y', 'z',
                     'A', 'B', 'C', 'D', 'E', 'F',
                     'G', 'H', 'I', 'J', 'K', 'L',
                     'M', 'N', 'O', 'P', 'R', 'S',
                     'T', 'U', 'V', 'X', 'Y', 'Z',
                     '1', '2', '3', '4', '5', '6',
                     '7', '8', '9', '0');

        $pass = "";

        for ($i = 0; $i < 8; $i++) {

            $index = rand(0, count($arr) - 1);

            $pass .= $arr[$index];
        }

        return $pass;
    }

    public static function updatePassword($id,$oldpassword,$newpassword){
        if (!filter_var($id,FILTER_VALIDATE_INT) || !$id){
            return 'Неправильный ID пользователя';
        }
        $query='select password from users where id='.$id;
        $oldpas=  IOMysqli::one($query);
        $oldpassword=md5(md5($oldpassword.'HyBmna194#$@djJ'));
        if(md5($oldpassword)!=$oldpas){
            return 'Прежний пароль введён неправильно';
        }
        $query = 'update `' . static::$table . '` set `password`="' . md5(md5($newpassword.'HyBmna194#$@djJ')) . '" where id=' . $id;
        if (!IOMysqli::query($query)) {
            return "Ошибка при изменении пароля";
        }
        return "Пароль изменен";
    }

    public static function recover($email) {
        if (!($id = static::getIdByEmail($email))) {
            return 1;
        }
        $password = static::generatePassword();
        if(!$password){
            return 2; 
        }
        $query = 'update `' . static::$table . '` set `password`="' .md5(md5($password.'HyBmna194#$@djJ')). '" where id=' . $id;
        if (!IOMysqli::query($query)) {
            return 3;
        }
        $message = 'Ваш новый пароль - ' . $password;
        $msg = '<html>
            <head>
            <meta charset="urf-8"/>
            <title>Востановление пароля</title>
            </head>
				<body style="width:100%;height:100%; background-color:#765939;">
					<div id="content" style="width:85%;border:2px solid #fff;margin: auto;position: relative;">
					<img src="http://cpa-private.biz/img/partner/logo.png">
					<div class="text" style="width:100%;box-sizing: border-box;padding:10px;color: #4a4a4a;">
						<p><b>Пароль успешно востановлен!</b></p>
						<p>Ваш новый пароль: <b>'.$password.'</b></p>
					</div>
				</div>
            </body>
            </html>';
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers  .= "Content-type: text/html; charset=utf-8 \r\n";
            $headers .= "From: Приватная партнерская программа <no-reply@cpa-private.biz>\r\n"; 
            $rrr=mail($email, "Востановление пароля на ППП", $msg, $headers);
        if ($rrr===true) {
            return 5;
        }else{
            return 4;
        }
        
    }
    public static function getEmailByID($id) {
        if (!filter_var($id, FILTER_VALIDATE_INT))
            return false;
        $key = "user#id#email#{$email}";
//        if ($id = IOCache::get($key))
//            return $id;

        $q = 'select email from ' . static::$table . ' where id = ' . IOMysqli::esc($id);

        if (!$id = IOMysqli::one($q))
            return false;

//        IOCache::set($key, $id, $id ? 0 : 5);
        return $id;
    }
    public static function getIdByEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return false;
        $key = "user#id#email#{$email}";
//        if ($id = IOCache::get($key))
//            return $id;

        $q = 'select id from ' . static::$table . ' where email = "' . IOMysqli::esc($email) . '"';

        if (!$id = IOMysqli::one($q))
            return false;

//        IOCache::set($key, $id, $id ? 0 : 5);
        return $id;
    }

    public static function enter($login = null, $password = null) {	
        $login = trim($login)? : trim($_POST[static::USER_LOGIN]);
        $password = trim($password)? : trim($_POST[static::USER_PASSWORD]);

        if ($login && $password) {
		
            $q = 'select id from ' . static::$table . ' where email = "' . IOMysqli::esc($login) . '" and password = "' . md5(md5($password.'HyBmna194#$@djJ')) . '"';

            if (!($id = IOMysqli::one($q))) {
                return false;
            }
            //$user = User::get($id);
			
            $param = static::hash($id, $_SERVER["HTTP_HOST"]);
			
            Cookie::set(static::COOKIE_ENTER,  $param, strtotime("1 year"));
           // static::$current = $user;
//            User::onEnter();
            return true;
        }
       /* if ($cookie = Cookie::get(static::COOKIE_ENTER)) {
            //list($id, $param) = explode("-", $cookie);
			$param = $cookie;
			$id = static::getIdByHash($param);
            if (!filter_var($id, FILTER_VALIDATE_INT) || empty($param)) {
                Cookie::delete(static::COOKIE_ENTER);
                //  var_dump(__LINE__);
                return false;
            }
            if ($param != static::hash($id, $_SERVER["HTTP_HOST"])) {
                Cookie::delete(static::COOKIE_ENTER);
                //var_dump(__LINE__);
                return false;
            }
            if (!($user = User::get($id))) {
                Cookie::delete(static::COOKIE_ENTER);
                // var_dump(__LINE__);
                return false;
            }
            //  User::onEnter();
            static::$current = $user;
            return $user;
        }
		*/
    }
	public static function getIdByHash($hash) {
		if(isset($hash) && !empty($hash)){
			$query = 'select user_id from `users_hash` where `hash` = "' . $hash .'" LIMIT 1';
			return IOMysqli::one($query);
		}else{
			return false;
		}		     
	}
	public static function getInfoByHash($hash) {
		if(isset($hash) && !empty($hash)){
			$user_id = static::getIdByHash($hash);
			$query = 'select * from `users` where `id` = ' . $user_id.' LIMIT 1';
			$info = IOMysqli::row($query);
			if(isset($info) && is_array($info)){
				return $info;
			}else{
				return false;
			}					
		}else{
			return false;
		}		     
	}
    public static function onEnter() {
        if (!filter_var(User::$current['id'], FILTER_VALIDATE_INT))
            return FALSE;
        $id = User::$current['id'];
        $ip = preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "";
//        $q = "INSERT DELAYED INTO `last_enter` (`id`,`dt`,`last_dt`,`ip`) values ('{$id}',now(),now(),INET_ATON('{$ip}'))" .
//                "ON DUPLICATE KEY UPDATE `last_dt`=now(), `ip`=INET_ATON('{$ip}')";
//        IOMysqli::query($q);
    }
	
    public static function set($fields = array(), $info=array()) {
        $query='Select id from users where email="'.$fields['email'].'"';	

        $proverka=  IOMysqli::one($query);

        if($proverka){
				return 'user exists';		
        }
        unset($fields["id"]);
        unset($fields["dt"]);
		
        $clear_pass=$fields['password'];
        $fields['password']=md5(md5($fields['password'].'HyBmna194#$@djJ'));

            $q = "INSERT INTO " . static::$table . " (`date`,`" . join("`,`", array_keys($fields)) . "`) values (UNIX_TIMESTAMP(now()),'" . join("','", $fields) . "')";
       
	    $result = IOMysqli::query($q);
	    $user_id = static::getIdByEmail($fields['email']);
	   
	    $activation_hash = md5($user_id.$fields['email'].'activated_ld76SHnfs#DFsd#(_)');
	   
		$q='INSERT INTO `user_activation` (`user_id`, `activated_hash`, `active`) values ('.$user_id.',"'.$activation_hash.'",0)';
		IOMysqli::query($q);
		switch($fields['type']){
			case 1:
				$q='INSERT INTO `users_info`(`user_id`,`about`) VALUES ('.$user_id.',"'.$info['about'].'")';
				IOMysqli::query($q);
			break;
			case 2:
				$q='INSERT INTO `partner_info`(`user_id`,`phone`,`about`,`surname`,`name`,`lastname`) VALUES ('.$user_id.',"'.$info['phone'].'","'.$info['about'].'","'.$info['surname'].'","'.$info['name'].'","'.$info['lastname'].'")';
				IOMysqli::query($q);
			break;
		}
		$result = array();
            $msg = '<html>
            <head>
            <meta charset="urf-8"/>
            <title>Аккаунт создан</title>
            </head>
            <body style="width:100%;height:100%; background-color:#ededed;">
				<div id="content" style="padding: 20px;">
					<img src="http://cpa-private.biz/img/logo.png" style="display: block; margin:auto; width: 200px;">
					<div class="text" style="width:100%;box-sizing: border-box;padding:10px;color: #4a4a4a;">
						<p><b>Мы рады что вы присоединились к нам!</b></p>
						<p>Ваш логин: <b>'.$fields['email'].'</b></p>
						<p>Ваш пароль: <b>'.$clear_pass.'</b></p>
						<p>Для завершения регистрации перейдите по <a href="http://cpa-private.biz/activation?'.$activation_hash.'" target="_blank">ссылке</a></p>
                                                <p>По всем вопросам обращайтесь по почте - <b>support@cpa-private.biz</b></p>
                                                <hr>
                        <div style="text-align: center;"><h5>Служба технической поддержки:<h5>
                        <p>Роман Марков</p>
                        <p>skype: <a href="skype:cpa-privat_support">cpa-privat_support</a></p> 
						mail: <a href="mailto:support@cpa-private.biz">support@cpa-private.biz</a></p>
						</div>
					</div>
				</div>
            </body>
            </html>';
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers  .= "Content-type: text/html; charset=utf-8 \r\n";
            $headers .= "From: Cpa-Private <no-reply@cpa-private.biz>\r\n"; 
            if(mail($fields['email'], "Регистрация на Cpa-Private", $msg, $headers)){
                $result[1]="Регистрация прошла успешно. Вам на почту отправлено письмо. Для окончания регистрации перейдите по ссылке из письма";
                $result[0]=true;
            }else{
                $result[1]="Ошибка при отправке";
                $result[0]=false;
            }
      
        return $result;
		
    }
	
	public static function activatedUsers($activated_hash){
		if(strlen($activated_hash) == 32){
			$q = 'SELECT `user_id`,`active` FROM `user_activation` WHERE activated_hash="'.$activated_hash.'" LIMIT 1';
			$information = IOMysqli::row($q);
			
			if($information['active'] == 0 && $information['active'] != NULL){
				
				$q = 'UPDATE `user_activation` SET `active`=1 WHERE `user_id`='.$information['user_id'];
				IOMysqli::query($q);
				$q = 'UPDATE `users` SET `activate`=1 WHERE `id`='.$information['user_id'];
				IOMysqli::query($q);

				$param = static::hash($information['user_id'], $_SERVER["HTTP_HOST"]);

				Cookie::set(static::COOKIE_ENTER,  $param, strtotime("1 year"));


				return true;
				
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	public static function redirect($hash){
		if(strlen($hash)==32){
			$info = static::getInfoByHash($hash);
					
			if(filter_var($info['type'], FILTER_VALIDATE_INT)){
				$type_user = $info['type'];
			}else{
				return false;
			}			
			switch($type_user){
				case 1:
					header('Location: /webmaster_cabinet');
				break;
				case 2:
				case 3:
					header('Location: /partner_cabinet');
				break;
				default: 
					header('Location: /');
			}
		}else{
			return false;
		}		
	}
	static public function statistics($user_id,$date,$filter){

		if(isset($user_id) && !empty($user_id) && filter_var($user_id, FILTER_VALIDATE_INT)){
			$time = time();
			// $date_to = date('Y-m-d', $time);
			if(isset($date) && !empty($date)){
				$date_from = $date['from'];
				if(isset($date['to']) && !empty($date['to'])){
					if($date['to']<=date('Ymd',$time)){
						$date_to = ' AND FROM_UNIXTIME(ctb.date,"%Y%m%d") <= "'.$date['to'].'"';
						$to = $date['to'];
					}else{
						$date_to1 = ' AND FROM_UNIXTIME(c.date,"%Y%m%d") <= "'.date('Ymd',$time).'"';
						$date_to2 = ' AND FROM_UNIXTIME(ctb.date,"%Y%m%d") <= "'.date('Ymd',$time).'"';
						$date_to3 = ' AND FROM_UNIXTIME(date,"%Y%m%d") <= "'.date('Ymd',$time).'"';
						$to = date('Ymd',$time);
					}
				}else{
					$date_to = '';
					$to = date('Ymd', $time);
				}
				
			
			}else{
				$date_from =  date('Ymd', $time-(86400*7));
				$to = date('Ymd', $time);
			}
					$subs = array();
					

			if(isset($filter['sub1']) && !empty($filter['sub1'])){
					$subs[] = 'ul.subid1="'.$filter['sub1'].'"'; 
				}

				if(isset($filter['sub2']) && !empty($filter['sub2'])){
					$subs[] = 'ul.subid2="'.$filter['sub2'].'"'; 
				}
				if(isset($filter['sub3']) && !empty($filter['sub3'])){
					$subs[] = 'ul.subid3="'.$filter['sub3'].'"';
					 
				}

				if($subs){
					$s123 = ' and ('.join(' and ',$subs).') ';
					$join1 = ' join users_links as ul on ul.id = c.link_id'; 
					$join2 = ' join users_links as ul on ul.id = ctb.link_id'; 
					$join3 = ' join users_links as ul on ul.id = o.link_id';
				}else{
					$join1 = '';
					$join2 = '';
					$join3 = '';
					$s123 = '';
				}
					
				if(isset($filter['offer_name']) && !empty($filter['offer_name'])){
					$o1 = ' and c.offer_id='.$filter['offer_name']; 
					$o2 = ' and ctb.offer_id='.$filter['offer_name']; 
					$o3 = ' and o.offer_id='.$filter['offer_name']; 
				}else{
					$o1 = ''; 
					$o2 = ''; 
					$o3 = '';
				}
			// $q = 'SELECT  FROM_UNIXTIME(c.date,"%d.%m.%Y") as date,sum(c.repeat) as clicks, count(c.id) as uniq, count(DISTINCT ctb.id) as tb FROM `clicks` as c left join `clicks_tb` as ctb on c.user_id=ctb.user_id WHERE c.user_id='.$user_id.' and  FROM_UNIXTIME(c.date) >= "'.$date_from.'" GROUP BY date ORDER BY date DESC';
			$q = 'SELECT  FROM_UNIXTIME(c.date,"%d.%m.%Y") as dt,sum(c.repeat) as clicks, count(DISTINCT c.ip) as uniq FROM `clicks` as c '.$join1.' WHERE c.user_id='.$user_id.$s123.$o1.' and  FROM_UNIXTIME(c.date,"%Y%m%d") >= "'.$date_from.'" '.$date_to1.' GROUP BY dt ORDER BY date DESC';

			$log_clicks = IOMysqli::table($q);
			$q = 'SELECT FROM_UNIXTIME(ctb.date,"%d.%m.%Y") as dt, count(DISTINCT ctb.id) as tb FROM `clicks_tb` as ctb '.$join2.' WHERE ctb.user_id='.$user_id.$s123.$o2.' and FROM_UNIXTIME(ctb.date,"%Y%m%d") >= "'.$date_from.'" '.$date_to2.' GROUP BY dt ORDER BY date DESC';

			$log_tb = IOMysqli::table($q);
			
			$q = 'SELECT FROM_UNIXTIME(o.date,"%d.%m.%Y") as dt, count(o.id) as count_lead, o.user_status, sum(o.pay) as pay FROM `orders` as o '.$join3.' WHERE o.user_id='.$user_id.$s123.$o3.' and FROM_UNIXTIME(o.date,"%Y%m%d") >= "'.$date_from.'" '.$date_to3.' GROUP BY o.user_status, dt ORDER BY o.date DESC';

			$all_leads = IOMysqli::table($q);		
			
			$data=array();
			foreach($log_clicks as $v){
				$data[$v['dt']] = array(
					'clicks' => $v['clicks'],
					'uniq' => $v['uniq']
					// 'tb' => $v['tb']
				);
			}
			foreach($log_tb as $v){
				$data[$v['dt']]['tb'] = $v['tb'];				
			}
			foreach($all_leads as $v){				
				switch((int)$v['user_status']){
					case 1:					
						$data[$v['dt']]['leads']['hold_count'] += $v['count_lead'];
						$data[$v['dt']]['leads']['hold_sum'] += $v['pay'];
						$data[$v['dt']]['leads']['all_count'] += $v['count_lead'];
					break;
					case 0:					
						$data[$v['dt']]['leads']['deny_count'] += $v['count_lead'];
						$data[$v['dt']]['leads']['deny_sum'] += $v['pay'];
						$data[$v['dt']]['leads']['all_count'] += $v['count_lead'];
					break;
					case 2:
						$data[$v['dt']]['leads']['apr_count'] += $v['count_lead'];
						$data[$v['dt']]['leads']['apr_sum'] += $v['pay'];
						$data[$v['dt']]['leads']['all_count'] += $v['count_lead'];
					break;
				}				
			}
			$stat = array();
			// var_dump(strtotime($to));
			// var_dump(strtotime($date_from));
			// exit;
			// for($i=$time; $i>=$time-(86400*7); $i-=86400){
			for($i=strtotime($to); $i>=strtotime($date_from); $i-=86400){
				$d = date('d.m.Y', $i);

				if($data[$d]){
					
					$stat[$d]['clicks'] = $data[$d]['clicks'];
					$stat[$d]['uniq'] = $data[$d]['uniq'];
					if(isset($data[$d]['tb']) && !empty($data[$d]['tb'])){
						$stat[$d]['tb'] = $data[$d]['tb'];
					}else{
						$stat[$d]['tb'] = 0;
					}
					if(isset($data[$d]['leads']) && !empty($data[$d]['leads'])){
						$stat[$d]['all_count'] =$data[$v['dt']]['leads']['all_count'];
						if(isset($data[$d]['leads']['hold_count']) && !empty($data[$d]['leads']['hold_count'])){
							$stat[$d]['hold_count'] = $data[$d]['leads']['hold_count'];
							$stat[$d]['hold_sum'] = $data[$d]['leads']['hold_sum'];
						}else{
							$stat[$d]['hold_count'] = 0;
							$stat[$d]['hold_sum'] = 0;
						}
						if(isset($data[$d]['leads']['deny_count']) && !empty($data[$d]['leads']['deny_count'])){
							$stat[$d]['deny_count'] = $data[$d]['leads']['deny_count'];
							$stat[$d]['deny_sum'] = $data[$d]['leads']['deny_sum'];
						}else{
							$stat[$d]['deny_count'] = 0;
							$stat[$d]['deny_sum'] = 0;
						} 
						if(isset($data[$d]['leads']['apr_count']) && !empty($data[$d]['leads']['apr_count'])){
							$stat[$d]['apr_count'] = $data[$d]['leads']['apr_count'];
							$stat[$d]['apr_sum'] = $data[$d]['leads']['apr_sum'];
						}else{
							$stat[$d]['apr_count'] = 0;
							$stat[$d]['apr_sum'] = 0;
						}
					}else{
						$stat[$d]['hold_count'] = 0;
						$stat[$d]['hold_sum'] = 0; 
						$stat[$d]['deny_count'] = 0;
						$stat[$d]['deny_sum'] = 0;
						$stat[$d]['apr_count'] = 0;
						$stat[$d]['apr_sum'] = 0;
						$stat[$d]['all_count'] = 0;
					}
				}else{
					$stat[$d]['clicks'] = 0;
					$stat[$d]['uniq'] = 0;
					$stat[$d]['tb'] = 0;
					$stat[$d]['hold_count'] = 0;
					$stat[$d]['hold_sum'] = 0; 
					$stat[$d]['deny_count'] = 0;
					$stat[$d]['deny_sum'] = 0;
					$stat[$d]['apr_count'] = 0;
					$stat[$d]['apr_sum'] = 0;
					$stat[$d]['all_count'] = 0;
				}
			}		
			// var_dump($stat);
			// exit;
			return $stat;
		}else{
			return false;
		}
	}
	public static function userExit(){
		Cookie::deleteCookie("hash");
		header('Location: /');
	}
	public static function setPostback($fields){
		if(isset($fields) && !empty($fields)){
			$q = 'INSERT INTO `users_postbacks`(`'.join('`,`',array_keys($fields)).'`) VALUES ("'.join('","',$fields).'")';
			return IOMysqli::query($q);
		}else{
			return false;
		}
	}
	public static function getStatisticByDay($day, $user_id, $subs){
		if(isset($day) && !empty($day)){
			if($subs){
				$sb = ' and ul.subid1="'.$subs.'" or ul.subid2="'.$subs.'" or ul.subid3="'.$subs.'"';
			}else{
				$sb = '';
			}
			$q = 'SELECT o.date, o.ip,o.user_status, o.pay,oi.name, ul.subid1, ul.subid2, ul.subid3 FROM `orders` as o join `offer_info` as oi on o.offer_id=oi.offer_id join users_links as ul on o.link_id=ul.id WHERE from_unixtime(o.date,"%d.%m.%Y") = "'.$day.'" '.$sb.' and o.user_id='.$user_id;
			$data = IOMysqli::table($q);
			if($data){
				return $data;
			}else{
				return false;
			}
		}else{
			return false;
		}		
	}
	public static function getStatisticClicksByDay($day, $user_id){
		if(isset($day) && !empty($day)){
			$q = 'SELECT from_unixtime(c.date, "%d.%m.%Y") as date,c.identity,count(c.id) as count,ul.subid1,ul.subid2,ul.subid3 FROM `clicks` as c join users_links as ul on c.identity=ul.identity WHERE from_unixtime(c.date, "%d.%m.%Y") = "'.$day.'" and c.`user_id`='.$user_id.' GROUP by c.identity';
			$data['clicks'] = IOMysqli::table($q);
			if($data){
				return $data;
			}else{
				return false;
			}
		}else{
			return false;
		}		
	}
	public static function getPaymentByUserId($user_id){
		if(isset($user_id) && !empty($user_id) && filter_var($user_id, FILTER_VALIDATE_INT)){
			// $q = 'SELECT up.*, uw.wallet_type, uw.wallet_number FROM `users_payments` as up join users_wallet as uw on up.wallet_id=uw.id WHERE up.`user_id`='.$user_id;
			$q = 'SELECT up.* FROM `users_payments` as up WHERE up.`user_id`='.$user_id.' ORDER BY up.date desc';
			return IOMysqli::table($q);
		}else{
			return false;
		}
	}
	public static function setPayment($user_id,$sum,$wallet_id){
		if(isset($user_id) && !empty($user_id) && filter_var($user_id, FILTER_VALIDATE_INT) && isset($sum) && !empty($sum)){
			$q = 'INSERT INTO `users_payments`(`user_id`, `date`, `sum`, `status`, `wallet_id`) VALUES ('.$user_id.',UNIX_TIMESTAMP(),"'.$sum.'",1,'.$wallet_id.')';
			$payment_id = IOMysqli::query($q,1);
			if(isset($payment_id) && !empty($payment_id)){
				$q = 'select id from withdrawal where user_id='.$user_id;
				if(IOMysqli::one($q)){
					$q = 'UPDATE `withdrawal` SET `summa`=`summa`+'.$sum.',`payments_id`=CONCAT(`payments_id`,",'.$payment_id.'") WHERE user_id='.$user_id;
					IOMysqli::query($q);
				}else{
					$q = 'INSERT INTO `withdrawal`(`user_id`, `summa`, `payments_id`) VALUES ('.$user_id.', "'.$sum.'", '.$payment_id.')';
					IOMysqli::query($q);
				}
				$q = 'UPDATE `orders` SET `payout_id`='.$payment_id.' WHERE `payout_id`=0 and `user_status` = 2 and `user_id`='.$user_id;				
				return IOMysqli::query($q);
				
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	public static function giveMoney($user_id, $sum){
		if(isset($user_id) && !empty($user_id) && filter_var($user_id, FILTER_VALIDATE_INT)){
			$q = 'select summa from withdrawal where user_id='.$user_id;
			$s = IOMysqli::one($q);
			if($s == 0){
				return false;
			}else if($sum <=$s){
				 $msg = '<html>
					<head>
					<meta charset="urf-8"/>
					<title>Веб $user_id запросил выплату</title>
					</head>
					<body style="width:100%;height:100%; background-color:#ededed;">
			        <div id="content" style="padding: 20px;">
					<img src="http://cpa-private.biz/img/logo.png" style="display: block; margin:auto; width: 200px;">
					<div class="text" style="width:100%;box-sizing: border-box;padding:10px;color: #4a4a4a;">
						<p>Веб <b>'.$user_id.'</b> запросил выплату на сумму - <b>'.$sum.'</b>.</p>
						</div>
					</body>
					</html>';
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers  .= "Content-type: text/html; charset=utf-8 \r\n";
					$headers .= "From: Cpa-Private<no-reply@cpa-private.biz>\r\n"; 
					if(mail('sl.lok@yandex.ru', "Cpa-Private. Веб $user_id запросил выплату", $msg, $headers)){//'sl.lok@yandex.ru'
						$q = 'UPDATE `withdrawal` SET `summa`=`summa`-'.$sum.',`sum_out`=CONCAT(`sum_out`,",'.$sum.'") WHERE user_id='.$user_id;
						return IOMysqli::query($q);
					}else{						
						return false;
					}
			}else{
				$sum = $s;
				 $msg = '<html>
					<head>
					<meta charset="urf-8"/>
					<title>Веб $user_id запросил выплату</title>
					</head>
					<body style="width:100%;height:100%; background-color:#ededed;">
			        <div id="content" style="padding: 20px;">
					<img src="http://cpa-private.biz/img/logo.png" style="display: block; margin:auto; width: 200px;">
					<div class="text" style="width:100%;box-sizing: border-box;padding:10px;color: #4a4a4a;">
						<p>Веб <b>'.$user_id.'</b> запросил выплату на сумму - <b>'.$sum.'</b>.</p>
						</div>
					</body>
					</html>';
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers  .= "Content-type: text/html; charset=utf-8 \r\n";
					$headers .= "From: Cpa-Private<no-reply@cpa-private.biz>\r\n"; 
					if(mail('sl.lok@yandex.ru', "Cpa-Private. Веб $user_id запросил выплату", $msg, $headers)){//'sl.lok@yandex.ru'
						$q = 'UPDATE `withdrawal` SET `summa`=`summa`-'.$sum.',`sum_out`=CONCAT(`sum_out`,",'.$sum.'") WHERE user_id='.$user_id;
						return IOMysqli::query($q);
					}else{						
						return false;
					}
			}
		}else{
			return false;
		}
	}
	public static function getUserWallets($user_id){
		if(isset($user_id) && !empty($user_id) && filter_var($user_id, FILTER_VALIDATE_INT)){
			$q = 'SELECT * FROM `users_wallet` WHERE `user_id`='.$user_id;
			$data = IOMysqli::table($q);
			$wallet = array();
			foreach($data as  $v){
				switch($v['wallet_type']){
					case 1:
						$wallet[$v['id']] = 'QIWI - '.$v['wallet_number'];
					break;
					case 2:
						$wallet[$v['id']] = 'R'.$v['wallet_number'];
					break;
					case 3:
						$wallet[$v['id']] = 'Z'.$v['wallet_number'];
					break;
					case 4:
						$wallet[$v['id']] = 'Яндекс - '.$v['wallet_number'];
					break;
				}
			}
			return $wallet;
		}else{
			return false;
		}
	}
	public static function getBalansByUserId($user_id){
		if(isset($user_id) && !empty($user_id) && filter_var($user_id, FILTER_VALIDATE_INT)){
			$q = 'SELECT user_status, sum(pay) as summa FROM `orders` WHERE payout_id=0 and user_status in (1,2) and `user_id`='.$user_id.' GROUP BY user_status';
			$data = IOMysqli::table($q);			
			$balans = array();
			foreach($data as $v){
				$balans[$v['user_status']] = $v['summa'];
			}
			return $balans;
		}else{
			return 0;
		}
	}
	public static function updateBalansByUserId($user_id){
		if(isset($user_id) && !empty($user_id) && filter_var($user_id, FILTER_VALIDATE_INT)){
			// $q = 'SELECT sum(o.pay) as summa, o.pay FROM `orders` as o join users as u on u.id=o.user_id  WHERE o.payout_id=0 and o.user_status = 2 and u.`id`='.$user_id.' or u.`refid`='.$user_id .' GROUP BY o.user_status';
			$q = 'SELECT sum(o.pay) as summa, o.pay FROM `orders` as o join users as u on u.id=o.user_id  WHERE o.payout_id=0 and o.user_status = 2 and u.`id`='.$user_id.' or u.`refid`='.$user_id .' GROUP BY o.user_status';
			// $q = 'SELECT sum(o.pay) as summa FROM `orders` as o WHERE o.payout_id=0 and o.user_status = 2 and o.`user_id`='.$user_id;
			// $balans = IOMysqli::one($q);			
			$q = 'Update `users` set `balans`='.$balans.' WHERE id='.$user_id.' and type=1 limit 1';
			// return IOMysqli::query($q);			
		}else{
			return 0;
		}
	}
	
	public static function getProfilByUserId($user_id){
		if(isset($user_id) && !empty($user_id) && filter_var($user_id, FILTER_VALIDATE_INT)){
			$q = 'SELECT * FROM `users_info` WHERE `user_id`='.$user_id;			
			$info = IOMysqli::row($q);
			$q = 'SELECT * FROM `users_wallet` WHERE `user_id`='.$user_id;
			$w = IOMysqli::table($q);
			foreach($w as $v){
				$info['wallet'][$v['wallet_type']] = $v['wallet_number'];
			}
			return $info;

		}else{
			return 0;
		}
	}
	public static function getOfferPreland($user_id,$offer_id){
		if(isset($user_id) && !empty($user_id) && filter_var($user_id, FILTER_VALIDATE_INT) && isset($offer_id) && !empty($offer_id) && filter_var($offer_id, FILTER_VALIDATE_INT)){
			$q = 'SELECT ul.`identity`, ul.`name` FROM `users_links` as ul join `offer_links` as ol on ol.id=ul.land_id  WHERE `wm_id`='.$user_id.' and ol.offer_id='.$offer_id.' and `preland_id`!=0';
			return IOMysqli::table($q);
		}else{
			return false;
		}
	}
	public static function operationBalans($fields){
		switch($fields['operation']){
			case 1:
				$balans = '+'.$fields['sum'];
				$sum = $fields['sum'];
			break;
			case 2:
				$balans = '-'.$fields['sum'];
				$sum = '-'.$fields['sum'];
			break;			
		}
		$q = 'UPDATE `users` SET `balans`=`balans`'.$balans.' WHERE `id`='.$fields['pid'];
		$res =IOMysqli::query($q);
		if($res){
			$q = 'INSERT INTO `user_balans_operation`(`user_id`, `action`, `sum`, `date`) VALUES ('.$fields['pid'].','.$fields['operation'].','.$sum.',UNIX_TIMESTAMP())';
			return IOMysqli::query($q);
		}else{
			return false;
		}
	}
	public static function getOperationBalans($user_id){
		if(isset($user_id) && !empty($user_id) && filter_var($user_id, FILTER_VALIDATE_INT)){
			$q = 'SELECT action,sum,from_unixtime(date) as date FROM `user_balans_operation` WHERE `user_id`='.$user_id.' ORDER BY date DESC';
			return IOMysqli::table($q);
		}else{
			return false;
		}
	}
	public static function updatePartnerBalans(){
		$q = 'SELECT id FROM users WHERE type=2 and ban=0';
		$partners = IOMysqli::table($q);
		foreach($partners as $v){
			$q = 'SELECT sum(`sum`) as balans_sum FROM `user_balans_operation` WHERE `user_id`='.$v['id'];
			$partner_balans = IOMysqli::one($q);
			if(!$partner_balans){
				$partner_balans=0;
			}
			
			$q = 'SELECT sum(o.pay) as order_balans FROM orders as o join offers as of on of.id=o.offer_id WHERE of.`partner_id`='.$v['id'].' and o.user_status=2';
			$order_balans = IOMysqli::one($q);
			
			if($order_balans){
				$balans = $partner_balans-$order_balans;
				$q = 'UPDATE `users` SET `balans`='.$balans.' WHERE `id`='.$v['id'];
				IOMysqli::query($q);
			}
		}
	}
	public static function updlinkland($ind,$l_id){
		if(isset($ind) && !empty($ind) && isset($l_id) && !empty($l_id)){
			$q = 'UPDATE `users_links` SET `land_id`='.$l_id.'  WHERE `identity`="'.$ind.'" LIMIT 1';
			return IOMysqli::query($q);
		}else{
			return false;
		}
	}
	public static function getUserLinks($user_id, $lid){
		if(isset($user_id) && !empty($user_id) && filter_var($user_id, FILTER_VALIDATE_INT)){
			$q = 'SELECT `land_id`,`preland_id`,`subid1`,`subid2`,`subid3`,`identity` FROM `users_links` WHERE `wm_id`='.$user_id.' and `land_id` in ('.join(',',$lid).')';
			return IOMysqli::table($q);
		}else{
			return false;
		}
	}
	public static function setInfo($user_id, $fields){
		if(isset($user_id) && !empty($user_id) && filter_var($user_id, FILTER_VALIDATE_INT) && is_array($fields)){
			$q = 'Select id from `users_info` where user_id='.$user_id;
			if(IOMysqli::one($q)){
				$q = 'UPDATE `users_info` SET `user_id`='.$user_id.',`name`="'.$fields['name'].'",`lastname`="'.$fields['lastname'].'",`about`="'.$fields['about'].'",`skype`="'.$fields['skype'].'" WHERE user_id='.$user_id;
				return IOMysqli::query($q);
			}else{
				$q = 'INSERT INTO `users_info`(`user_id`,`'.join('`,`', array_keys($fields)).'`) VALUES ('.$user_id.',"'.join('","', $fields).'")';
				return IOMysqli::query($q);
			}
			
			
		}else{
			return false;
		}
	}
}
