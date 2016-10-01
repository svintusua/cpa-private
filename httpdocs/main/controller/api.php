<?
class C_Api extends Controller{
	protected $template = "download";
	
	public function main() {
				
		if(isset($_GET['method']) && !empty($_GET['method'])){
			switch($_GET['method']){
				case 'getstatus':
				
					if(isset($_GET['ids']) && !empty($_GET['ids'])){		
						$orders_info = Order::getInfoOrders(explode(',',$_GET['ids']));
						$orders_status = array();
						foreach($orders_info as $v){
							$orders_status[$v['id']] = $v['user_status'];
						}
						echo json_encode(array('response'=>'success', 'orders_status'=>$orders_status));
					}else{
						echo json_encode(array('response'=>'error', 'code'=>'002'));
					}
				break;
			}
		}else{
			echo json_encode(array('response'=>'error', 'code'=>'001'));
		}
	}
	
}