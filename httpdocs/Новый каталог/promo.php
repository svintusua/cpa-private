<?
define("SITE", 'дымчик.рф');
include '../site/config.php';
$conf = $GLOBALS["CONFIG"]["mysql"];
$db = new mysqli($conf["host"], $conf["user"], $conf["password"], $conf["database"]);
if ($db->connect_errno){
    echo json_encode(array('Error'=>"Fatal error database"));
	die;	
}
$db->set_charset("utf8");
if($_POST['promocode']){
	if(strlen($_POST['promocode']) == 9){
		$resp = mysqli_query($db, 'SELECT `used` FROM `promo` WHERE `promo` = "'.$_POST['promocode'].'" LIMIT 1');
		
		if(mysqli_num_rows($resp)==1){
				$data = mysqli_fetch_assoc($resp);
			if($data['used'] == 0){
				$used = 'noused';
			}else if($data['used'] == 1){
				$used = 'used';
			}
		}else{
			$used = 'Такой промокод не найден!';
		}
	}else{
		$used = 'Такого промокода не существует!';
	}
	echo json_encode(array('response'=>utf8_encode($used)));
	die;
}else{
	echo json_encode(array('response'=>utf8_encode('Промокод отсутсвует')));
	die;
}

	$resource = $_SERVER['HTTP_REFERER'];
	$ip = $_SERVER['REMOTE_ADDR'];

$css = <<<text
<style>
		@font-face {
			font-family: "GothaProLig";
			src: url("http://дымчик.рф/fonts/GothaProLig.otf");
			/*src: url("../fonts/Roboto-Thin.ttf") format("truetype");*/
		}
		* {
			margin: 0;
			padding: 0;
			outline: none;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			-webkit-box-sizing: border-box;
			-webkit-appearance: none;
		}
		html,body{
			width:100%;
			height: 100%;
			position: reletive;
			font-family: "GothaProLig";
		}
		#response{
			width: 500px;
			height: 250px;
			border: 2px solid #4a4a4a;			
			position: absolute;
			top:0;
			bottom:0;
			left:0;
			right:0;
			margin: auto;
			text-align: center;
			border-radius: 20px;
		}
		#response::after{
			content:"";
			display:inline-block;
			height:100%;
			vertical-align: middle;
		}
		#response div {
			display: inline-block;
			margin: auto;
			vertical-align: middle;
			padding: 10px;
		}
		#response div h1{
			color: #ffa300;
			font-size: 35px;
		}
		#response div h2{
			color: #4a4a4a;
			font-size: 20px;
		}
		#response div p{
			color: #868686;
			font-size: 100%;
		}
		#response div p:first-child{
			margin-top:10px;
		}
		#response div p:last-child{
			margin-bottom:10px;
		}
		#response div p span{
			color:#ffa300;
		}
		#response div a {
			background: #ffa300 none repeat scroll 0 0;
			border-bottom: 5px solid #b67b13;
			border-radius: 5px;
			color: #fff;
			cursor: pointer;
			display: block;
			font-family: GothaProLig;
			font-size: 15px;
			margin-top: 10px;
			padding: 15px 23px;
			text-transform: uppercase;
		}
		#response div a:hover {
			background: #ffaf22 none repeat scroll 0 0;
		}
	</style>
text;
	$promo_data = array();
	$data = array();

	if(isset($resource) && !empty($resource) && isset($ip) && !empty($ip)){
		$resp = mysqli_query($db, 'SELECT `promo` FROM `promo` WHERE `resource` = "'.$resource.'" AND `ip` = "'.$ip.'" LIMIT 1');
		$resp2 = mysqli_query($db, 'SELECT `promo` FROM `promo` WHERE `ip` = "'.$ip.'" LIMIT 1');
		$promo_data['promoByResource'] = mysqli_fetch_assoc($resp);
		$promo_data['promoByIp'] = mysqli_fetch_assoc($resp2);
		
		foreach($promo_data as $val){
			if(isset($val) && !empty($val)){
				$data['promo'] = $val['promo'];
			}
		}
		
		if(isset($data) && !empty($data)){
			$promo = $data['promo'];
		}else{
			$promo = promocode();
			$resp = mysqli_query($db, 'INSERT INTO `promo`(`resource`, `ip`, `promo`, `used`) VALUES ("'.$resource.'","'.$ip.'","'.$promo.'",0)');
		}
$html = <<<html
<html>
<head>
	<title>дымчик.рф промокод</title>
	$css
</head>
<body>
<div id="response">
	<div>
		<h1>Приветсвуем Вас!</h1>
		<h2>дымчик.рф с радостью предоставлет Вам промокод на скидку</h2>
		<p>Ваш промокод - <span>$promo</span></p>
		<p>Для получение скидки скопируйте Ваш код и вставьте в соотвествующее поле на сайте при отправке заявки.</p>
		<a href="/">Перейти на сайт</a>
	</div>
</div>
</body>
</html>
html
;
	}else{
	$html = <<<html
<html>
<head>
	<title>дымчик.рф промокод</title>
	$css
</head>
<body>
<div id="response">
	<div>
		<h1>Ошибка!</h1>
		<h2>не засчитан переход</h2>
		<p>Если вы перешли по ссылке из мобильного приложения, то попробуйте еще раз перейти по ссылке из браузера или пройдите по ссылке из другого браузера.</p>
		<a href="/">Перейти на сайт</a>
	</div>
</div>
</body>
</html>
html
;
}
	echo $html;

function promocode(){
	$arr = array('a', 'b', 'c', 'd', 'e', 'f',
                     'g', 'h', 'i', 'j', 'k', 'l',
                     'm', 'n', 'o', 'p', 'r', 's',
                     't', 'u', 'v', 'x', 'y', 'z',
                     'A', 'B', 'C', 'D', 'E', 'F',
                     'G', 'H', 'I', 'J', 'K', 'L',
                     'M', 'N', 'O', 'P', 'R', 'S',
                     'T', 'U', 'V', 'X', 'Y', 'Z',
                     '1', '2', '3', '4', '5', '6',
                     '7', '8', '9', '0');

        $promocode = "";

        for ($i = 0; $i < 9; $i++) {

            $index = rand(0, count($arr) - 1);

            $promocode .= $arr[$index];
        }

        return $promocode;
}
