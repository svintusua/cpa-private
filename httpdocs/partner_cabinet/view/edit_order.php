<style>
#block,.caption {
	width: 80%;
}
</style>
<div id="content">
	<div class="caption"><h1><a class="come_back" onclick="history.back();return false;">Назад</a><?=$this->vars['title']?></h1>
		<div class="select_status">
				<select name="status">
					<?=$this->vars['info_order']['status']?>
				</select>				
			</div>
	</div>
	<div id="block">
		<div class="block_left">
			<div class="row">				
				<span class="order_id">t_<span id="oid"><?=$this->vars['info_order']['order_id']?></span> <i>(№ оффера: <span class="offer_id"><?=$this->vars['info_order']['offer_id']?></span>)</i></span>
				
				<span class="date"><?=$this->vars['info_order']['date']?> (<?=$this->vars['time']?>)</span>
			</div>
			<div class="row">
				<input type="text" name="middle_name" value="<?=$this->vars['info_order']['middle_name']?>" placeholder="Фамилия*"><span class="dop_button" data-historyby="middle_name">история (<?=$this->vars['count_m_name']?>)</span>
			</div>
			<div class="row">
				<input type="text" name="first_name" value="<?=$this->vars['info_order']['first_name']?>" placeholder="Имя*">
			</div>
			<div class="row">
				<input type="text" name="last_name" value="<?=$this->vars['info_order']['last_name']?>" placeholder="Отчество*">
			</div>
			<div class="row">
				<input type="text" name="phone" class="for_info_data_phone" placeholder="Телефон*" value="<?=$this->vars['info_order']['phone']?>" style="box-shadow: none;"><span class="dop_button" data-historyby="phone">история (<?=$this->vars['count_phone']?>)</span>	<span class="dop_button" data-historyby="add_phone" data-show="show">добавить еще</span>			
				<div id="extension_phone" style="display:<?=$this->vars['s']?>">
					<span id="ad_ph">Добавить номер<!--<input type="text" id="e_phone" class="for_info_data_phone" placeholder="Номер телефона">--></span>
					
						<?=$this->vars['e_phone']?>
					
				</div>
			</div>
			<div class="row">
				<input type="text" id="operator" value="Оператор: <?=$this->vars['info_order']['phone_operator']?>" disabled>
			</div>
			<div class="row">
				<input type="text" id="state" value="Регион: <?=$this->vars['info_order']['phone_state']?>" disabled>
			</div>
			<!--<div class="row">
				<p>Оператор: <span id="operator"><?=$this->vars['info_order']['phone_operator']?></span></p>
				<p>Регион: <span id="state"><?=$this->vars['info_order']['phone_state']?></span></p>
			</div>-->
			<div class="row">
				<input type="ip" name="ip" disabled value="<?=$this->vars['info_order']['ip']?>"><span class="dop_button" data-historyby="ip">история (<?=$this->vars['count_ip']?>)</span>
			</div>
			<div class="row">
				<a modal="goodstable"><span id="addgoods" class="send_order">добавить товар</span></a>
				<div id="goods_table">
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
						<? if($this->vars['info_order']['sale_type'] == 1){?>
							<label style="display: block;"><input type="text" style="width: 45px;" name="sale_s" data-sale_type="1" value="<?=$this->vars['info_order']['sale']?>"> %</label>
							<label style="display: block;"><input type="text" style="width: 45px;" value="0" name="sale_f" data-sale_type="2"> руб.</label>				
						<?}else if($this->vars['info_order']['sale_type'] == 1){?>
							<label style="display: block;"><input type="text" style="width: 45px;" value="0" name="sale_s" data-sale_type="1"> %</label>
							<label style="display: block;"><input type="text" style="width: 45px;" name="sale_f" data-sale_type="2" value="<?=$this->vars['info_order']['sale']?>"> руб.</label>				
						<?}else{?>
							<label style="display: block;"><input type="text" style="width: 45px;" value="0" name="sale_s" data-sale_type="1"> %</label>
							<label style="display: block;"><input type="text" style="width: 45px;" value="0" name="sale_f" data-sale_type="2"> руб.</label>				
						<?}?>
					</div>
					<div class="block_right" style="text-align: right;">
						<label style="display: block;"><input type="checkbox" name="delivery" <?=$this->vars['info_order']['delivery']?>> + доставка (350р.)</label>
						<span style="display:block;">Скидка на заказ: <span id="sele_order"><?=$this->vars['info_order']['sale_sum']?></span></span>
						<span style="display:block;">Итого: <span id="all_price"><?=$this->vars['all_price']?></span></span>
					</div>
					
								
				</div>				
				
			</div>
		</div>
		<div class="block_right">
			<div class="row">
				
			</div>
			<div class="row">
				<input type="text" value="Код сотрудника: <?=$this->vars['user_id']?>;" disabled><span class="dop_button" data-historyby="call">история звонков</span>
			</div>
			<div class="row">
				<span class="btn"></span>
			</div>
			<div class="row">
				<select name="otpravitel">
					<option selected disabled>Отправитель</option>
					<option>1</option>
					<option>2</option>
					<option>3</option>
				</select>
			</div>
			<div class="row">
				<input type="text" name="track_number" placeholder="Трек номер" value="<?=$this->vars['info_order']['track_number']?>"><span class="dop_button" data-historyby="track_number">узнать информацию</span>
			</div>
			<div class="row" style="display: none;">
				<input type="text" name="country" value="<?=$this->vars['info_order']['country']?>" placeholder="Страна">
			</div>
			<div class="row" style="display: none;">
				<input type="text" name="state" value="<? //$this->vars['info_order']['state']?>" placeholder="Регион">
			</div>
			<div class="row">
				<input type="text" class="kladr" name="city" value="<?=$this->vars['info_order']['city']?>" placeholder="Населенный пункт">
				<ul id="select_city"></ul>
			</div>
			<div class="tooltip" style="display: none;"><b></b><span></span></div>
			<div class="row">
				<input type="text" name="street" class="small kladr" placeholder="Улица" value="<?=$this->vars['info_order']['street']?>">
				<input type="text" name="house" class="small kladr" placeholder="Дом" value="<?=$this->vars['info_order']['house']?>">
				<input type="text" name="flat" class="small" placeholder="Квартира" value="<?=$this->vars['info_order']['flat']==0?'': $this->vars['info_order']['flat']?>">
				<span class="dop_button" data-historyby="address">история</span>
			</div>
			<div class="row">
				<input type="text" name="index" placeholder="Индекс" value="<?=$this->vars['info_order']['index']?>" ><span class="dop_button" data-historyby="post_office">карта</span>
			</div>
			<div class="row">
				<textarea name="comment" placeholder="Комментарий"><?=$this->vars['info_order']['comment']?></textarea>
			</div>
			<div class="row">
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
								<!--<span class="fiz_lic">Жуков
									<div>
										<span class="postmail" data-blank="f7" data-from="Жуков" data-order_id="<?=$this->vars['info_order']['order_id']?>">ф.7</span>
										<span class="postmail" data-blank="f112" data-from="Жуков" data-order_id="<?=$this->vars['info_order']['order_id']?>">112 ЭП</span>
										<span class="postmail" data-blank="2f" data-from="Жуков" data-order_id="<?=$this->vars['info_order']['order_id']?>">оба</span>
									</div>
								</span>
								<span class="fiz_lic">Логвинов
									<div>
										<span class="postmail" data-blank="f7" data-from="Логвинов" data-order_id="<?=$this->vars['info_order']['order_id']?>">ф.7</span>
										<span class="postmail" data-blank="f112" data-from="Логвинов" data-order_id="<?=$this->vars['info_order']['order_id']?>">112 ЭП</span>
										<span class="postmail" data-blank="2f" data-from="Логвинов" data-order_id="<?=$this->vars['info_order']['order_id']?>">оба</span>
									</div>
								</span>
								<span class="fiz_lic">Злотников
									<div>
										<span class="postmail" data-blank="f7" data-from="Злотников" data-order_id="<?=$this->vars['info_order']['order_id']?>">ф.7</span>
										<span class="postmail" data-blank="f112" data-from="Злотников" data-order_id="<?=$this->vars['info_order']['order_id']?>">112 ЭП</span>
										<span class="postmail" data-blank="2f" data-from="Злотников" data-order_id="<?=$this->vars['info_order']['order_id']?>">оба</span>
									</div>
								</span>	-->							
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
			</div>
			
		</div>
		<div class="center">
			<span id="update_add_info" class="send_order">сохранить</span>
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