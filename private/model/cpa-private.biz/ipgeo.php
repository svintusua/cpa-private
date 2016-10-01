<?php
class Ipgeo{
	
	public static function geoByIp($ip){
		if(filter_var($ip,FILTER_VALIDATE_IP)){			
			// return file_get_contents('http://api.sypexgeo.net/json/'.$ip);		
			return file_get_contents('http://7oclock.ru/sypexgeo.php?ip='.$ip);		
			
		}else{
			return false;
		}
	}
	public static function countryByIp($ip){
		if(filter_var($ip,FILTER_VALIDATE_IP)){
			$geo = static::geoByIp($ip);
			$country = json_decode($geo, true)['country']['name_ru'];
			return $country;
		}else{
			return false;
		}
	}
	public static function countryCodeByIp($ip){
		if(filter_var($ip,FILTER_VALIDATE_IP)){
			$geo = static::geoByIp($ip);
			$countryCode = json_decode($geo, true)['country']['iso'];
			return $countryCode;			
		}else{
			return false;
		}
	}
	public static function cityByIp($ip){
		if(filter_var($ip,FILTER_VALIDATE_IP)){
			$geo = static::geoByIp($ip);
			$city = json_decode($geo, true)['city']['name_ru'];
			return $city;
		}else{
			return false;
		}
	}
	public static function regionByIp($ip){
		if(filter_var($ip,FILTER_VALIDATE_IP)){
			$geo = static::geoByIp($ip);
			$region = json_decode($geo, true)['region']['name_ru'];
			return $region;
		}else{
			return false;
		}
	}
}