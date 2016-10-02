<div id="content_wm">
	<div class="menu_wm">
	<menu label="Меню">
		<a href="/main_cabinet/" type="button">Партнеры</a>
		<a href="/main_cabinet/wm" type="button">Вебмастера</a>
		<a href="/main_cabinet/payments" type="button">Выплаты</a>
	</menu>
</div>
	<div class="caption"><h1><?=$this->vars['title']?></h1>
		<div id="partner_wm">
			<table>
				<tr>
					<th>ID веба</th>
					<th>Дата</th>
					<th>Сумма</th>
					<th>Статус</th>
					<th></th>
				</tr>
<!--				<tr>
					<td>1</td>
					<td>2</td>
					<td>3</td>
					<td><input type="number" value="0"></td>
					<td><span class="a_b add_balans"><i class="zmdi zmdi-hc-fw"></i></span>
						<span class="a_b subtract_balans"><i class="zmdi zmdi-hc-fw"></i></span>
					</td>
				</tr>-->
				<?=$this->vars['t_u']?>
			</table>
		</div>	
	</div>
</div>
<style>
	#info_web_paymants table{
		width: 100%;
		text-align: center;
		border-spacing: 0;
	}
	#info_web_paymants td {
    border-bottom: 1px solid #eee;
    padding: 3px 0;
}
</style>
