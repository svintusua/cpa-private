<div class="body">
	<div class="image">
		<img src="../img/offer_logo/<?=$this->vars['info']['logo']?>" alt="Картнка">
	</div>
	<div class="info_1">
		<h2><?=$this->vars['info']['name']?></h2>
		<ul class="info_1_links">
			<li>Гео: <?=$this->vars['info']['l_price']?></li>			
			<li>Цена: <?=$this->vars['info']['price']?></li>
			<li>Выплаты: <?=$this->vars['info']['payments']?></li>
		</ul>		
	</div>
	<div class="see_about">
		<h2 class="about">Описание</h2>
		<p><?=$this->vars['info']['description']?></p>
	</div>
	<div class="land">
		<h2>Лендинги</h2>
		<ol>
			<?=$this->vars['info']['land']?>
		</ol>
	</div>
	<div class="land">
	 <h2>Прелендинги</h2>
		<ol>
			<?=$this->vars['info']['pre_land']?>
		</ol>
	</div>
	<div class="land">
	 <h2>Рабочая ссылка</h2>
		<input type="text" readonly name="work_link" value="<?=$this->vars['info']['link']?>">
		<hr>
		<input type="text" class="min_inp" name="subid1" placeholder="SubId1">
		<input type="text" class="min_inp" name="subid2" placeholder="SubId2">
		<input type="text" class="min_inp" name="subid3" placeholder="SubId3">
		<span class="upd_link btn_view">Обновить ссылку</span>
	</div>
	<div class="bot_btn">
		<a data-action="connective">Связка</a>
		<a data-action="postback">POSTBACK</a>
		<a data-action="retargeting">РЕТАРГЕТИНГ</a>
		<a data-action="iframe">IFRAME</a>
		<a data-action="tb">ссылка ТБ</a>
		<a data-action="upd_link_l">Изменить ссылку</a>
		<a data-action="us_links">Ссылки</a>
	</div>
	<!--us_links-->
	<div class="perem us_links">
		<table>
			<tr><th>ID ленда</th><th>ID преленда</th><th>Subid1</th><th>Subid2</th><th>Subid3</th><th>Ссылка</th></tr>
			<?=$this->vars['info']['lin']?>
		</table>		
	</div>
	<!--upd link-->
	<div class="perem upd_link_l">
		<span>ссылка для изменения: <select class="l_f_upd"><?=$this->vars['info']['links']?></select></span>
		<ol class="lands">
			<?=$this->vars['info']['land2']?>
			<a id="upd_link_l" class="btn_view" style="cursor: pointer;">изменить ссылку</a>
		</ol>		
	</div>
	<!--Iframe-->
	<div class="perem tb">
		<label>ссыдка для ТБ: <input type="text" id="tb_link" value="<?=$this->vars['info']['tb_link']?>"></label> <a id="create_tb_link" class="btn_view" style="cursor: pointer;">добавить/изменить ссылку</a>
	</div>
	<div class="perem iframe">
		<p>ссыдка для iframe: <input type="text" id="iframe_link" readonly value="<?=$this->vars['info']['iframe_link']?>"></p>
	</div>
	<!-- Постбек-->
	<div class="perem postback">
		<input type="text" name="link_top" id="offer_link_top" placeholder="Ваша ссылка" value="<?=$this->vars['link']?>">
		<table class="see_offers_table_1">
			<tr>
				<th class="offer_th"></th>
				<th class="offer_th">Значение переменной</th>
				<th class="offer_th">Название переменной</th>
			</tr>
			<tr>
				<td class="offer_td"><input type="checkbox" data-macros="{offer}" class="td_checkbox"></td>
				<td class="offer_td">Название оффера</td>
				<td class="offer_td inpt"><input type="text" name="offer" value="offer"></td>
			</tr>
			<tr>
				<td class="offer_td"><input type="checkbox" data-macros="{campaign_id}"></td>
				<td class="offer_td">ID оффера</td>
				<td class="offer_td"><input type="text" name="campaign_id" value="campaign_id"></td>
			</tr>
			<tr>
				<td class="offer_td"><input type="checkbox" data-macros="{subid1}"></td>
				<td class="offer_td">Субаккаунт1</td>
				<td class="offer_td inpt"><input type="text" name="subid1" value="subid1"></td>
			</tr>
			<tr>
				<td class="offer_td"><input type="checkbox" data-macros="{subid2}"></td>
				<td class="offer_td">Субаккаунт2</td>
				<td class="offer_td inpt"><input type="text" name="subid2" value="subid2"></td>
			</tr>
			<tr>
				<td class="offer_td"><input type="checkbox" data-macros="{subid3}"></td>
				<td class="offer_td">Субаккаунт3</td>
				<td class="offer_td inpt"><input type="text" name="subid3" value="subid3"></td>
			</tr>
			<tr>
				<td class="offer_td"><input type="checkbox" data-macros="{click_id}"></td>
				<td class="offer_td">ID клика</td>
				<td class="offer_td inpt"><input type="text" name="click_id" value="click_id"></td>
			</tr>
			<tr>
				<td class="offer_td"><input type="checkbox" data-macros="{currency}"></td>
				<td class="offer_td">Валюта оплаты</td>
				<td class="offer_td inpt"><input type="text" name="currency" value="currency"></td>
			</tr>
			<tr>
				<td class="offer_td"><input type="checkbox" data-macros="{sum}"></td>
				<td class="offer_td">Стоимость лида</td>
				<td class="offer_td inpt"><input type="text" name="sum" value="sum"></td>
			</tr>
			<tr>
				<td class="offer_td"><input type="checkbox" data-macros="{status}"></td>
				<td class="offer_td">Статус лида</td>
				<td class="offer_td inpt"><input type="text" name="status" value="status"></td>
			</tr>
			<tr>
				<td class="offer_td"><input type="checkbox" data-macros="{lead_id}"></td>
				<td class="offer_td">ID лида</td>
				<td class="offer_td inpt"><input type="text" name="lead_id" value="lead_id"></td>
			</tr>
		</table>
		<table class="see_offers_table_2">
			<tr>
				<th class="offer_th"></th>
				<th class="offer_th">Офферы</th>
			<tr>
			<tr>
				<td class="offer_td"><input type="checkbox" class="for_offer" value="global" checked ></td>
				<td class="offer_td">Глобальный постбек</td>
			<tr>
			<tr>
				<td class="offer_td"><input type="checkbox" class="for_offer" value="<?=$_GET['offer_id']?>"></td>
				<td class="offer_td">Постбек для данного оффера</td>
			<tr>
		</table>
		<label for="offer_link">Итоговая ссылка</label>
		<input type="text" name="link" id="offer_link" readonly value="<?=$this->vars['postback']?>">
		<input type="submit" name="save" id="offer_save" value="СОХРАНИТЬ">
		<input type="submit" name="clear" id="offer_clear" value="СБРОСИТЬ">
		<br>
		<label>Отправлять postback при статусах</label>
		<input type="checkbox" id="chek1_offer" checked>
		<label for="chek1_offer">Новый лид</label>
		<input type="checkbox" id="chek2_offer">
		<label for="chek2_offer">Подтвержден</label>
		<input type="checkbox" id="chek3_offer">
		<label for="chek3_offer">Отклонен</label>
</div>
<!--Связка-->
<div class="perem connective">
	<div class="have_connective">
	<span>Имеющиеся связки</span>
	<ol>
		<?=$this->vars['info']['preland_links']?>
	</ol>
	<input type="text" name="connective_link" id="connective_link" readonly placeholder="Ссылка связки">
	<div>
		<div class="land landing">
			<span>Выберите лендинг</span>
			<?=$this->vars['info']['for_select_land']?>
		</div>
		<div class="land prelanding">
			<span>Выберите прелендинг</span>
			<?=$this->vars['info']['for_select_pre_land']?>
		</div>
		<div class="land">
			<div>
				<label>
					<span>Название связки</span>
					<input type="text" name="name_connective_link" >
				</label>
				<a id="create_connective_link" style="position: relative;top: 15px;">Создать связку</a>
			</div>
		</div>
	</div>
</div>
</div>
<!--Ретаргентинг-->
<div class="perem retargeting">
	<div class="have_connective">
	<span>РЕТАРГЕТИНГ</span>
	<form id="retargeting" method="POST">
		<select name="land_id" id="metrica_sel">
		<option disabled selected>Выберите лендинг</option>
			<?=$this->vars['info']['lando'];?>
		</select><br>
		<!--<input name="offer_id" type="hidden" value="<?=$_GET['offer_id']?>">-->
		<label>
			<span>Yandex.Metrika</span>
			<input name="ym" type="text" value="<?=$this->vars['info']['ret']['ym']?>">
		</label><br>
		<label>
			<span>Rating@Mail.ru</span>
			<input name="rm" type="text" value="<?=$this->vars['info']['ret']['rm']?>">
		</label><br>
		<label>
			<span>VK.com</span>
			<input name="vk" type="text" value="<?=$this->vars['info']['ret']['vk']?>">
		</label><br>
		<input type="submit" class="btn_view" value="сохранить">
	</form>
</div>
</div>
