<?php

class C_Main extends Controller {

    protected $template = "iframe";

    public function main() {
		if(isset($_COOKIE['click']) && !empty($_COOKIE['click']) && strlen($_COOKIE['click']) == 32){
			$click_id=$_COOKIE['click'];
		}else{
			$click_id=$_GET['click'];
			$pck = (int)$_GET['postclick']*86400;
			$time = time();
			$time += $pck;
			setcookie('click_id',$click_id,$time);
		}
		$offer_id = $_GET['offer_id'];
		$info = Offers::getInfoOfferByID($offer_id);
		$this->addVar("offer_id", $offer_id);
		$this->addVar("click_id", $click_id);
		$this->addVar("price", $info['price']);
        parent::main();

    }

	public function order(){
		$this->view = 'thank_page.php';
		$errors = array();
		do{
			if($_POST['click_id'] && strlen($_POST['click_id']) == 32){
				$click_id = $_POST['click_id'];
			}
			if($_POST['offer_id'] && filter_var($_POST['offer_id'], FILTER_VALIDATE_INT)){
				$offer_id = $_POST['offer_id'];
			}else{
				$errors[] = 'ERROR 001';
			}
			if($_POST['name']){//&& strlen($_POST['name']) >= 2 && strlen($_POST['name']) <= 20 
				$name = $_POST['name'];
			}else{
				$errors[] = 'Отсутсвует имя или оно не существует';
			}
			if($_POST['phone']){
				$phone = $_POST['phone'];
			}else{
				$errors[] = 'Отсутсвует телефон';
			}
			if($error){
				break;
			}
			$order_id = "m_m".mktime(date("H"), date("i"), date("s"),date("n"), date("j") , date("Y")).rand(0,99);
			switch($offer_id){
				case 2:
					$product_id = 'powerbank1';					
					$url = "https://skidki90.retailcrm.ru/api/v3/orders/create?apiKey=DhU9Jxa3yiM7c15fbhjejRNpVIsOhehe";
					$order = array(
						 "externalId" => $order_id,
						 "firstName"=>$name,
						 "phone"=>$phone,
						 "items"=>array(
						  array(
						   'productId' => $product_id, 
						   'quantity' => 1, 
						  )
						 ),
						 "source" => array( 
						  "source" => "target 3" 
						 )
						);							
						$data = 'order='.json_encode($order);						
						$cul = curl_init(); 
						curl_setopt($cul, CURLOPT_RETURNTRANSFER, 1); 
						curl_setopt($cul, CURLOPT_POST, 1); 
						curl_setopt($cul, CURLOPT_POSTFIELDS, $data); 
						curl_setopt($cul, CURLOPT_URL, $url); 
						curl_setopt($cul, CURLOPT_HEADER, false); 
						$response = curl_exec($cul); 
				break;
				case 7:					
					$url = "https://skidki90.retailcrm.ru/api/v3/orders/create?apiKey=DhU9Jxa3yiM7c15fbhjejRNpVIsOhehe";
					$order = array(
						"externalId" => $order_id,
						"firstName"=>$name,
						"phone"=>$phone,
						"items"=>array(
							array(
								'productId' => 'iphone6s16gbwhite', 
								'quantity' => 1, 
							)
						),
						"source" => array( 
							"source" => "target 3"
							// "source" => $source,
							// "teaser" => $teaser
						)
					);
					$data = 'order='.json_encode($order);

					$cul = curl_init(); 
					curl_setopt($cul, CURLOPT_RETURNTRANSFER, 1); 
					curl_setopt($cul, CURLOPT_POST, 1); 
					curl_setopt($cul, CURLOPT_POSTFIELDS, $data); 
					curl_setopt($cul, CURLOPT_URL, $url); 
					curl_setopt($cul, CURLOPT_HEADER, false); 
					$response = curl_exec($cul);
				break;
				case 3:
					$url = "https://dvad.retailcrm.ru/api/v3/orders/create?apiKey=Bzq3zA5zJz6MRqymn5GuZX0KHj1Uay7o";
					$order = array(
						"externalId" => $order_id,
						"firstName"=>$name,
						"phone"=>$phone,
						"items"=>array(
							array(
								'productId' => 10183, 
								'quantity' => 1, 
							)
						),
						"customFields" => array( 
							"orderFrom" => "target 3",
							"source" => $click_id
						)
					);
					$data = 'order='.json_encode($order);

					$cul = curl_init(); 
					curl_setopt($cul, CURLOPT_RETURNTRANSFER, 1); 
					curl_setopt($cul, CURLOPT_POST, 1); 
					curl_setopt($cul, CURLOPT_POSTFIELDS, $data); 
					curl_setopt($cul, CURLOPT_URL, $url); 
					curl_setopt($cul, CURLOPT_HEADER, false); 
					$response = curl_exec($cul);
				break;	
				case 4:
					$url = "https://dvad.retailcrm.ru/api/v3/orders/create?apiKey=Bzq3zA5zJz6MRqymn5GuZX0KHj1Uay7o";
					$order = array(
						"externalId" => $order_id,
						"firstName"=>$name,
						"phone"=>$phone,
						"items"=>array(
							array(
								'productId' => 10185, 
								'quantity' => 1, 
							)
						),
						"customFields" => array( 
							"orderFrom" => "target 3"
						)
					);
					$data = 'order='.json_encode($order);					
					$cul = curl_init(); 
					curl_setopt($cul, CURLOPT_RETURNTRANSFER, 1); 
					curl_setopt($cul, CURLOPT_POST, 1); 
					curl_setopt($cul, CURLOPT_POSTFIELDS, $data); 
					curl_setopt($cul, CURLOPT_URL, $url); 
					curl_setopt($cul, CURLOPT_HEADER, false); 
					$response = curl_exec($cul);
				break;
				case 5:
					$url = "https://dvad.retailcrm.ru/api/v3/orders/create?apiKey=Bzq3zA5zJz6MRqymn5GuZX0KHj1Uay7o";
					$order = array(
						"externalId" => $order_id,
						"firstName"=>$name,
						"phone"=>$phone,
						"items"=>array(
							array(
								'productId' => 10381
							)
						),
						"customFields" => array( 
							"orderFrom" => "target 3" 
						)
					);
					$data = 'order='.json_encode($order);

					$cul = curl_init(); 
					curl_setopt($cul, CURLOPT_RETURNTRANSFER, 1); 
					curl_setopt($cul, CURLOPT_POST, 1); 
					curl_setopt($cul, CURLOPT_POSTFIELDS, $data); 
					curl_setopt($cul, CURLOPT_URL, $url); 
					curl_setopt($cul, CURLOPT_HEADER, false); 

					$response = curl_exec($cul); 
				break;
				case 7:
					$url = "https://dvad.retailcrm.ru/api/v3/orders/create?apiKey=Bzq3zA5zJz6MRqymn5GuZX0KHj1Uay7o";
					$order = array(
						"externalId" => $order_id,
						"firstName"=>$name,
						"phone"=>$phone,
						"items"=>array(
							array(
								'productId' => 10312, 
								'quantity' => 1, 
							)
						),
						"customFields" => array( 
							"orderFrom" => "target 3",
							"source" => $click_id
						)
					);
					$data = 'order='.json_encode($order);
					$cul = curl_init(); 
					curl_setopt($cul, CURLOPT_RETURNTRANSFER, 1); 
					curl_setopt($cul, CURLOPT_POST, 1); 
					curl_setopt($cul, CURLOPT_POSTFIELDS, $data); 
					curl_setopt($cul, CURLOPT_URL, $url); 
					curl_setopt($cul, CURLOPT_HEADER, false); 
					$response = curl_exec($cul);
				break;
				case 14:
					$url = "https://dvad.retailcrm.ru/api/v3/orders/create?apiKey=Bzq3zA5zJz6MRqymn5GuZX0KHj1Uay7o";
					$product_id = 46;
					$order = array(
					 "externalId" => $order_id,
					 "firstName"=>$name,
					 "phone"=>$phone,
					 "items"=>array(
					  array(
					   'productId' => $product_id, 
					   'quantity' => 1, 
					  )
					 ),
					 "customFields" => array( 
					  "orderFrom" => "target 3" 
					 )
					);									
					$data = 'order='.json_encode($order);					
					$cul = curl_init(); 
					curl_setopt($cul, CURLOPT_RETURNTRANSFER, 1); 
					curl_setopt($cul, CURLOPT_POST, 1); 
					curl_setopt($cul, CURLOPT_POSTFIELDS, $data); 
					curl_setopt($cul, CURLOPT_URL, $url); 
					curl_setopt($cul, CURLOPT_HEADER, false); 
					$response = curl_exec($cul); 
				break;
				case 15:
					$url = "https://dvad.retailcrm.ru/api/v3/orders/create?apiKey=Bzq3zA5zJz6MRqymn5GuZX0KHj1Uay7o";
					$order = array(
						"externalId" => $order_id,
						"firstName"=>$name,
						"phone"=>$phone,
						"items"=>array(
							array(
								'productId' => 10313
							)
						),
						"customFields" => array( 
							"orderFrom" => "target 3" 
						)
					);
					$data = 'order='.json_encode($order);
					$cul = curl_init(); 
					curl_setopt($cul, CURLOPT_RETURNTRANSFER, 1); 
					curl_setopt($cul, CURLOPT_POST, 1); 
					curl_setopt($cul, CURLOPT_POSTFIELDS, $data); 
					curl_setopt($cul, CURLOPT_URL, $url); 
					curl_setopt($cul, CURLOPT_HEADER, false); 
					$response = curl_exec($cul); 
				break;
				case 16:
					$url = "https://dvad.retailcrm.ru/api/v3/orders/create?apiKey=Bzq3zA5zJz6MRqymn5GuZX0KHj1Uay7o";
					$order = array(
							"externalId" => $order_id,
							"firstName"=>$name,
							"phone"=>$phone,
							"items"=>array(
								array(
									'productId' => 10291, 
									'quantity' => 1, 
								)
							),
							"customFields" => array( 
								"orderFrom" => "target 3",
								"source" => $click_id,
							)
						);
						$data = 'order='.json_encode($order);
						$cul = curl_init(); 
						curl_setopt($cul, CURLOPT_RETURNTRANSFER, 1); 
						curl_setopt($cul, CURLOPT_POST, 1); 
						curl_setopt($cul, CURLOPT_POSTFIELDS, $data); 
						curl_setopt($cul, CURLOPT_URL, $url); 
						curl_setopt($cul, CURLOPT_HEADER, false); 
						$response = curl_exec($cul);
				break;
				
			}

			
		
			file_get_contents('http://cpa-private.biz/handler?fio='.urlencode($name).'&phone='.urlencode($phone).'&order_id='.$order_id.'&click='.$click_id);
			$this->addVar("text", 'Заказ отправлен успешно. Наш менеджер скоро свяжется с Вами. Пожалуйста не выключайте телефон.');
		}while(false);
			if($errors){
				$this->addVar("text", 'Ошибка: '.join(', ', $errors));
			}
		 parent::main();
	}


}
