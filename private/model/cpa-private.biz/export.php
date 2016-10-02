<?
class Export{
	
	public static function exportToExcel($data, $partner_id){
		// $data = array(
		// array(
		// 'строка1 столбец1' ,
		// 'строка1 столбец2' ,
		// 'строка1 столбец3'
		// ),
		// array(
		// 'строка2 столбец1' ,
		// 'строка2 столбец2' ,
		// 'строка2 столбец3'
		// ),
		// array(
		// 'строка3 столбец1' ,
		// 'строка3 столбец2' ,
		// 'строка3 столбец3')
		// );
		// строка, которая будет записана в csv файл
		if(isset($data) && !empty($data) && is_array($data)){
			$str = '' ;
			// перебираем все данные
			foreach($data as $value){
			$str .= join(";",$value)."; \r\n";
			// $value[ 0]. ';' . $value[ 1]. ';' . $value[ 2]. "; \r\n";
			}
			
			// задаем кодировку windows-1251 для строки
			$str = iconv("UTF-8", "WINDOWS-1251",  $str);
			// создаем csv файл и записываем в него строку
			$file_name = $partner_id.'_'.date('d-m-Y').'.csv';
			file_put_contents(WWW_DIR.'export/'.$file_name , $str);
			return array('path'=>WWW_DIR.'export/'.$file_name,'name'=>$file_name);
		}else{
			return false;
		}
	}
}