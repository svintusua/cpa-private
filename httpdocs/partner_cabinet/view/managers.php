<style>
.row{
	padding: 5px;
}
#block{
	letter-spacing: 0;
}
#manager_del {
    bottom: 0;
    display: inline-block;
    left: 0;
    margin-left: 10px;
    position: relative;
    vertical-align: top;
}
</style>
<div id="content">
	<div class="caption"><h1><?=$this->vars['title']?></h1></div>
	<div id="block">
		<div class="row">
			<select name="manager">
				<?=$this->vars['managers']?>
			</select>
			<span id="manager_del" class="send_order">Удалить менеджера</span>
		</div>
		<hr>
		<form method="POST" id="add_manager">
		<div class="block_left">
			<input type="hidden" name="partner_id" value="<?=$this->vars['partner_id']?>" required>
			<div class="row">
				<input type="email" name="email" placeholder="Email *" required autocomplete="off">
			</div>
			<div class="row">
				<input type="text" name="surname" placeholder="Фамилия *" required>
			</div>
			<div class="row">
				<input type="text" name="name" placeholder="Имя *" required>
			</div>			
			<div class="row">
				<input type="text" name="lastname" placeholder="Отчество *" required>
			</div>
			<div class="row">
				<input type="submit" value="добавить менеджера" style="cursor: pointer;">
			</div>
		</div>
		<div class="block_right">
			<span></span>
			<div class="row">
				<input class="phonefield" type="text" style="box-shadow: none;" placeholder="Телефон *" name="tel" required>
			</div>
			<div class="row">
				<textarea placeholder="О менеджере *" name="about" required></textarea>
			</div>
			
		</div>
		
		</form>
	</div>
</div>
	