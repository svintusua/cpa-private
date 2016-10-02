<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>payments</title>
<link href="style.css" rel="stylesheet">
</head>
<body>
<div class="pay_body">
	<div class="pay_head">
		<ul class="pay_bal_ul">
			<li class="pay_bal_li"><div class="pay_bal pay_title">Текущий баланс :</div></li>
			<li class="pay_bal_li"><div class="pay_bal pay_money_rub"><b><span class="s"><?=$this->vars['balans']?></span><i class="fa fa-rub"></i></b></div></li>
			<!--<li class="pay_bal_li"><div class="pay_bal pay_money_dol"><b>150000.00<i class="fa fa-usd"></i></b></div></li>-->
			<li class="pay_bal_li"><input class="pay_btn" id="payments" type="submit" value="Вывести"></li>
			<li class="pay_bal_li">	
				<form method="POST" id="po">
					<span>сумма доступная для выплаты - <?=$this->vars['summa']?> <i class="fa fa-rub"></i></span><br>
					<input class="pay_btn" id="summa" type="number" placeholder="сумма выплаты" max="<?=$this->vars['summa']?>">
					<input class="pay_btn" id="give_money" type="submit" value="Заказать выплату">
				</form>
			</li>
		</ul>
		<ul class="pay_num_ul" >
			<!--<li class="pay_bal_li"><label class="pay_num_label">На кошелек</label></li>
			<li class="pay_bal_li">
				<select class="pay_num" id="wallet">
					<?=$this->vars['wallet']?>
				</select>
			</li>-->
		</ul>	
	</div>
	<table class="pay_table">
		<tr>
			<th>Дата</th>
			<th>Сумма</th>
			<th>Статус</th>
		</tr>
		<?=$this->vars['tr']?>
	</table>
</div>
</body>
</html>