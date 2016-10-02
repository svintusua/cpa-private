<style>
#block,.caption {
	width: 80%;
}
</style>
<div id="content">
	<div class="caption"><h1><a class="come_back" onclick="history.back();return false;">Назад</a><?=$this->vars['title']?></h1>
		<div class="select_status">
				<select name="status">
					<?=$this->vars['status']?>
				</select>				
			</div>
	</div>
	<div id="block">
		<div class="block_left">
			<div class="row">
				<span class="date"><?=date('d.m.Y');?></span>
			</div>
			<div class="row">
				<input type="text" name="middle_name" placeholder="Фамилия*"><span class="dop_button" data-historyby="middle_name">история</span>
			</div>
			<div class="row">
				<input type="text" name="first_name" placeholder="Имя*">
			</div>
			<div class="row">
				<input type="text" name="last_name" placeholder="Отчество*">
			</div>
			<div class="row">
				<input type="text" name="phone" class="for_info_data_phone" placeholder="Телефон*" style="box-shadow: none;"><span class="dop_button" data-historyby="phone">история</span>		<span class="dop_button" data-historyby="add_phone" data-show="show">добавить еще</span>			
				<div id="extension_phone" >
					<label>Добавить номер <input type="text" id="e_phone" class="for_info_data_phone" placeholder="Номер телефона"></label>
					<ul>
					</ul>
				</div>			
			</div>
			<div class="row">
				<input type="text" id="operator" value="Оператор:" disabled>
			</div>
			<div class="row">
				<input type="text" id="state" value="Регион:" disabled>
			</div>
			<div class="row">
				<input type="ip" name="ip" disabled value="<?=$this->vars['ip']?>"><span class="dop_button" data-historyby="ip">история</span>
			</div>
			<div class="row">
				<a modal="goodstable"><span id="addgoods" class="send_order">добавить товар</span></a>
				<div id="goods_table">
					<select id="select_goods" name="goods[]" multiple style="display: none;"></select>					
					<table>
						<tr>
							<th>название</th>
							<th>артикул</th>
							<th>цена(шт.)</th>
							<th>количество</th>				
							<th>общая цена</th>				
						</tr>
						<?=$this->vars['goods_table']?>
					</table>					
				</div>
				<div class="dop">
					<div class="block_left">
						<span>Скидка на весь заказ :</span>
						<label style="display: block;"><input type="text" style="width: 45px;" value="0" name="sale_s" data-sale_type="1"> %</label>
						<label style="display: block;"><input type="text" style="width: 45px;" value="0" name="sale_f" data-sale_type="2"> руб.</label>	
					</div>
					<div class="block_right" style="text-align: right;">
						<label style="display: block;"><input type="checkbox" name="delivery" checked> + доставка (350р.)</label>
						<span style="display:block;">Скидка на заказ: <span id="sele_order">0</span></span>
						<span style="display:block;">Итого: <span id="all_price">0</span></span>
					</div>
					
								
				</div>
			</div>
		</div>
		<div class="block_right">
			<div class="row">
				<span class="des">id оффера</span>
				<select name="offer_id">
					<?=$this->vars['offers']?>
				</select>
			</div>
			<div class="row">
				<input type="text" value="Код сотрудника: <?=$this->vars['user_id']?>;" disabled><span class="dop_button" data-historyby="call">история звонков</span>
			</div>
			<div class="row">
				<span class="btn"></span>
			</div>
			<div class="row">
				<select name="otpravitel">
					<option selected disabled>Магазин</option>
					<option value="1">Свестов</option>
					<option value="2">Николаенко</option>
					<option value="3">Галиуллин</option>
				</select>
			</div>
			<div class="row">
				<input type="text" name="track_number" placeholder="Трек номер" value="<?=$this->vars['info_order']['track_number']?>"><span class="dop_button" data-historyby="track_number">узнать информацию</span>
			</div>
			<!--<div class="row">
				<input type="text" name="search" placeholder="Введите город, улицу, дом, квартиру">
			</div>-->
			<div class="row">
				<input type="text" name="country" placeholder="Страна" value="<?=$this->vars['country']?>">
			</div>
			<div class="row" style="display: none;">
				<input type="text" name="state" placeholder="Регион" value="<?=$this->vars['region']?>">
			</div>
			<div class="row">
				<input type="text" class="kladr" name="city" placeholder="Населенный пункт" value="<? //$this->vars['city']?>">
				<ul id="select_city"></ul>
			</div>
			<div class="row">
				<input type="text" class="small kladr" name="street" placeholder="Улица">
				<input type="text" class="small kladr" name="house" placeholder="Дом">
				<input type="text" class="small" name="flat" placeholder="Квартира">
				<span class="dop_button" data-historyby="address">история</span>
			</div>
			<div class="row">
				<input type="text" name="index" placeholder="Индекс"><span class="dop_button" data-historyby="post_office">карта</span>
			</div>	
			<div class="row">
				<textarea name="comment" placeholder="Комментарий"></textarea>
			</div>				
			<!--<div class="row">
				<div class="b kurer">
					<label><input type="radio" class="t_d" value="kurer"> Курьер</label>					
				</div>
				<div class="b prf">
					<label><input type="radio" class="t_d" value="prf"> Почта РФ</label>
					<div class="h_p">
						<label><input type="radio" class="h_pt_d" value="ur"> Юр. лицо</label>
							
							<div class="h ur">
								<span class="ur_lic">Партионная почта</span>							
							</div>
						<label><input type="radio" class="h_pt_d" value="fiz"> Физ. лицо</label>
							<div class="h fiz">
								<?=$this->vars['senders_blocks']?>
												
							</div>
					</div>
				</div>
				<div class="b sdek">
					<label><input type="radio" class="t_d" value="sdek"> СДЕК</label>
					<div class="h_p">
						<label><input type="radio" class="h_pt_d" value="c-c"> Склад-склад</label>
						<label><input type="radio" class="h_pt_d" value="c-d"> Склад-дверь</label>
						<label><input type="radio" class="h_pt_d" value="d-c"> Дверь-склад</label>
						<label><input type="radio" class="h_pt_d" value="d-d"> Дверь-дверь</label>

					</div>
				</div>
				<span class="d_b" data-action="rasch">Расчитать заказ</span>
				<span class="d_b" data-action="rasch">Распечатать</span>
			</div>
			<div class="row">	
				<span class="d_b" data-action="show_div_sms_text" data-show="show">тексты смс</span>
				<div class="div_sms_text">
					<div class="sms_form">
						<input type="hidden" name="partner_id" value="<?=$this->vars['partner_id']?>">
						<span>Текс сообщения отправки:</span>
						<textarea class="sms_message" data-type="1"><?=$this->vars['message_1']?></textarea>
						<span>Текс сообщения доставки:</span>
						<textarea class="sms_message" data-type="2"><?=$this->vars['message_2']?></textarea>
						<span>Текс сообщения подарка:</span>
						<textarea class="sms_message" data-type="3"><?=$this->vars['message_3']?></textarea>
						<span>Текс сообщения гарантии выкупа:</span>
						<textarea class="sms_message" data-type="4"><?=$this->vars['message_4']?></textarea>
						<span>Текс сообщения коллектора1:</span>
						<textarea class="sms_message" data-type="5"><?=$this->vars['message_5']?></textarea>
						<span>Текс сообщения коллектора2:</span>
						<textarea class="sms_message" data-type="6"><?=$this->vars['message_6']?></textarea>
						<span>Текс сообщения кредитная история:</span>
						<textarea class="sms_message" data-type="7"><?=$this->vars['message_7']?></textarea>
						
					</div>
				</div>
				<select name="type_sms">
					<option value="1">Отправка</option>
					<option value="2">Доставка</option>
					<option value="3">Подарок</option>
					<option value="4">Гарантия выкупа</option>
					<option value="5">Коллектор1</option>
					<option value="6">Коллектор2</option>
					<option value="7">Кредитная история</option>
				</select>
				<span class="d_b" data-action="sms_send">отправит смс</span>
			</div>-->
		</div>
		<div class="center">
			<span id="update_add_info" class="send_order">добавить</span>
		</div>
	</div>
</div>
<div id="goodstable" class="modal" style="display: none; ;z-index: 99999;background: rgba(0,0,0,0.9);">
		<div class="modal-block modal-top modal-left" style="margin-top: -103px; margin-left: -299px;">
			<div class="icon-close"></div>
			<div class="content">
				<?=$this->vars['goods']?>
			</div>
		</div>
</div>