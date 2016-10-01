<?
class Cdek{
	public static function cdekNumber(){
		$cdek_number = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);		
		$q='SELECT id FROM `info_orders` WHERE `sdek_number` = '.$cdek_number.' LIMIT 1';
		$resp = IOMysqli::one($q);
		if(isset($resp) && !empty($resp)){			
			static::cdekNumber();
		}else{
			return $cdek_number;
		}
	}
	public static function sendOrder($data,$partner_id){
		if(isset($data) && !empty($data) && is_array($data)){
			$count_order = count($data);
			$cdek_number = static::cdekNumber();
			$date = date('Y-m-d');
			
			$q = 'SELECT * FROM `partner_cdek` WHERE `partner_id`='.$partner_id;
			$pc = IOMysqli::row($q);
			if(isset($pc) && !empty($pc)){
				// $account = $pc['login'];
				// $secure = md5($date.'&'.$pc['password']) ;
				$account = '91847268f442a61a6cdf0002f85fc02c';
				$secure = '8d3090ff782fc961f86506013713845c';
			$head = '<?xml version="1.0" encoding="UTF-8" ?>
<DeliveryRequest Number="'.$cdek_number.'" Date="'.$date.'" Account="'.$account.'" Secure="'.$secure.'" OrderCount="'.$count_order.'">
<Order Number="678543" 	
	DeliveryRecipientCost="150" 
	SendCityCode="270" 
	RecCityCode="44"
	RecipientName="Lubomir Dmitry Vladimirovich"
	Phone="9197747341"
	TariffTypeCode="11"
	SaleName="Ruston"
	RecientCurrency="RUB"
	ItemsCurrency="RUB">
	Phone="9197747341"
	Comment="Офис группы компаний Ланит. При приезде позвонить на мобильный телефон."
	TariffTypeCode="11">
	<Address Street="Боровая" House="д. 7, стр. 2" Flat="оф.10" />
	<Package Number="1" BarCode="102" Weight="810">
	   <Item WareKey="25000358171" Cost="164" Payment="0" Weight="158" Amount="1" Comment="ХочуУчиться Логика (Беденко 		М.В.)"/>
	   <Item WareKey="25000428787" Cost="107" Payment="0" Weight="194" Amount="1" Comment="ЛомоносовскаяШкола(о) Считаю и 	решаю Д/детей 5-6 л"/>
	   <Item WareKey="33000002164" Cost="107"  Payment="0" Weight="174" Amount="1" Comment="ЛомоносовскаяШкола(о) Говорю 	красиво Д/детей 6-7 л"/>
	   <Item WareKey="33000002165" Cost="107" Payment="0" Weight="174" Amount="1" Comment="ЛомоносовскаяШкола(о) Говорю 	красиво Д/детей 6-7 л"/>
	</Package>
	<Package Number="2" BarCode="103" Weight="740">
	   <Item WareKey="25000086458" Cost="427" Payment="0" Weight="323" Amount="2" Comment="Перемены Рук-во к личной 	трансформации и новые спо"/>
	   <Item WareKey="25000377899" Cost="238" Payment="0" Weight="310" Amount="1" Comment="Коэльо П.(АСТ)(тв)(цв.) Вероника 	решает умереть"/>
	 </Package>
	<AddService ServiceCode="29"></AddService>
	<AddService ServiceCode="30"></AddService>
	<Schedule>	
 	   <Attempt ID="3" Date="2010-10-15" TimeBeg="19:00:00" TimeEnd="22:00:00"/>
	</Schedule>	
    </Order>
	</DeliveryRequest>
';
		$body = <<<xml
		<Order Number="678543" 	
	DeliveryRecipientCost="150" 
	SendCityCode="270" 
	RecCityCode="44"
	RecipientName="Lubomir Dmitry Vladimirovich"
	Phone="9197747341"
	TariffTypeCode="11"
	SaleName="Ruston"
	RecientCurrency="RUB"
	ItemsCurrency="RUB">
	Phone="9197747341"
	Comment="Офис группы компаний Ланит. При приезде позвонить на мобильный телефон."
	TariffTypeCode="11">
	<Address Street="Боровая" House="д. 7, стр. 2" Flat="оф.10" />
	<Package Number="1" BarCode="102" Weight="810">
	   <Item WareKey="25000358171" Cost="164" Payment="0" Weight="158" Amount="1" Comment="ХочуУчиться Логика (Беденко 		М.В.)"/>
	   <Item WareKey="25000428787" Cost="107" Payment="0" Weight="194" Amount="1" Comment="ЛомоносовскаяШкола(о) Считаю и 	решаю Д/детей 5-6 л"/>
	   <Item WareKey="33000002164" Cost="107"  Payment="0" Weight="174" Amount="1" Comment="ЛомоносовскаяШкола(о) Говорю 	красиво Д/детей 6-7 л"/>
	   <Item WareKey="33000002165" Cost="107" Payment="0" Weight="174" Amount="1" Comment="ЛомоносовскаяШкола(о) Говорю 	красиво Д/детей 6-7 л"/>
	</Package>
	<Package Number="2" BarCode="103" Weight="740">
	   <Item WareKey="25000086458" Cost="427" Payment="0" Weight="323" Amount="2" Comment="Перемены Рук-во к личной 	трансформации и новые спо"/>
	   <Item WareKey="25000377899" Cost="238" Payment="0" Weight="310" Amount="1" Comment="Коэльо П.(АСТ)(тв)(цв.) Вероника 	решает умереть"/>
	 </Package>
	<AddService ServiceCode="29"></AddService>
	<AddService ServiceCode="30"></AddService>
	<Schedule>	
 	   <Attempt ID="3" Date="2010-10-15" TimeBeg="19:00:00" TimeEnd="22:00:00"/>
	</Schedule>	
    </Order>

xml;
$footer = <<<xml
</DeliveryRequest>
xml;

// $url = 'http://gw.edostavka.ru:11443';
$url = '80.89.144.238:443';
$d['xml_request'] = $head;
// echo  $head;
		// exit;
		$cul = curl_init(); 
		curl_setopt($cul, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($cul, CURLOPT_POST, 1); 
		curl_setopt($cul, CURLOPT_POSTFIELDS, $d); 
		curl_setopt($cul, CURLOPT_URL, $url); 
		curl_setopt($cul, CURLOPT_HEADER, false); 

		$response = curl_exec($cul); 
		var_dump($response);
		exit;
			}
		}
	}
	
}
?>