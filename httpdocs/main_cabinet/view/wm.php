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
					<th>ID</th>
					<th>E-mail</th>
					<th>Реферал</th>
					<th>Баланс</th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
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
<div id="info_web_paymants" class="modal" style="display: none;">
		<div class="modal-block modal-top modal-left" style="border-radius: 15px 15px 10px 10px; margin-top: -103px; margin-left: -299px;">
			<div class="icon-close"></div>
			<div class="title" style="border-radius: 10px 10px 0px 0px;"><h1></h1></div>
			<div class="content" style="background: #fff;">				
			
			</div>
		</div>
	</div>
<div id="iframe">
	<div>
		<span>Закрыть</span>
	</div>
	<iframe src="">
</div>