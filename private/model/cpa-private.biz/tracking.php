<?php
class Tracking extends Model {
	static private $key  = '0ff87b2b36c58c2a920ff5e55076a9cd1277843ca27060f436eb00eb381a01bb8cbd3f7aa175c813';
	
	public static function getTrackingInfo($tr_number){
		if(isset($tr_number) && !empty($tr_number) && filter_var($tr_number,FILTER_VALIDATE_INT)){
			$q = 'select id from `info_orders` where track_number='.$tr_number;
			$prov = IOMysqli::one($q);

			if($prov == false || $prov == NULL){				
				$add = static::addTracking($tr_number);
				if(isset($add['error']) && !empty($add['error'])){
					return $add;
				}				
			}
			$link = 'http://gdeposylka.ru/api/v3/jsonrpc';
			$param['jsonrpc'] = '2.0';
			$param['method'] = 'getTrackingInfo';
			$param['params'] = array('tracking'=>array(
				'tracking_number'=>$tr_number,
				'courier_slug'=>'russian-post',
				"title"=> "Посылочка"
			));   
			$param['id'] = '1';
			$param_str = json_encode($param);
			
			$headers = array( 
							"Content-Type: application/json", 
							"X-Authorization-Token: ".static::$key
						);

			$myCurl = curl_init();

				curl_setopt_array($myCurl, array(
				CURLOPT_URL => $link,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HTTPHEADER => $headers,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $param_str
			));
			$response = curl_exec($myCurl);
		
			curl_close($myCurl);
			$r = json_decode($response, true);

			if($r['error']['message'] == 'Tracking not found, you should call addTracking method first.'){
				$resp = static::addTracking($tr_number);

				if($resp){
					static::getTrackingInfo($tr_number);
				}
			}else{
				return $r;
			}
		
		}else{
			return false;
		}
	}
	public static function addTracking($tr_number){
		
		if(isset($tr_number) && !empty($tr_number)){
				    $link = 'http://gdeposylka.ru/api/v3/jsonrpc';
			$param['jsonrpc'] = '2.0';
			$param['method'] = 'addTracking';
			$param['params'] = array('tracking'=>array(
				'tracking_number'=>$tr_number,
				'courier_slug'=>'russian-post',
				"title"=> "Посылочка"
			));   
			$param['id'] = '1';
			$param_str = json_encode($param);
			
			$headers = array( 
							"Content-Type: application/json", 
							"X-Authorization-Token: ".static::$key
						);

		$myCurl = curl_init();

			curl_setopt_array($myCurl, array(
			CURLOPT_URL => $link,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => $headers,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $param_str
		));
		$response = curl_exec($myCurl);

		curl_close($myCurl);
		return $response = json_decode($response, true);
		
		}
	}
}