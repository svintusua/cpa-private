<!DOCTYPE html>  
<html>
<head>
	<meta charset="utf-8">
	<title><?=$this->vars['title']?></title>
	<link href="http://cpa-private.biz/favicon.ico" rel="shortcut icon">
	<link href="http://allfont.ru/allfont.css?fonts=lobster" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="../css/simple-line-icons.css">
	<link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.8.21.custom.css">
	<link rel="stylesheet" type="text/css" href="../css/partner/style.css?r=<?date('ymdHis');?>">
	<link rel="stylesheet" type="text/css" href="../css/partner/jquery.kladr.min.css">
	<link rel="stylesheet" type="text/css" href="../css/mfglabs_iconset.css">
	<link rel="stylesheet" type="text/css" href="../css/modal.css">
	<link rel="stylesheet" href="../css/jquery.mCustomScrollbar.css">
	<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.1.2/css/material-design-iconic-font.min.css">
	<script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="../js/jquery.nav.min.js"></script>
	<script type="text/javascript" src="../js/ajaxupload.3.5.js"></script>
	<script type="text/javascript" src="../js/jquery.maskedinput.min.js"></script>
	<script type="text/javascript" src="../js/partner/main.js?r=<?=date('ymdHis');?>"></script>
	<script type="text/javascript" src="../js/partner/jquery.kladr.min.js"></script>
	<script type="text/javascript" src="../js/modal.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="../js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="../js/jquery-ui-1.8.21.custom.min.js"></script>
	<script src="//api-maps.yandex.ru/2.1/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
	
</head>
<body>
<div class="top">
<?=$this->vars['special']?>
<span class="goout">Выйти</span>
</div>
<header>
<div></div>
	<div class="left">
		<?
			if(isset($this->vars['manager']) && !empty($this->vars['manager'])){
				echo '<p>'.$this->vars['manager'].'</p>';
			}
		?>
		<nav style="display: <?=$this->vars['display']?>">
			<ul>
				<li><a href="/partner_cabinet">Заказы</a></li>
				<li><a href="" >Статистика</a></li>
			</ul>
		</nav>
	</div>
	<div class="right">
		<nav style="display: <?=$this->vars['display']?>">
			<ul>
				<li><a href="/partner_cabinet/warehouse">Склад</a></li>
				<li><a style="display: <?=$this->vars['display']?>" href="">Вебмастера</a></li>
				<li><a style="display: <?=$this->vars['display']?>" href="/partner_cabinet/managers">Менеджеры</a></li>
			</ul>
		</nav>
	</div>
	<img src="../img/partner/logo_green.png" id="logo">
</header>