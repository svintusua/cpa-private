<div class="prof_body">
		<form class="prof_data" method="POST" id="us_info">
			<h2>Персональные данные</h2>
			<label for="prof_name"><p>Имя </p><input id="prof_name" name="name" value="<?=$this->vars['profil']['name']?>"></label>
			<label for="prof_sname"><p>Фамилия </p><input id="prof_sname" name="lastname" value="<?=$this->vars['profil']['lastname']?>"></label>
			<label for="prof_skype"><p>Skype </p><input id="prof_skype" name="skype" value="<?=$this->vars['profil']['skype']?>"></label>
			<!--<label for="prof_phone"><p>Номер телефона </p><input type="tel" id="prof_phone"></label>-->
			<!--<label for="prof_link"><p>Ссылка для ТБ </p><input type="url" id="prof_link"></label>-->
			<label for="prof_about"><p>О себе </p><input type="text" name="about" id="prof_about" value="<?=$this->vars['profil']['about']?>"></label>
			<input type="submit" value="ПРИМЕНИТЬ" class="prof_btn">
		</form>
		<!--<form class="prof_pay">
			<h2>Платежная информация</h2>
			<label for="prof_qiwi"><p>QIWI </p><input id="prof_qiwi" value="<?=$this->vars['profil']['wallet'][1]?>"></label>
			<label for="prof_wmr"><p>WMR </p><input id="prof_wmr" value="<?=$this->vars['profil']['wallet'][2]?>"></label>
			<label for="prof_wmz"><p>WMZ </p><input id="prof_wmz" value="<?=$this->vars['profil']['wallet'][3]?>"></label>
			<label for="prof_yam"><p>Яндекс деньги </p><input id="prof_yam" value="<?=$this->vars['profil']['wallet'][4]?>"></label>
		</form>-->
		
	</div>