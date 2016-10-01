<div id="content">
	<div class="menu_wm">
	<menu label="Меню">
		<a href="/main_cabinet/" type="button">Партнеры</a>
		<a href="/main_cabinet/wm" type="button">Вебмастера</a>
		<a href="/main_cabinet/payments" type="button">Выплаты</a>
	</menu>
</div>
	<div class="caption"><h1><?=$this->vars['title']?></h1>
		<div id="partner">
			<table>
				<tr>
					<th>ID</th>
					<th>E-mail</th>
					<th>Баланс</th>
					<th></th>
					<th></th>
				</tr>
				<?=$this->vars['t_u']?>
			</table>
		</div>	
	</div>
</div>
