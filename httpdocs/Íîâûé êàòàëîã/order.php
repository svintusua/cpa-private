<?
error_reporting(E_ALL);
define("SITE", 'дымчик.рф');
include '../site/config.php';
$conf = $GLOBALS["CONFIG"]["mysql"];
$db = new mysqli($conf["host"], $conf["user"], $conf["password"], $conf["database"]);
if ($db->connect_errno){
    echo json_encode(array('Error'=>"Fatal error database"));
	die;	
}
$db->set_charset("utf8");

//require('smtp-func.php');
if(isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['phone']) && !empty($_POST['phone'])) {
		$order_name=$_POST['product'];
		
		$name=trim($_POST['name']);
		$phone = trim($_POST['phone']);
		$promo_to_mail ='';
		if(isset($_POST['promo']) && !empty($_POST['promo'])){
			$promo=trim($_POST['promo']);
			$resp = mysqli_query($db, 'UPDATE `promo` SET `used`=1 WHERE `promo`="'.$_POST['promo'].'" LIMIT 1');
			$promo_to_mail = '<p>Промокод: <b>'.$promo.'</b></p>';
		}
		//$z=array('(',')',' ','+','-'); 
		//$phone=str_replace($z,'', $phone);
			//----------------------------------------------- проверка на дубль ----------------------------------------------		
		/*
		$order_prov=md5($name.$phone.$order_name);
		
		if(isset($_COOKIE['order_control'])){
			if($_COOKIE['order_control']==$order_prov){
				echo json_encode(array('resp'=>'');
				$data['ans'] = 'Ошибка';
			}else{
				setcookie("order_control", $order_prov, time()+3600);
			}
		}else{
			setcookie("order_control", $order_prov, time()+3600); 
		}
		*/
		//-----------------------------------------------
		$order_id=mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y')).rand(0,99);//date('ymdHis');
		$ip=$_SERVER['REMOTE_ADDR'];
		
		$email='agap91@bk.ru,';
		$msg = '<html>
			<head>
			<meta charset="urf-8"/>
			<title>Заказ №'.$order_id.'('.$order_name.')</title>
			</head>
			<body>
			<p>№ заказ: <b>'.$order_id.'</b></p>
			<p>Заказ: <b>'.$order_name.'</b></p>
			<p>Имя: <b>'.$name.'</b></p>
			<p>Телефон: <b>'.$phone.'</b></p>
			'.$promo_to_mail.'
			<p>Дата заказа: <b>'.date('d.m.y. H:m').'</b></p>
			<p>IP: <b>'.$ip.'</b></p>
			</body>
			</html>';
			$headers  = "Content-type: text/html; charset=utf-8 \r\n";
			$headers .= "From: Дымоход <no-reply@дымчик.рф/>\r\n"; 
			
			$mail1 = smtpmail('agap91@bk.ru', "Заказ №".$order_id, $msg, $headers);
			$mail2 = smtpmail('artem.bondar.a.v.bondar@mail.ru', "Заказ №".$order_id, $msg, $headers);
			
			if($mail1 == true && $mail2 == true){		
				echo json_encode(array('response' => 'Заявка принята. Номер Вашей заявки №'.$order_id.' . Наш менеджер скоро перезвонит вам'));
				
			}else{
				echo json_encode(array('response' => 'Ошибка при отправке заявки. Попробуйте еще раз'));
							
			}
			

}else{
	echo json_encode(array('response' => 'Переданы не все данные'));
	
}


function smtpmail($mail_to, $subject, $message, $headers='') {
		
        //Настройки почты
        $config['smtp_username'] = 'info@xn--d1aigg9cwa.xn--p1ai';  //Смените на имя своего почтового ящика из ISPManager.
        $config['smtp_password'] = 'qwe123';  //Измените пароль.
        $config['smtp_from']     = 'дымчик.рф'; //Ваше имя - или имя Вашего сайта. Будет показывать при прочтении в поле "От кого".
        //Обычно эти настройки менять не стоит
        $config['smtp_host']     = 'localhost';  //Сервер для отправки почты (для наших клиентов менять не требуется).
        $config['smtp_port']     = '25'; // Порт работы. Не меняйте, если не уверены.
        $config['smtp_debug']    = false;  //Если Вы хотите видеть сообщения ошибок, укажите true вместо false.
        $config['smtp_charset']  = 'UTF-8';   //Кодировка сообщений.

        $SEND =   "Date: ".date("D, d M Y H:i:s") . " UT\r\n";
        $SEND .=   'Subject: =?'.$config['smtp_charset'].'?B?'.base64_encode($subject)."=?=\r\n";
        if ($headers) $SEND .= $headers."\r\n\r\n";
        else
        {
                $SEND .= "Reply-To: ".$config['smtp_username']."\r\n";
                $SEND .= "MIME-Version: 1.0\r\n";
                $SEND .= "Content-Type: text/plain; charset=\"".$config['smtp_charset']."\"\r\n";
                $SEND .= "Content-Transfer-Encoding: 8bit\r\n";
                $SEND .= "From: \"".$config['smtp_from']."\" <".$config['smtp_username'].">\r\n";
                $SEND .= "To: $mail_to <$mail_to>\r\n";
                $SEND .= "X-Priority: 3\r\n\r\n";
        }
        $SEND .=  $message."\r\n";
         if( !$socket = fsockopen($config['smtp_host'], $config['smtp_port'], $errno, $errstr, 30) ) {
            if ($config['smtp_debug']) echo $errno."<br>".$errstr;
            return false;
         }

            if (!server_parse($socket, "220", __LINE__)) return false;

            fputs($socket, "EHLO " . $config['smtp_host'] . "\r\n");
            if (!server_parse($socket, "250", __LINE__)) {
               if ($config['smtp_debug']) echo '<p>Не могу отправить EHLO!</p>';
               fclose($socket);
               return false;
            }
            fputs($socket, "AUTH LOGIN\r\n");
            if (!server_parse($socket, "334", __LINE__)) {
               if ($config['smtp_debug']) echo '<p>Не могу найти ответ на запрос авторизации!</p>';
               fclose($socket);
               return false;
            }

            fputs($socket, base64_encode($config['smtp_username']) . "\r\n");
            if (!server_parse($socket, "334", __LINE__)) {
               if ($config['smtp_debug']) echo '<p>Логин авторизации не был принят сервером!</p>';
               fclose($socket);
               return false;
            }
						
            fputs($socket, base64_encode($config['smtp_password']) . "\r\n");
            if (!server_parse($socket, "235", __LINE__)) {
               if ($config['smtp_debug']) echo '<p>Пароль не был принят сервером как верный! Ошибка авторизации!</p>';
               fclose($socket);
               return false;
            }
            fputs($socket, "MAIL FROM: <".$config['smtp_username'].">\r\n");
            if (!server_parse($socket, "250", __LINE__)) {
               if ($config['smtp_debug']) echo '<p>Не могу отправить команду MAIL FROM:</p>';
               fclose($socket);
               return false;
            }
            fputs($socket, "RCPT TO: <" . $mail_to . ">\r\n");

            if (!server_parse($socket, "250", __LINE__)) {
               if ($config['smtp_debug']) echo '<p>Не могу отправить команду RCPT TO:</p>';
               fclose($socket);
               return false;
            }
            fputs($socket, "DATA\r\n");

            if (!server_parse($socket, "354", __LINE__)) {
               if ($config['smtp_debug']) echo '<p>Не могу отправить команду DATA!</p>';
               fclose($socket);
               return false;
            }
            fputs($socket, $SEND."\r\n.\r\n");

            if (!server_parse($socket, "250", __LINE__)) {
               if ($config['smtp_debug']) echo '<p>Не могу отправить тело письма. Письмо не было отправлено!</p>';
               fclose($socket);
               return false;
            }
			
            fputs($socket, "QUIT\r\n");
            fclose($socket);
            return TRUE;
}
function server_parse($socket, $response, $line = __LINE__) {
        global $config;
        $server_response="";
    while (substr($server_response, 3, 1) != ' ') {
        if (!($server_response = fgets($socket, 256))) {
                   if ($config['smtp_debug']) echo "<p>Проблемы с отправкой почты!</p>$response
$line
";
                   return false;
                }
    }
    if (!(substr($server_response, 0, 3) == $response)) {
           if ($config['smtp_debug']) echo "<p>Проблемы с отправкой почты!</p>$response
$line
";
           return false;
        }
    return true;
}

//Отправить почту сразу нескольким получателям, ящики получателей пишем через запятую.

function smtpmassmail($mail_to, $subject, $message, $headers='')
{
$mailaddresses=explode(",",$mail_to);
foreach ($mailaddresses as $mailaddress) smtpmail($mailaddress,$subject,$message,$headers);
}