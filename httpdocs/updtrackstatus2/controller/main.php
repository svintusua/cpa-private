<?php
class C_Main extends Controller {

    protected $template = "empty";
	
    public function main() {	
		$q = 'Select o.id, o.status, io.track_number from orders as o join info_orders as io on o.id=io.order_id where io.track_number!=0 and o.status!="delivered" and o.status!="presentation"';
		$orders = IOMysqli::table($q);
		$presentation = array();
			$delivered = array();
		foreach($orders as $v){
			$status = $v['status'];
			$id = $v['id'];
			
			// $track_number = $v['track_number'];
			// $track_info = Tracking::getTrackingInfo($track_number);
			$track_info = Tracking::getTrackingInfo('19000092212723');
			
			//delivered - вручено === presentation
			//arrived - прибыло  === delivered 
			//accepted или in_transit - прибыло
			$tis = $track_info["result"]["checkpoints"][0]['status'];			
			if($tis == 'delivered'){
				if($status != 'presentation'){
					$presentation[] = $id;
					
				}
			}else if($tis == 'arrived'){
				if($status != 'delivered'){					
					$delivered[] = $id;
					
				}
			}
		}
		if(isset($presentation) && !empty($presentation)){
				$q = 'UPDATE `orders` SET `status` = "presentation" WHERE `id` in ('.join(',',$presentation).')';				
				IOMysqli::query($q);
				$str = 'Изменение статуса на вручено у заказов с id: '.join(',',$presentation);
			}
			if(isset($delivered) && !empty($delivered)){
				$q = 'UPDATE `orders` SET `status` = "delivered" WHERE `id` in ('.join(',',$delivered).')';				
				IOMysqli::query($q);
				$str = 'Изменение статуса на прибыло у заказов с id: '.join(',',$delivered);
			}
			echo $str;
		// IOMysqli::query($q);
		parent::main();
	}
}