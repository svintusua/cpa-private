	<div class="frame">
		<form action="/iframe/order" method="POST">
		<input type="hidden" name="offer_id" value="<?=$this->vars['offer_id']?>">
		<input type="hidden" name="click_id" value="<?=$this->vars['click_id']?>">
		<div class="name">
			<label for="name">ФИО</label>
			<input type="text" name="name" id="name">
		</div>
		<div class="phone">
			<label for="phone">Телефон</label>
			<input type="text" name="phone" id="phone">
		</div>
		<div class="left_price">
			<span class="price">Итого</span>
		</div>
		<div class="right_price">
			<span class="summ">
				<span class="summ_nb"><?=$this->vars['price']?></span>
				<span class="summ_con">руб.</span>
			</span>
		</div>
		<div class="submit">
			<input type="submit" value="Заказать">
		</div>
		</form>
	</div>
