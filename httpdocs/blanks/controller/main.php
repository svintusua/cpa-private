<?php
class C_Main extends Controller {

    protected $template = "empty";
	
    public function main() {	
		if(isset($_REQUEST['orders_id']) && !empty($_REQUEST['orders_id'])){
			$orders_id = json_decode($_REQUEST['orders_id'], true);
			$data = array();
			$blank_type = $_REQUEST['blank_type'];
			// switch($_REQUEST['orders_id']){
				// case 'f7':
				
			// }
			// $data['from_name'] = $_REQUEST['from_name'];
			$order_info = Order::getInfoOrders($orders_id);
			
			if(filter_var($_REQUEST['from_name'], FILTER_VALIDATE_INT)){
				$sender = Senders::getSenderById($_REQUEST['from_name']);
				$adr = explode(',',$sender['address']);
				$data['from_address_1'] = array_shift($adr).', ';
				$data['from_address_2'] = join(', ', $adr);
				$data['zip_from'] = $sender['zip'];
				$data['from_name'] = $sender['name'];
			}else{
				echo 'Неверный ID отправителя';
				die;
			}
			// switch($_REQUEST['from_name']){
				// case 'Жуков';
					// $data['from_name'] = 'Жуков Георгий Николаевич';
				// break;
				// case 'Логвинов';
					// $data['from_name'] = 'Логвинов Ярослав Олегович';
				// break;
				// case 'Злотников';
					// $data['from_name'] = 'Злотников Константин Игоревич';
				// break;
			// }
			
			$a = '';
			foreach($order_info as $v){
				
			
			$data['summa'] = $v['order_sum'];
			$data['zip'] = $v['index'];
			$data['who'] = json_decode($v['params'],true)[1];
			$data['who_address_1'] = $v['city'].', ул.'.$v['street'];
			$data['who_address_2'] = 'д.'.$v['house'].', кв.'.$v['flat'];
			$a .= Blank::getBlank($blank_type,$data);

			
			}
			if($blank_type == 'f7'){
				echo Blank::$f7_head;
			}else{
				echo Blank::$f112_head;
			}
			echo '<div class="print" onclick="print(); return false;"><span>Печать</span></div>';
			echo $a;
			echo '</body></html>';
			exit;
		}else{
			return false;
		}
		parent::main();
	}
}