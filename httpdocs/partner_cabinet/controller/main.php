<?php  
class C_Main extends Controller {

    protected $template = "partner";
	
    public function main($filter_data = false) {		
		$not_orders = '<table>
				<tr>
					<th>дата</th>
					<th class="t offer_id">id оффера</th>
					<th class="t wm_id">id вебмастера</th>
					<th class="t pay">ставка</th>
					<th class="t wm_status">статус вебмастера</th>
					<th class="t date_status">дата статуса</th>
					<th class="t payout_id">выплата</th>
					<th>id заказа</th>
					<th>ФИО</th>
					<th>телефон</th>
					<th>параметры</th>				
					<th>сумма заказа</th>				
					<th>статус</th>
					<th>комментарий</th>				
					<th>ресурс</th>				
					<th>статус почты</th>				
				</tr>
				<tr class="notclick">
				<td colspan="16">у вас еще пока нет заказов</td>
				</tr>
				</table>';
				
		$this->addVar("title", 'Заказы');
		$cookie = Cookie::get("hash");
		if(isset($cookie) && !empty($cookie)){
			$info = User::getInfoByHash($cookie);
			if(filter_var($info['type'], FILTER_VALIDATE_INT)){
				$type_user = $info['type'];
			}else{
				header('Location: /');
			}	
			
			if($type_user == 1){
				header('Location: /');
			}else if($type_user == 2){
				$offers = Partner::offersPartnerByHash($cookie);
				$partner_id = $info['id'];
				$this->addVar("display", 'inline');
			}else if($type_user == 3){
				$partner_id = Partner::getPartnerIDByManagerId($info['id']);
				$offers = Partner::offersPartnerByID($partner_id);
				$this->addVar("display", 'none');
				$this->addVar("manager", 'Ваш ID - '.$info['id']);
			}	
		
		}else{
			header('Location: /');
		}
                
		if($info['id'] == 10 || $info['id'] == 11){
			$this->addVar("special", '<a href="/main_cabinet"><span>главный кабинет</span></a>');
                        $this->addVar("spec_filter", 'inline');
		}else{
			$this->addVar("special", '');
                        $this->addVar("spec_filter", 'none');
		}
//                if(($info['id'] == 10 || $info['id'] == 11) || $type_user == 3){
//                        $this->addVar("spec_filter", 'inline');
//		}else{
//                        $this->addVar("spec_filter", 'none');
//		}
		$this->addVar("partner_id", $partner_id);
		
		$senders = Senders::getSendersByParentId($partner_id);
		
		if($senders){
			foreach($senders as $v){
				$senders_blocks .= '
					<div>											
						<ul>
							<li class="show_div"><span>'.$v['name_short'].'</span>
								<div class="right_block">
									<div class="postmail" data-blank="f7" data-from="'.$v['id'].'">ф.7</div>
									<div class="postmail" data-blank="f112" data-from="'.$v['id'].'">112 ЭП</div>
									<div class="postmail" data-blank="2f" data-from="'.$v['id'].'">оба</div>												
								</div>
							</li>
						</ul>
					</div>							
				';
			}
		}else{
			$senders_blocks = '
			<div>											
				<ul>
					<li class="show_div"><span>Отправителей нет</span>
					</li>
				</ul>
			</div>
			';
		}
		$this->addVar("senders_blocks", $senders_blocks);
		$messages = Sms::getSmsTextByUserId($partner_id);
		
		foreach($messages as $v){
			$this->addVar("message_".$v['type'], $v['message']);
		}
		$option_offer = '<option selected disabled>ID оффера</option><option value="all">все офферы</option>';
		$option_wm_id = '<option selected disabled>Вебмастер</option><option value="all">все вебмастера</option>';
		$option_order_status = '<option selected disabled>Статус заказа</option><option value="all">все статусы</option>';
			
		if($offers == NULL){
			$this->addVar("orders", $not_orders);
		}else{		
			if(isset($_GET['size']) && !empty($_GET['size']) && filter_var($_GET['size'], FILTER_VALIDATE_INT)){
				$size = $_GET['size'];
			}else{
				$size = 30;
			}
			
			$pages = Order::countOrdersByOffers($offers, $size);
			$page = '';
			foreach($pages as $v){
//				$page .= '<a href="/partner_cabinet?page='.$v.'&size='.$size.'">'.$v.'</a>';
                                        if($v == 1){
                                            $cl = 'class="sel"';
                                        }else{
                                            $cl = '';
                                        } 
                                $page .= '<a '.$cl.' data-page="'.$v.'" data-size="'.$size.'">'.$v.'</a>';
			}
			$this->addVar("pages", $page);
			
			$offers_arr=explode(',',$offers);
			foreach($offers_arr as $of_id){
				$option_offer .= '<option value="'.$of_id.'">'.$of_id.'</option>';
				$for_form .= '<option value="'.$of_id.'">'.$of_id.'</option>';

			}
			$this->addVar("option_offer", $option_offer);
			$this->addVar("for_form", '<option selected disabled>ID оффера</option>'.$for_form);
			$arr_wm = Partner::getWMFromOffer($offers);
			
			foreach($arr_wm as $wm){
				$option_wm_id .= '<option value="'.$wm.'">'.$wm.'</option>';
			}
			$this->addVar("option_wm_id", $option_wm_id);
			
			$goods_ar = Goods::getGoodsByOffer($offers);	
		
			$goods_option = '';
			if(isset($goods_ar) && !empty($goods_ar)){
				foreach($goods_ar as $g){
					$goods_option .= '<option value="'.$g['id'].'">'.$g['name'].'</option>';
				}
			}else{
				$goods_option = '<option>У вас нет еще товаров</option>';
			}			
			if(isset($_GET['page']) && !empty($_GET['page']) && filter_var($_GET['page'], FILTER_VALIDATE_INT)){
				$table = Partner::getInfoOrdersByOffer($offers, $_GET['page'], $info['id'],$info['type'],$size);
			}else if(isset($_GET['status']) && !empty($_GET['status'])){
				$table = Partner::getInfoOrdersByOffer($offers,'', $info['id'],$info['type'],$size,$_GET['status']);
				$this->addVar("disp", 'display:none;');
			}else{
				$table = Partner::getInfoOrdersByOffer($offers,'', $info['id'],$info['type'],$size);
			}
                        
			if($filter_data){
                            $this->addVar("orders", $filter_data);
                        }else if($table != false){
				$this->addVar("orders", $table);
			}else{
				$this->addVar("orders", $not_orders);
			}
			$order_status = Partner::$status_array;
			foreach($order_status as $k=>$v){
				$option_order_status .= '<option value="'.$k.'">'.$v['name'].'</option>';
			}
			$this->addVar("option_order_status", $option_order_status);
			$this->addVar("goods_option", $goods_option);
			
			
			$c  = Order::getInfoStatusOrder($offers);
			$status = Partner::$status_array;
			$b = array();
			foreach($status as $k => $v){
				if(isset($c[$k]) && !empty($c[$k])){
					
					$b[$v['group']][] = '<span data-status="'.$k.'">'.$v['name'].'<span>('.$c[$k].')</span></span>';
					//$b[] = '<span data-status="'.$k.'">'.$v['name'].'<span>('.$c[$k].')</span></span>';
				}else{
					$b[$v['group']][] = '<span data-status="'.$k.'">'.$v['name'].'</span>';
					//$b[] = '<span class="gruop_status_'.$v['group'].'" data-status="'.$k.'">'.$v['name'].'</span>';
				}			
			}
			$this->addVar("b", '<a class="all_orders">Все статусы</a><hr><label class="b_gruop_status_1">Группа новый:</label><hr>'.join('',$b[1]).'<label class="b_gruop_status_2">Группа согласование:</label><hr>'.
			join('',$b[2]).'<label class="b_gruop_status_3">Группа комплектация:</label><hr>'.join('',$b[3]).'<label class="b_gruop_status_4">Группа доставка:</label><hr>'.
			join('',$b[4]).'<label class="b_gruop_status_5">Группа Выполнен:</label><hr>'.join('',$b[5]).'<label class="b_gruop_status_6">Группа отменен:</label><hr>'.join('',$b[6]).'<label class="b_gruop_status_7">Группа возврат:</label><hr>'.join('',$b[7]));
			
			
		}
		
		
      
	   parent::main();

    }
	public function getGoodsByOfferId(){
		$errors = array();
		do{
			if(isset($_POST['offer_id']) && !empty($_POST['offer_id'])){
				if(filter_var($_POST['offer_id'], FILTER_VALIDATE_INT)){
					$goods_arr=Goods::getGoodsByOffer($_POST['offer_id']);
					if($goods_arr!=false){
						$ord_option = '';
						foreach($goods_arr as $order){
							$ord_option .= '<option value="'.$order['id'].'">'.$order['name'].'</option>';
						}
						$this->output(array("response"=>'success',"text"=>$ord_option));
					}else{
						$errors[] = 'Ошибка при получении товаров';
					}					
					
				}else{
					$errors[] = 'Такого оффера не существует';
				}
			}else{
					$errors[] = 'Не передан ID оффера';
				}
			if ($errors) {
                break;
            }
		}while(false);
		if ($errors) {
            $this->output(array("response"=>'error',"text"=>"Ошибка :" . join(" , ", $errors)));
        }
        
	}
	public function filter(){
		if(isset($_REQUEST['col_order_by']) && !empty($_REQUEST['col_order_by']) && isset($_REQUEST['type_order_by']) && !empty($_REQUEST['type_order_by'])){
			$order_by['sort']['col'] = $_REQUEST['col_order_by'];
			$order_by['sort']['type'] = $_REQUEST['type_order_by'];
			unset($_REQUEST['type_order_by']);
			unset($_REQUEST['col_order_by']);
		}else{
			$order_by = '';
		}
//                var_dump($fields);
//                exit;
//                if(isset($fields['status']) && !empty($fields['status']) && $fields['status'] == "undefined"){
//                    unset($fields['status']);
//                }
		$fields = $_REQUEST;
		$cookie = Cookie::get("hash");
                
		$table = Order::filterOrders($fields, $cookie, $order_by);
//                $filer_page = '';
//                for($i=1;$i<=$table[1];$i++){
//                    $filer_page .= '<a class="filterpage" data-page="'.$i.'">'.$i.'</a>'; 
//                }
//                $this->main($table[0]);

        
                $this->output(array("success"=>1,"text"=>$table[0],"pages"=>$table[1]));
	}
	public function addOrder(){
		$errors = array();
		do{
			if(isset($_POST['offer_id']) && !empty($_POST['offer_id'])){
				if(filter_var($_POST['offer_id'], FILTER_VALIDATE_INT)){
					$offer_id = trim($_POST['offer_id']);
				}else{
					$errors[] = 'Неверный ID оффера';
				}
			}else{
				$errors[] = 'Вы не выбрали ID оффера';
			}
			
			if(isset($_POST['goods_id']) && !empty($_POST['goods_id'])){
				if(filter_var($_POST['goods_id'], FILTER_VALIDATE_INT)){
					$goods_id = trim($_POST['goods_id']);
				}else{
					$errors[] = 'Неверный ID товара';
				}
			}else{
				$errors[] = 'Вы не выбрали товар';
			}
			
			if(isset($_POST['fio']) && !empty($_POST['fio'])){
					$fio = urlencode(trim($_POST['fio']));
			}else{
				$errors[] = 'Вы не указали ФИО';
			}
			
			if(isset($_POST['phone']) && !empty($_POST['phone'])){
					$phone = trim($_POST['phone']);
			}else{
				$errors[] = 'Вы не указали телефон';
			}
			if ($errors) {
                break;
            }
			$cookie = Cookie::get("hash");
			$info = User::getInfoByHash($cookie);
			$user_id = $info['id'];
			$string = 'click_id='.$user_id.'/offer_id='.$offer_id.'/fio='.$fio.'/phone='.$phone.'/goods_id='.$goods_id;			
			$encrypted = Order::encryptionString($string);
			$order_id = Order::addOrder($encrypted);
			if(filter_var($order_id,FILTER_VALIDATE_INT)){
				$this->output(array("response"=>'success',"text"=>$order_id));
			}else{
				$errors[] = $order_id;
				break;
			}
			
		}while(false);
		if ($errors) {
            $this->output(array("response"=>'error',"text"=>"Ошибка :" . join(" , ", $errors)));
        }
	}

	public function getInfoByPhoneNumber(){
		if(isset($_POST['phone_number']) && !empty($_POST['phone_number'])){
			$info = file_get_contents('http://eduscan.net/help/phone_ajax.php?num='.$_POST['phone_number']);
			
			list($phone_number,$status,$operator,$stat) = explode('~', $info);
			if(isset($operator) && !empty($operator) && isset($stat) && !empty($stat)){
				$this->output(array("response"=>'success',"operator"=>$operator,'state'=>$stat));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка при получении данных"));
			}			
		}else{
			$this->output(array("response"=>'error',"text"=>"Отсутсвуйет номер телефона"));
		}
	}
	
	public function getInfoAddress(){
		if(isset($_POST['adr']) && !empty($_POST['adr'])){
				$link='https://dadata.ru/api/v2/clean/address';
				$headers = array( 
							"Content-Type: application/json", 
							"Authorization: Token f6f24b27320e9e74d4cd2289549b52a5c290bebc", 
							"X-Secret: ea35eb62fa862afd599cc11e299e8514596980db"
						);

				$myCurl = curl_init();

				curl_setopt_array($myCurl, array(
				CURLOPT_REFERER=>"http://phone-six.ru/6.good_phone/",
				CURLOPT_URL => $link,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HTTPHEADER => $headers,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => json_encode(array($_POST['adr']))
				));
				$response = curl_exec($myCurl);

				curl_close($myCurl);
				$adr_info = json_decode($response, true);
				list($country,$state,$city,$street,$house,$flat) = explode(',',$adr_info[0]['result']);
				$this->output(array("response"=>'success',
				"country"=>$country,
				"state"=>$state,
				"city"=>$city,
				"street"=>$street,
				"house"=>$house,
				"flat"=>$flat,
				"index"=>$adr_info[0]['postal_code']));
		}
	}
	public function searchNearestPostOffice(){
		if(isset($_POST['index']) && !empty($_POST['index']) && filter_var($_POST['index'], FILTER_VALIDATE_INT)){
			$data= file_get_contents('http://basicdata.ru/api/json/zipcode/'.$_POST['index']);			
			$info_post_office = json_decode($data,JSON_UNESCAPED_UNICODE);
			$map_json = file_get_contents('https://geocode-maps.yandex.ru/1.x/?geocode='.$info_post_office["data"][0]['address'].'&format=json');
			$map_info = json_decode($map_json, true);
			list($pos1, $pos2) = explode(' ',$map_info['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos']);
			
			
			$this->output(array("response"=>'success',
				"name"=>$info_post_office["data"][0]['name'],
				"phone"=>$info_post_office["data"][0]['phone'],
				"address"=>$info_post_office["data"][0]['address'],
				"pos1"=>$pos1,
				"pos2"=>$pos2
				));
		}else{
			$this->output(array("response"=>'error',"text"=>"ошибка"));
		}	
	}
	
	public function history(){
		$errors = array();
		do{
                    if($_POST['history_by'] == 'params'){
                        if($_POST['value'][0] == '8' || $_POST['value'][0] == '7'){
                            $_POST['value']=  substr($_POST['value'],1);
                        }else if($_POST['value'][0] == '+'){
                            $_POST['value'] =  substr($_POST['value'], 2);
                        }
                    }
			if(isset($_POST['history_by']) && !empty($_POST['history_by'])){
				$history_by = trim($_POST['history_by']);
			}else{
				$errors[] = 'Отсутвует поле поиска';
			}
			if(isset($_POST['value']) && !empty($_POST['value'])){
				$value = trim($_POST['value']);				
			}else{
				$errors[] = 'Отсутвует информация для поиска';
			}
			if ($errors) {
                break;
            }
			$history_ar=Order::history($history_by, $value);
			if($history_ar != false){
				$count = count($history_ar);
				$tr = '';
				foreach($history_ar as $h){
					$tr .= '<tr><td>t_'.$h['id'].'</td><td>'.$h[$history_by].'</td><td>'.$h['date'].'</td></tr>';
				}
				$block='<span>Количество повторений: <b>'.$count.'</b></span>'.
				'<div id="history_div"><table>'.$tr.'</table></div>';
				if($_POST['des'] == 'ip'){
					$info = json_decode(Ipgeo::geoByIp($value),true);
					$block .='<p>Страна: <b>'.$info['country']['name_ru'].'</b></p>'.
					'<p>Регион: <b>'.$info['region']['name_ru'].'</b></p>'.
					'<p>Город: <b>'.$info['city']['name_ru'].'</b></p>';
				}
				$this->output(array("response"=>'success',"block"=>$block));
				
			}else{
				$this->output(array("response"=>'error',"text"=>"Такие данные отсутсвуют"));
			}
		}while(false);
		if ($errors) {
            $this->output(array("response"=>'error',"text"=>"Ошибка :" . join(" , ", $errors)));
        }
	}
	public function historyAdr(){
		$errors = array();
		do{
			$fields=array();
			if(isset($_POST['street']) && !empty($_POST['street'])){
				$fields['street'] = trim($_POST['street']);
			}
			if(isset($_POST['house']) && !empty($_POST['house'])){
				$fields['house'] = trim($_POST['house']);
			}
			if(isset($_POST['flat']) && !empty($_POST['flat'])){
				$fields['flat'] = trim($_POST['flat']);
			}
			$history_ar=Order::historyAdr($fields);
			if($history_ar != false){
				
				$this->output(array("response"=>'success',"text"=>"С этого адреса заказывали ".$history_ar." раз(а)"));
				
			}else{
				$this->output(array("response"=>'error',"text"=>"С этого адреса еще ни разу не заказывали"));
			}
		}while(false);
		if ($errors) {
            $this->output(array("response"=>'error',"text"=>"Ошибка :" . join(" , ", $errors)));
        }
	}
	public function trackingInfo(){
		$errors = array();
		do{
			$fields=array();
			if(isset($_POST['track_number']) && !empty($_POST['track_number'])){
				$treck_number = trim($_POST['track_number']);
			}
			Tracking::getTrackingInfo($treck_number);			
			sleep(0.2);
			$trecking_info=Tracking::getTrackingInfo($treck_number);			
			if($trecking_info != false){
				if(isset($trecking_info['error']) && !empty($trecking_info['error'])){
					$this->output(array("response"=>'error',"text"=>"Ошибка :" . $trecking_info['error']['message']));
				}else{
					if(count($trecking_info['result']['checkpoints'])>0){
						$checkpoints = '<ul class="checkpoints">';					
						foreach($trecking_info['result']['checkpoints'] as $check){
							$checkpoints .= '<li><span>время: '.$check['time'].';</span><span>статус:  '.$check['status_name'].';</span><span>сообщение: '.$check['message'].';</span><span>локация: '.$check['location_ru'].';</span><span>индекс: '.$check['zip_code'].';</span></li>';
						}
						$checkpoints .= '</ul>';
					}else{
						$checkpoints .= '<p>Данный контрольных точек обрабатываются. Повторите попытку через 1 минуту.</p>';
					}
					
					$block = '<p>Трекинговый номер: <b>'.$trecking_info['result']['tracking_number'].'</b></p>'.
							'<p>Cлужба доставки: <b>'.$trecking_info['result']['courier_name'].'</b></p>'.
							'<p>Дата последний проверки: <b>'.$trecking_info['result']['last_check'].'</b></p>'.
							'<p>Контрольные точки:</p>'.
							'<div id="history_div">'.$checkpoints.'</div>';
					$this->output(array("response"=>'success',"block"=>$block));
				}				
			}else{
				$this->output(array("response"=>'error',"text"=>"информация отсутствует"));
			}
		}while(false);
		if ($errors) {
            $this->output(array("response"=>'error',"text"=>"Ошибка :" . join(" , ", $errors)));
        }
	}
	public function insertUpdateOrder(){
		$cookie = Cookie::get("hash");
			if(isset($cookie) && !empty($cookie)){
				$info = User::getInfoByHash($cookie);
				if(filter_var($info['type'], FILTER_VALIDATE_INT)){
					$type_user = $info['type'];
				}else{
					header('Location: /');
				}					
				if($type_user == 1){
					header('Location: /');
				}else if($type_user == 2){
					$partner['type'] = 'partner';
					$partner['id'] = $info['id'];
				}else if($type_user == 3){					
					$partner['type'] = 'manager';
					$partner['id'] = $info['id'];
				}				
			}
			
		if(isset($_POST['goods']) && !empty($_POST['goods']) && $_POST['goods'] != 'null'){
			$goods_ar = explode(',',$_POST['goods']);
			unset($_POST['goods']);
			$goods = array();
			foreach($goods_ar as $v){
				list($id,$count) = explode(':',$v);
				$goods[$id] = $count;
			}
		}else{
			$goods = null;
		}		
		$fields=array();
		if(isset($_POST['e_phone']) && !empty($_POST['e_phone'])){
			$e_phone = $_POST['e_phone'];
			unset($_POST['e_phone']);
			
			$fields['e_phone'][]=$e_phone;
			
		}		
		unset($_POST['is_ajax']);
				
		foreach($_POST as $k => $v){
			if(isset($v) && !empty($v)){
				if($k=='middle_name' || $k=='first_name' || $k=='last_name' || $k=='phone' || $k=='ip' || $k=='status' || $k=='offer_id' || $k=='comment'){
					$fields['orders'][$k]=$v;
				}else{
					$fields['info_orders'][$k]=$v;
				}
			}				
		}		
		$cookie = Cookie::get("hash");
		$info = User::getInfoByHash($cookie);
		$responce = Order::insertUpdateOrder($info['id'],$fields,$goods,$partner);
		$responce = json_decode($responce, true);
		if($responce['responce'] == 'success'){
			$this->output(array("response"=>'success',"text"=>"Данные успешно обновлены/добавлены","o_id"=>$info['id']));
		}else{
			$this->output(array("response"=>'error',"text"=>"error"));
		}
		
		
	}
	// public function updateOrderSum(){
		// if($_POST['order_id'] && filter_var($_POST['order_id'], FILTER_VALIDATE_INT)){
			// if(Orders::updateOrderSum($_POST['order_id']) == true){
				// $this->output(array("response"=>'success',"text"=>"Сумма заказа обновлена успешно"));
			// }else{
				// $this->output(array("response"=>'error',"text"=>"Ошибка при обновление суммы заказа"));
			// }
		// }else{
			// $this->output(array("response"=>'error',"text"=>"Ошибка"));
		// }
	// }
	public function quickEdit(){
		if($_POST){
			if(isset($_POST['status']) && !empty($_POST['status']) && $_POST['status'] == 'confirmed'){
				$cookie = Cookie::get("hash");
				$info = User::getInfoByHash($cookie);
				$o_id = $_POST['order_id'];
				if(!IOMysqli::one('SELECT `id` FROM `manager_orders` WHERE `order_id`='.$o_id)){
					$q = 'INSERT INTO `manager_orders`(`manager_id`, `order_id`) VALUES ('.$info['id'].','.$o_id.')';
					IOMysqli::query($q);
				}
			}
			if($_POST['m_o'] == 1){
				$order_id = json_decode($_POST['order_id'], true);				
				unset($_POST['order_id']);		
				unset($_POST['m_o']);		
			}else{
				$order_id = $_POST['order_id'];	
				unset($_POST['order_id']);			
			}			
			unset($_POST['is_ajax']);
			if(isset($_POST['table']) && !empty($_POST['table'])){
				$table = $_POST['table'];
				unset($_POST['table']);
			}else{
				$table = 'orders';
			}
			if(isset($_POST['upd_order_sum']) && !empty($_POST['upd_order_sum'])){
				$upd_order_sum = $_POST['upd_order_sum'];
				unset($_POST['upd_order_sum']);
			}
			$update_string = array();
			$bls_upd = 0;
			foreach($_POST as $k=>$v){
				
				if($k == 'status'){
					$user_status = Partner::$status_array[$v]['user_status'];
					$update_string[] = '`'.$k.'`="'.$v.'"';
					$update_string[] = '`user_status`="'.$user_status.'"';
					$dt=1;
					if($user_status == 2){
						$bls_upd = 1;
					}
				}else{					
					$update_string[] = '`'.$k.'`="'.$v.'"';
					$dt=0;
				}
				
			}
			
			$resp = Order::quickEdit(join(', ',$update_string), $order_id, $table,$dt);
			if($bls_upd == 1){
				User::updateBalansByUserId($order_id);
			}
			if(isset($upd_order_sum) && !empty($upd_order_sum)){
				$order_sum = Order::updateOrderSum($order_id, 1);
				if($order_sum != false){
					$this->output(array("response"=>'success',"order_sum"=>$order_sum));
				}else{
					$this->output(array("response"=>'error',"text"=>"ошибка при обновлении данных"));
				}
			}else{
				if($resp == true){
					$this->output(array("response"=>'success',"text"=>"Заказ обновлен успешно"));
				}else{
					$this->output(array("response"=>'error',"text"=>"ошибка при обновлении данных"));
				}
			}
		}else{
			$this->output(array("response"=>'error',"text"=>"Отсутсвуют данные для изменения"));
		}
	}
	public function statusBlock(){
		$order_status = Partner::$status_array;
		$status_block = '';
		foreach($order_status as $k=>$v){
			$status_block .= '<div class="gruop_status_'.$v['group'].'" data-value="'.$k.'">'.$v['name'].'</div>';
		}
		$this->output(array("response"=>'success',"text"=>'<div id="status_block"><div class="close"></div>'.$status_block.'</div>'));
	}
	
	public function addOffer(){
		$errors = array();
		$fields = array();
		do{
			if(isset($_POST['postclick']) && !empty($_POST['postclick'])){				
				if(filter_var($_POST['postclick'],FILTER_VALIDATE_INT)){
					$fields['postclick'] = $_POST['postclick'];
				}else{
					$errors[] = 'Посклик должен иметь числовое значение';
				}
			}else{
				$errors[] = 'Укажите постклик';
			}
			if(isset($_POST['hold']) && !empty($_POST['hold'])){				
				if(filter_var($_POST['hold'],FILTER_VALIDATE_INT)){
					$fields['hold'] = $_POST['hold'];
				}else{
					$errors[] = 'Холд должен иметь числовое значение';
				}
			}else{
				$errors[] = 'Укажите холд';
			}
			if(isset($_POST['partner_id']) && !empty($_POST['partner_id'])){				
				if(filter_var($_POST['partner_id'],FILTER_VALIDATE_INT)){
					$fields['partner_id'] = $_POST['partner_id'];
				}else{
					$errors[] = 'Неверный формат ID партнера';
				}
			}else{
				$errors[] = 'Укажите ID партнера';
			}
			if(isset($_POST['location_name']) && !empty($_POST['location_name'])){				
				$fields['location_name'] = $_POST['location_name'];
			}else{
				$errors[] = 'Укажите таргетинг';
			}
			if(isset($_POST['traffs']) && !empty($_POST['traffs'])){
				$traffs = array();
				foreach($_POST['traffs'] as $k=>$v){
					if(isset($_POST['traffs'][$k]) && !empty($_POST['traffs'][$k])){
						$traffs[]=$k;
					}
				}
				$fields['traffs'] = json_encode($traffs);
			}else{
				$errors[] = 'Укажите хотя бы один вид траффика';
			}
			if ($errors) {
                break;
            }
			$resp = Partner::addOffer($fields);

			if(filter_var($resp, FILTER_VALIDATE_INT)){
				$this->output(array("response"=>'success',"text"=>"Оффер создан успешно. ID нового оффера ".$resp,"offer_id"=>$resp));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка при создании оффера"));
			}
		}while(false);
		if ($errors) {			
            $this->output(array("response"=>'error',"text"=>"Ошибка :" . join(" , ", $errors)));
        }
		
	}
	public function incDecAmountGoods(){
		$cookie = Cookie::get("hash");
		if(isset($cookie) && !empty($cookie)){
			$info = User::getInfoByHash($cookie);
			if(filter_var($info['type'], FILTER_VALIDATE_INT)){
				$type_user = $info['type'];
			}else{
				header('Location: /');
			}	
			
			if($type_user == 1){
				header('Location: /');
			}else if($type_user == 2){
				$partner_id = $info['id'];
			}else if($type_user == 3){
				$partner_id = Partner::getPartnerIDByManagerId($info['id']);				
			}				
		}else{
			header('Location: /');
		}
		$true=0;
		$errors = array();
		do{
			if(isset($_POST['goods_id']) && !empty($_POST['goods_id'])){
				if(filter_var($_POST['goods_id'], FILTER_VALIDATE_INT)){
					
				
						$count = $_POST['count'];
						
					
						$goods_count = Goods::getCountGoods($_POST['goods_id']);
						$q = 'Select id, count from `order_goods` where order_id='.$_POST['order_id'].' and goods_id='.$_POST['goods_id'];
						$prov = IOMysqli::row($q);
						
						// if($count>$prov['count']){
							// $c = $count-$prov['count']; 
						// }else if($count<$prov['count']){
							// $c = $prov['count']-$count;
						// }
						if(($prov['count'] > $count) || (isset($goods_count) && !empty($goods_count))){
							// if($count>0){
								if($c<$goods_count){
									$true=1;
								}else{
									$this->output(array("response"=>'error',"text"=>"Нужное количество товара отсутсвует на складе"));
								}
							// }else{
								// $true=1;
							// }
							if($true==1){
								Goods::addGoodsToOrder($_POST['order_id'], $_POST['goods_id'], $count);
								$goods_id_all = Goods::getIdGoodsByOrders($_POST['order_id'], $_POST['goods_id'], $count);								
								$goods = array();
								foreach($goods_id_all as $v){
									$goods[] = $v['goods_id'];
								}
								$goods_info = Goods::getGoodsInfoByIds($goods,$_POST['order_id']);									
								$tr = '';
								
								foreach($goods_info as $v){
									$tr .= '<tr id="goods_id_'.$v['id'].'"><td>'.$v['name'].'</td>'.
										'<td><input type="text" class="not_style" name="Goods[id]" value="'.$v['id'].'" disabled></td>'.
										'<td>'.$v['price'].'</td>'.
										//'<td>'.$v['goods_count'].'</td>'.
										'<td><input type="number" name="Goods[count]" value="'.$v['goods_count'].'"></td>'.
										'<td>'.$v['price']*$v['goods_count'].'</td>';
										$all_price += $v['price']*$v['goods_count'];
								}
								
								$table = Goods::getGoodsInfoByUserId($partner_id, 1);
								if(isset($table) && !empty($table) && is_array($table)){
									$tr2 = '';
									foreach($table as $v){				
										if($v['img'] == 'no_img.png' ){
											$img = '../img/goods/'.$v['img'];
										}else{
											$img = '../img/goods/'.$info['id'].'/'.$v['img'];
										}
										if($v['count'] <= 0){
											$tr2 .= '<tr class="item_missing" data-goods_id="0">'.
											'<td><img src="'.$img.'" alt="'.$v['name'].'"></td>'.
											'<td>'.$v['name'].'</td>'.
											'<td>'.$v['id'].'</td>'.
											'<td>'.$v['price'].'</td>'.
											'<td>'.$v['purchase_price'].'</td>'.					
											'<td>'.$v['count'].'</td>'.
											'</tr>';
										}else{
											$tr2 .= '<tr data-goods_id="'.$v['id'].'">'.
												'<td><img src="'.$img.'" alt="'.$v['name'].'"></td>'.
												'<td>'.$v['name'].'</td>'.
												'<td>'.$v['id'].'</td>'.
												'<td>'.$v['price'].'</td>'.
												'<td>'.$v['purchase_price'].'</td>'.						
												'<td>'.$v['count'].'</td>'.
												'</tr>';
										}
									}
									$tgoods = '<table><tr>
											<th>картинка</th>
											<th>название</th>
											<th>артикул</th>
											<th>цена</th>
											<th>закупочная цена</th>
											<th>остаток на складе</th>				
										</tr>'.$tr2.'</table>';
								}
								
										
								$q = 'SELECT `order_sum` FROM `orders` WHERE `id`='.$_POST['order_id'];
								$all_price = IOMysqli::one($q);
								$this->output(array("response"=>'success',"text"=>$tr,"all_price"=>$all_price,'tgoods'=>$tgoods));
							}
						}else{
							$this->output(array("response"=>'error',"text"=>"Нужное количество товаров отсутсвует на складе"));
						}
				}else{
					$errors[]='Неверный ID товара';
				}
			}else{
				$errors[]='Отсутсвует ID товара';
			}
		}while(false);
		if ($errors) {			
            $this->output(array("response"=>'error',"text"=>"Ошибка :" . join(" , ", $errors)));
        }
	}

	
	public function addGoodsInOrder(){
		$errors = array();
		do{
			if(isset($_POST['goods_id']) && !empty($_POST['goods_id'])){
				if(filter_var($_POST['goods_id'], FILTER_VALIDATE_INT)){
					$cookie = Cookie::get("hash");
					$offers = Partner::offersPartnerByHash($cookie);
					if(isset($_POST['count']) && !empty($_POST['count'])){
						$count = $_POST['count'];
					}else{
						$count = 0;
					}
					$true = Goods::addGoodsToOrder($_POST['order_id'],$_POST['goods_id'],$count);
				
					if($true == true){
						
						$goods_info = Goods::getGoodsInfoByIds(array($_POST['goods_id']), $_POST['order_id']);	
						
						$tr = '';
						$all_price = 0;
						foreach($goods_info as $v){
							$tr .= '<tr id="goods_id_'.$v['id'].'"><td>'.$v['name'].'</td>'.
							'<td><input type="text" class="not_style" name="Goods[id]" value="'.$v['id'].'" disabled></td>'.
							'<td>'.$v['price'].'</td>'.
							//'<td>'.$v['goods_count'].'</td>'.
							'<td><input type="number" name="Goods[count]" value="'.$v['goods_count'].'"></td>'.
							'<td>'.$v['price']*$v['goods_count'].'</td>';
							$all_price += $v['price']*$v['goods_count'];
						}
						
						$this->output(array("response"=>'success',"text"=>$tr,'all_price'=>$all_price));
					}else{
						$this->output(array("response"=>'error',"text"=>"Ошибка при добавлении товара"));
					}
				}else{
					$errors[]='Неверный ID товара';
				}
			}else{
				$errors[]='Отсутсвует ID товара';
			}
		}while(false);
		if ($errors) {			
            $this->output(array("response"=>'error',"text"=>"Ошибка :" . join(" , ", $errors)));
        }
	}
	
	public function costDelivery(){
		// include_once(SITE_DIR."model/".$_SERVER['SERVER_NAME']."/calculatepricedeliverycdek.php");
		include_once(SITE_DIR."model/".SITE."/calculatepricedeliverycdek.php");
		try {

			//создаём экземпляр объекта CalculatePriceDeliveryCdek
			$calc = new CalculatePriceDeliveryCdek();
			
			//Авторизация. Для получения логина/пароля (в т.ч. тестового) обратитесь к разработчикам СДЭК -->
			//$calc->setAuth('authLoginString', 'passwordString');
			
			//устанавливаем город-отправитель
			$calc->setSenderCityId($_REQUEST['senderCityId']);
			//устанавливаем город-получатель
			$calc->setReceiverCityId($_REQUEST['receiverCityId']);
			//устанавливаем дату планируемой отправки
			//$calc->setDateExecute($_REQUEST['dateExecute']);
			
			//устанавливаем тариф по-умолчанию
			//$calc->setTariffId('137');
			$calc->setTariffId($_REQUEST['tariffList2']);
			//задаём список тарифов с приоритетами
			// $calc->addTariffPriority($_REQUEST['tariffList1']);
			// $calc->addTariffPriority($_REQUEST['tariffList2']);
			
			
			//устанавливаем режим доставки
			//$calc->setModeDeliveryId($_REQUEST['modeId']);
			//добавляем места в отправление
			$goods_arr = Goods::getIdGoodsByOrders($_REQUEST['OrderId']);
			$g=array();
			foreach($goods_arr as $v){
				$g[] = $v['goods_id'];
			}
			$goods_info = Goods::getGoodsInfoById($g,'',1);
			$gab = '';
			
			foreach($goods_info as $v){
				//$gab .= $v['weight'].','.$v['long'].','.$v['width'].','.$v['height'];
				$calc->addGoodsItemBySize($v['weight'], $v['long'], $v['width'], $v['height']);
			}
			//$calc->addGoodsItemBySize($_REQUEST['weight1'], $_REQUEST['length1'], $_REQUEST['width1'], $_REQUEST['height1']);
			
			//$calc->addGoodsItemBySize($gab);
			//$calc->addGoodsItemByVolume($_REQUEST['weight2'], $_REQUEST['volume2']);
			
			if ($calc->calculate() === true) {
				$res = $calc->getResult();
				$r = '';
				$r .= 'Цена доставки: ' . $res['result']['price'] . 'руб.<br />';
				$r .= 'Срок доставки: ' . $res['result']['deliveryPeriodMin'] . '-' . 
										 $res['result']['deliveryPeriodMax'] . ' дн.<br />';
				$r .= 'Планируемая дата доставки: c ' . $res['result']['deliveryDateMin'] . ' по ' . $res['result']['deliveryDateMax'] . '.<br />';
				$r .= 'id тарифа, по которому произведён расчёт: ' . $res['result']['tariffId'] . '.<br />';
				if(array_key_exists('cashOnDelivery', $res['result'])) {
					$r .= 'Ограничение оплаты наличными, от (руб): ' . $res['result']['cashOnDelivery'] . '.<br />';
				}
				$this->output(array("response"=>'success',"text"=>$r));
			} else {
				$err = $calc->getError();
				if( isset($err['error']) && !empty($err) ) {
					//var_dump($err);
					$er = '';
					foreach($err['error'] as $e) {
						$er = 'Код ошибки: ' . $e['code'].'; Текст ошибки: ' . $e['text'];
					}
					$this->output(array("response"=>'error',"text"=> $er));
				}
			}
			
			//раскомментируйте, чтобы просмотреть исходный ответ сервера
			// var_dump($calc->getResult());
			// var_dump($calc->getError());

		} catch (Exception $e) {
			$this->output(array("response"=>'error',"text"=>"Ошибка :" . $e->getMessage()));
		}
	}
	public function getInfoAdr(){
		if(isset($_POST['city']) && !empty($_POST['city']) && isset($_POST['street']) && !empty($_POST['street']) && isset($_POST['house']) && !empty($_POST['house'])){
			// include_once(SITE_DIR."model/".$_SERVER['SERVER_NAME']."/kladr.php");
			include_once(SITE_DIR."model/".SITE."/kladr.php");

			$api = new Kladr\Api('51dfe5d42fb2b43e3300006e', '86a2c2a06f1b2451a87d05512cc2c3edfdf41969');

			// Формирование запроса
			$query              = new Kladr\Query();
			if(filter_var($_POST['house'], FILTER_VALIDATE_INT)){
				$h = $_POST['house'];
			}else{
				$h = explode(' ',preg_replace('/[^0-9]/', ' ', $_POST['house']))[0];
			}
			$query->ContentName = $_POST['city'].', '.$_POST['street'].', '.$h;

			$query->OneString = TRUE;
			$query->Limit     = 5;

			// Получение данных в виде ассоциативного массива
			$arResult = $api->QueryToArray($query);
			$this->output(array("response"=>'success',"zip"=>$arResult[1]['zip']));

		}
	}
	public function export(){		
		$cookie = Cookie::get("hash");
			if(isset($cookie) && !empty($cookie)){
				$info = User::getInfoByHash($cookie);
				if(filter_var($info['type'], FILTER_VALIDATE_INT)){
					$type_user = $info['type'];
				}else{
					header('Location: /');
				}					
				if($type_user == 1){
					header('Location: /');
				}else if($type_user == 2){
					$partner_id = $info['id'];
					$offers = Partner::offersPartnerByHash($cookie);
				}else if($type_user == 3){
					$partner_id = Partner::getPartnerIDByManagerId($info['id']);					
				}				
			}
			if($_POST['date'] == 'true'){
				$fields['date'] = 1;
			}else{
				$fields['date'] = 0;
			}
			if($_POST['fio'] == 'true'){				
				$fields['fio'] = 1;
			}else{
				$fields['fio'] = 0;
			}
			if($_POST['phone'] == 'true'){
				$fields['phone'] = 1;
			}else{
				$fields['phone'] = 0;
			}
			if($_POST['address'] == 'true'){
				$fields['address'] = 1;
			}else{
				$fields['address'] = 0;
			}
			if($_POST['type_delivery'] == 'true'){
				$fields['type_delivery'] = 1;
			}else{
				$fields['type_delivery'] = 0;
			}
			if($_POST['zip'] == 'true'){
				$fields['zip'] = 1;
			}else{
				$fields['zip'] = 0;
			}
			if($_POST['sum'] == 'true'){
				$fields['sum'] = 1;
			}else{
				$fields['sum'] = 0;
			}
			if($_POST['wm'] == 'true'){
				$fields['wm'] = 1;
			}else{
				$fields['wm'] = 0;
			}
			if($_POST['time_delyvery'] == 'true'){
				$fields['time_delyvery'] = 1;
			}else{
				$fields['time_delyvery'] = 0;
			}
			$period = array();
			if(isset($_POST['date_start']) && !empty($_POST['date_start'])){
				$date_start_parce = explode('.',$_POST['date_start']);
				// $period['start'] = mktime(0, 0, 0, $date_start_parce[0], $date_start_parce[1], $date_start_parce[2]);
				$period['start'] = $date_start_parce[2].'-'.$date_start_parce[1].'-'.$date_start_parce[0];
				
			}
			if(isset($_POST['date_end']) && !empty($_POST['date_end'])){
					$date_end_parce = explode('.',$_POST['date_end']);
					// $period['end'] = mktime(0, 0, 0, $date_end_parce[0], $date_end_parce[1], $date_end_parce[2]);				
					$period['end'] = $date_end_parce[2].'-'.$date_end_parce[1].'-'.$date_end_parce[0];				
			}
			
			if(isset($_POST['order_ids']) && !empty($_POST['order_ids'])){
				$orders = json_decode($_POST['order_ids'], true);
			}else{
				$orders = '';
			}
			$for_export = Order::forExport($fields,$period,$partner_id, $orders);
			$file_info = Export::exportToExcel($for_export, $info['id']);
			if(isset($file_info) && !empty($file_info) && is_array($file_info)){
				$this->output(array("response"=>'success',"name"=>$file_info['name']));
				// header('location: http://cpa-private.biz/partner_cabinet/download?filename='.$file_info['name']);
				// header('Location: http://yandex.ru');
				// header("Content-type: application/vnd.ms-excel"); 
				// header('Content-Disposition: attachment; filename="'.$file_info['name'].'"'); 
				// readfile($file_info['path']);
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка"));
			}
			
	}
	public function deleteOrders(){
		if(isset($_POST['order_ids']) && !empty($_POST['order_ids'])){
			$orders = json_decode($_POST['order_ids'], true);
			$resp = Order::deleteOrders($orders);
			if($resp == true){
				$this->output(array("response"=>'success'));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка"));
			}
		}
	}
	public function getBlanks(){
		include_once(SITE_DIR."model/".SITE."/dompdf/dompdf_config.inc.php");
		$html = file_get_contents('http://cpa-private.biz/blanks/?orders_id=[%22113%22]&from_name=%D0%96%D1%83%D0%BA%D0%BE%D0%B2&blank_type=f7');
		$dompdf = new DOMPDF();// Создаем обьект
		$dompdf->load_html($html); // Загружаем в него наш html код
		$dompdf->render(); // Создаем из HTML PDF
		$dompdf->stream('mypdf.pdf'); 
		// if(isset($_POST['orders_id']) && !empty($_POST['orders_id'])){
			// $orders_id = json_decode($_POST['orders_id'], true);
			// $data = array();
			// $data['from_name'] = $_POST['from_name'];
			// $order_info = Order::getInfoOrders(array(array_shift($orders_id)));
			
			// $data['from_name'] = $_POST['from_name'];
			// $data['from_address_1'] = $order_info[0]['city'].', ул.'.$order_info[0]['street'];
			// $data['from_address_2'] = 'д.'.$order_info[0]['house'].', кв.'.$order_info[0]['flat'];
			// $data['summa'] = $order_info[0]['order_sum'];
			// $data['zip'] = $order_info[0]['index'];
			// $data['who'] = json_decode($order_info[0]['params'],true)[1];
			// $data['who_address_1'] = $order_info[0]['city'].', ул.'.$order_info[0]['street'];
			// $data['who_address_2'] = 'д.'.$order_info[0]['house'].', кв.'.$order_info[0]['flat'];
			// $a = Blank::getBlank('f7',$data);
			// echo $a;
			// exit;
		// }else{
			// return false;
		// }
	}
	public function setSmsText(){
		$errors = array();
		do{
			if(isset($_POST['partner_id']) && !empty($_POST['partner_id']) && filter_var($_POST['partner_id'], FILTER_VALIDATE_INT)){
				$parretn_id = $_POST['partner_id'];
			}else{
				$errors[] = 'error 001';
			}
			
			if(isset($_POST['type']) && !empty($_POST['type']) && filter_var($_POST['type'], FILTER_VALIDATE_INT)){
				$type = $_POST['type'];
			}else{
				$errors[] = 'error 002';
			}
			
			if(isset($_POST['message']) && !empty($_POST['message'])){
				$message = $_POST['message'];
			}else{
				$errors[] = 'отсутсвует текст сообщения';
			}
			
			if($errors){
				break;
			}
			
			$response = Sms::setSmsText($parretn_id, $type, $message);
			
			if($response == true){
				$this->output(array("response"=>'success', 'text'=>'Текст сообщения изменен'));
			}else{
				$this->output(array("response"=>'error',"text"=>'Ошибка при изменении текста сообщения'));
			}
		}while(false);
		
		if($errors){
			$this->output(array("response"=>'error',"text"=>'Ошибка: '.join(', ', $errors)));
		}
	}
	public function sendSms(){
		$errors = array();
		do{
			if(isset($_POST['type']) && !empty($_POST['type']) && filter_var($_POST['type'], FILTER_VALIDATE_INT)){
				$type = $_POST['type'];
			}else{
				$errors[] = 'неопределен типо отправляемого сообщения';
			}
			
			// if(isset($_POST['phones']) && !empty($_POST['phones'])){
				// $phones = json_decode($_POST['phones'], true);				
			// }else{
				// $errors[] = 'отсутсвует номер телефона';
			// }
			
			
			if(isset($_POST['order_ids']) && !empty($_POST['order_ids'])){
				$order_ids = json_decode($_POST['order_ids'], true);
				$info_orders = Order::getInfoOrders($order_ids);
				$for_sms = array();
				foreach($info_orders as $v){
					$for_sms[$v['id']]['track_number'] = $v['track_number'];
					$for_sms[$v['id']]['phone'] = '+'.json_decode($v['params'], true)[2];
				}
			}else{
				$errors[] = 'отсутсвует номер заказа';
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
				if($type_user == 1){
					header('Location: /');
				}else if($type_user == 2){
					$partner_id = $info['id'];
				}else if($type_user == 3){
					$partner_id = Partner::getPartnerIDByManagerId($info['id']);
				}				
			}else{
				header('Location: /');
			}
			
			$messages = Sms::getSmsTextByUserIdAndType($partner_id, $type);
			
			if(!$messages){
				switch($type){
					case 1:
						foreach($for_sms as $k=>$v){
							
							$messages = 'Заказ отправлен. Отследите по №'.$v['track_number'].' на сайте pochta.ru';
							$response = Sms::send_sms($v['phone'], $messages, 0, 0, 0, 0, 'Intermag');
						}
					break;
					case 2:
						foreach($for_sms as $k=>$v){
							$messages = 'Заказ №'.$v['track_number'].' прибыл в отделение почты. Получайте его с паспортом';
							$response = Sms::send_sms($v['phone'], $messages, 0, 0, 0, 0, 'Intermag');
						}
					break;
					case 3:
						foreach($for_sms as $k=>$v){
							$messages = 'Ваша бандероль '.$v['track_number'].' оказалось двухтысячной. Подарок внутри!';
							$response = Sms::send_sms($v['phone'], $messages, 0, 0, 0, 0, 'Intermag');
						}
					break;
					case 4:
						$phones = array();
						foreach($for_sms as $k=>$v){
							$phones[] =  $v['phone'];							
						}
						$messages = 'Вы давали устную гарантию выкупа заказ. Есть запись разговора. Будет суд на возмещение всех издержек.';
						// $messages = 'Проверка';
						
							$response = Sms::send_sms(join(',',$phones), $messages, 0, 0, 0, 0, 'Intermag');
					break;
					case 5:
						$q = 'select email from users where id='.$partner_id;
						
						$email = IOMysqli::one($q);
						$phones = array();
						foreach($for_sms as $k=>$v){
							$phones[] =  $v['phone'];							
						}
						$messages = 'Ваше дело передано в выездную Службу Взысканий. Если вы уже оплатили заказ пришлите пожалуйста №чека на '.$email;
						$response = Sms::send_sms(join(',',$phones), $messages, 0, 0, 0, 0, 'Intermag');
					break;
					case 6:
						$phones = array();
						foreach($for_sms as $k=>$v){
							$phones[] =  $v['phone'];							
						}
						$messages = 'В случае не выкупа Вашего заказа до '.date('d.m.Y', time() + 604800).', Ваше дело передаем в выездную Службу Взысканий для принудительной оплаты.';
							$response = Sms::send_sms(join(',',$phones), $messages, 0, 0, 0, 0, 'Intermag');
					break;
					case 7:
						$phones = array();
						foreach($for_sms as $k=>$v){
							$phones[] =  $v['phone'];							
						}
						$messages = 'Если вы не выкупите заказ №'.$v['track_number'].' мы испортим Вам кредитную историю';
						$response = Sms::send_sms(join(',',$phones), $messages, 0, 0, 0, 0, 'Intermag');
						
					break;
				}				
			}else{
				$phones = array();
						foreach($for_sms as $k=>$v){
							$phones =  $v['phone'];
							$track_number = $v['track_number'];
							$messages = str_replace('{{track_number}}',$track_number,$messages); 
							$response = Sms::send_sms($phones, $messages, 0, 0, 0, 0, 'Intermag');
						}
						
			}
			
			$resp = json_decode($response, true);

			if($resp['response'] == 'error'){
				$this->output(array("response"=>'error',"text"=>$resp['text']));
			}else if($resp['response'] == 'success'){				
				$this->output(array("response"=>'success', 'text'=>$resp['text']));
			}
		}while(false);
		
		if($errors){
			$this->output(array("response"=>'error',"text"=>'Ошибка: '.join(', ', $errors)));
		}
	}
	public function cdek(){
		Cdek::sendOrder(array(1), 10);
	}
	public function delImg(){
		if(isset($_POST['img']) && !empty($_POST['img'])){
			$cookie = Cookie::get("hash");
			if(isset($cookie) && !empty($cookie)){
				$info = User::getInfoByHash($cookie);
				if(filter_var($info['type'], FILTER_VALIDATE_INT)){
					$type_user = $info['type'];
				}else{
					header('Location: /');
				}					
				if($type_user == 1){
					header('Location: /');
				}else if($type_user == 2){
					$partner_id = $info['id'];
				}else if($type_user == 3){
					$partner_id = Partner::getPartnerIDByManagerId($info['id']);
				}	
				$filename = WWW_DIR.'img/goods/'.$partner_id.'/'.$_POST['img'];

				if(unlink($filename)){
					$this->output(array("response"=>'success',"text"=>'изображение удаленно'));
				}else{
					$this->output(array("response"=>'error',"text"=>'Ошибка при удалении изображения'));
				}
			}else{
				header('Location: /');
			}
			
		}else{
			$this->output(array("response"=>'error',"text"=>'Ошибка отсутсвует изображение'));
		}
	}
	public function getStatusBlock(){
		$st_arr = Partner::$status_array;
		$st = '';
		foreach($st_arr as $k=>$v){
			$st .= '<div class="gruop_status_'.$v['group'].'" data-value="'.$k.'">'.$v['name'].'</div>';
		}
		$this->output(array("response"=>'success',"text"=>'<div id="status_block"><div class="close"></div>'.$st.'</div>'));
	}
	
	public function updtrackstatus() {	
		$q = 'Select o.id, o.status, io.track_number , o.params from orders as o join info_orders as io on o.id=io.order_id where io.track_number!=0 and o.status!="delivered" and o.status!="presentation" and o.status!="payed" and o.post_status_update=0';
		
                $orders = IOMysqli::table($q);
		$presentation = array();
			$delivered = array();
			$phones = array();
			if($orders){
				$i=0;
		foreach($orders as $v){
			$status = $v['status'];
			$id = $v['id'];

			$track_number = $v['track_number'];
			$track_info = Tracking::getTrackingInfo($track_number);
			
			
			// $track_info = Tracking::getTrackingInfo('19000094170809');
			// echo '<pre>';
			// var_dump($track_info);
			// echo '</pre>';
			// exit;
			// exit;
			
			
			
			
			if(isset($track_info["result"]["checkpoints"][0]["location"]) && !empty($track_info["result"]["checkpoints"][0]["message"].'"')){
				$update_string = array('post_status="'.$track_info["result"]["checkpoints"][0]["location"].', '.$track_info["result"]["checkpoints"][0]["message"].'"');
				$table = 'info_orders';
				$resp = Order::quickEdit(join(', ',$update_string), $id, $table,$dt);
			}
			
			if($track_info["result"]["checkpoints"][0]['status'] == 'delivered'){
				$table = 'orders';
				$update_string = array('`status`="presentation"','`user_status`="2"');
				$resp = Order::quickEdit(join(', ',$update_string), $id, $table,time(),1);
				echo $id.'<br>';
				$i++;
			}else if($track_info["result"]["checkpoints"][0]['status'] == 'arrived'){
				$table = 'orders';
				$update_string = array('status="delivered"', '`user_status`="2"');
				$resp = Order::quickEdit(join(', ',$update_string), $id, $table,time(),1);
				echo $id.'<br>';
				$i++;
			}	
			//delivered - вручено === presentation
			//arrived - прибыло  === delivered 
			//accepted или in_transit - прибыло
			// $tis = $track_info["result"]["checkpoints"][0]['status'];			
			// if($tis == 'delivered'){
				// if($status != 'presentation'){
					// $presentation[] = $id;					
					// $phones[]=json_decode($v['params'], true)[2];

				// }
			// }else if($tis == 'arrived'){
				// if($status != 'delivered'){					
					// $delivered[] = $id;
					
				// }
			// }
		// }
		// if(isset($presentation) && !empty($presentation)){
				// $q = 'UPDATE `orders` SET `status` = "presentation", `user_status`=2, `order_status_date`='.time().', `status_date`='.time().'   WHERE `id` in ('.join(',',$presentation).')';				
				// IOMysqli::query($q);
				// $str = 'Изменение статуса на вручено у заказов с id: '.join(',<br>',$presentation);
				// $messages = 'Ваша поссылка доставлена';
				// Sms::send_sms(join(',',$phones), $messages, 0, 0, 0, 0, 'Intermag');
			// }
			// if(isset($delivered) && !empty($delivered)){
				// $q = 'UPDATE `orders` SET `status` = "delivered", `user_status`=0, `order_status_date`='.time().', `status_date`='.time().' WHERE `id` in ('.join(',',$delivered).')';				
				// IOMysqli::query($q);
				// $str = 'Изменение статуса на прибыло у заказов с id: '.join(',<br>',$delivered);
			}			
			echo '<br><br>всего заказов изменили статус: '.$i;
			}
		// IOMysqli::query($q);
	}
}
