<?php

    $conf = array(
        "mysql" => array(
            "host" => "a134180.mysql.mchost.ru",
            "database" => "a134180_cpa",
            "user" => "a134180_cpa",
            "password" => "cpaa134180"
        )
    );

$mysqli = new mysqli($conf["mysql"]["host"], $conf["mysql"]["user"], $conf["mysql"]["password"], $conf["mysql"]["database"]);
if ( $mysqli->connect_errno){
    throw new Exception("Fatal error database",E_USER_ERROR);
}else{
//echo json_encode(array('еуст тптптп'),JSON_UNESCAPED_UNICODE );
//     die;
    if(isset($_REQUEST['method']) && !empty($_REQUEST['method'])){
		
        switch ($_REQUEST['method']){
            case 'getstatus':
                if(isset($_REQUEST['order_id']) && !empty($_REQUEST['order_id'])){
                     $order_arr = array();
                     $order_arr = explode(',',$_REQUEST['order_id']);
                     $orders = array();
                     
                     foreach($order_arr as $v){
                        if(filter_var($v,FILTER_VALIDATE_INT)){
                            $orders[]=$v;
                        }
//                        }else{
//                            $array = array('responce'=>'error','code'=>'004');
//                            output($array);
//                        }
                     }
                    if(isset($orders)&& !empty($orders)){
                        $q = 'SELECT id, user_status as status,additional  FROM orders WHERE id in ('.join(',',$orders).')';
                       // var_dump($q);
                               // exit;
                        $res = $mysqli->query($q);
                        if($res && $res->num_rows > 0){
                            $data = array();
                            while($row = $res->fetch_assoc()){
                               // var_dump($row); 
                               // exit;
                                switch($row['status']){
                                    case 0:
                                        $status = 'rejected';
                                        break;
                                    case 1:
                                        $status = 'waiting';
                                        break;
                                    case 2:
                                        $status = 'approved';
                                        break;
                                }
                                $row['status'] = $status;
								// var_dump($row['comment']);
								// echo '<br>';
								// var_dump( htmlentities($row['comment'], ENT_COMPAT,'KOI8-R', true));
								
								// exit;
                                // $row['comment'] = htmlentities($row['comment'], ENT_DISALLOWED,'KOI8-R', true);
//                                var_dump(transliterate($row['additional']));
//                                exit;
                                $row['additional'] = transliterate($row['additional']);
//                                $data[]=array('order_id'=>$row['id'],'status'=>$status);
//                                $arr = array('order_id'=>$row['id'],'status'=>$status);
//                                var_dump($row);
//                                exit;
//                                if(isset($row['additional']) && !empty($row['additional'])){
//                                   $arr[] += array('additional'=>$row['additional']);
//                                }
                                $data[]=$row;
                            }
                            $array = array('responce'=>'success','data'=>$data);
                        }else{
                           $array = array('responce'=>'error','code'=>'005');
                        }
                    }else{
                        $array = array('responce'=>'error','code'=>'004');
                    }                     
                }else{
                    $array = array('responce'=>'error','code'=>'003');                   
                }
                break;
            default :
                $array = array('responce'=>'error','code'=>'002');                
        }
    }else{
       $array = array('responce'=>'error','code'=>'001');        
    }
    output($array);
}
function output($array){
    if(isset($array) && !empty($array) && is_array($array)){
//        echo $array['data'][0]['comment'];
//        exit;
        echo json_encode($array,JSON_UNESCAPED_UNICODE);
        // echo jsonencode($array);
//        echo json_encode(convert('cp1251', 'utf-8', $array));
        die;
    }
}
function transliterate($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
        
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return strtr($string, $converter);
}

?>