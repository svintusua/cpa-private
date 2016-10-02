	<div id="send_order" class="modal" style="display: none;">
		<div class="modal-block modal-top modal-left" style="border-radius: 15px 15px 10px 10px; margin-top: -103px; margin-left: -299px;">
			<div class="icon-close"></div>
			<div class="title" style="border-radius: 10px 10px 0px 0px;"><h1>Добавить заказ</h1></div>
			<div class="content">
				<form method="post" id="send_order_form">
						<select name="offer_id" required>
							<?=$this->vars['for_form']?>
						</select>
						<select name="goods_id" disabled required>
							<option>Товар*<option>
						</select>
						<input type="text" name="fio" placeholder="ФИО*" required>						
						<input type="text" name="phone" class="phonefield" placeholder="Телефон*" required>
						<input type="submit" value="добавить">
					</form>
			</div>
		</div>
	</div>
	<div id="information" class="modal" style="display: none; ;z-index: 99999;background: rgba(0,0,0,0.9);">
		<div class="modal-block modal-top modal-left" style="border-radius: 15px 15px 10px 10px; margin-top: -103px; margin-left: -299px;">
			<div class="icon-close"></div>
			<div class="content">
				<p></p>
			</div>
		</div>
	</div>
	<div id="history" class="modal" style="display: none; ;z-index: 99999;background: rgba(0,0,0,0.9);">
		<div class="modal-block modal-top modal-left" style="border-radius: 15px 15px 10px 10px; margin-top: -103px; margin-left: -299px;">
			<div class="icon-close"></div>
			<div class="content">
				
			</div>
		</div>
	</div>
	<div id="order_action">
		<p>Выбранных заказов: <span>0</span></p>
		<div id="div_action">
			<span class="a" data-action="show">Действие</span>
			<div class="h_d">
				<ul>
					<? 	$url = array();
						$url = explode('/',$_SERVER['REQUEST_URI']);
						if(array_pop($url) == 'warehouse'){
					?>
						<li><span class="btn_order_action" data-action="delete">Удалить</span></li>
					<?
						}else{
					?>
					<!--<li><span class="btn_order_action" data-action="delete">Удалить</span></li>-->			
					
					<li class="show_div"><span class="btn_order_action">Выгрузка</span>
						<div class="right_block">
							<div class="e_div">
								<p>Поля:</p>
								<label><input type="checkbox" name="date"> Дата и время заказа</label>
								<label><input type="checkbox" name="fio"> ФИО</label>
								<label><input type="checkbox" name="phone_number"> Номер телефона</label>
								<label><input type="checkbox" name="address"> Адрес</label>
								<label><input type="checkbox" name="delivery_type"> Тип доставки</label>
								<label><input type="checkbox" name="zip"> Индекс</label>
								<label><input type="checkbox" name="sum"> Сумма</label>
								<label><input type="checkbox" name="wm"> Код вебмастера</label>
								<label><input type="checkbox" name="time_delydery"> Время доставки</label>
								<p>За период:</p>
								<input type="text" name="date_s" class="datepicker" >
								<span> - </span>
								<input type="text" name="date_e" class="datepicker" >	
								<label>Формат:
								<select name="format">
										<option value="exel">Exel</option>
										<option value="pdf" disabled>PDF</option>							
									</select>
								</label>
								<p class="export" data-from="action_block">Выгрузить</p>
							</div>
						</div>					
					</li>

					<li class="show_div"><span class="btn_order_action">Почта России</span>
						<div class="right_block">
							<ul>
								<li class="show_div"><span>физ.лицо</span>
									<div class="right_block">
										<?=$this->vars['senders_blocks']?>
										<!--<div>											
											<ul>
												<li class="show_div"><span>Жуков</span>
													<div class="right_block">
														<div class="postmail" data-blank="f7" data-from="Жуков">ф.7</div>
														<div class="postmail" data-blank="f112" data-from="Жуков">112 ЭП</div>
														<div class="postmail" data-blank="2f" data-from="Жуков">оба</div>												
													</div>
												</li>
											</ul>
										</div>
										<div>											
											<ul>
												<li class="show_div"><span>Логвинов</span>
													<div class="right_block">
														<div class="postmail" data-blank="f7" data-from="Логвинов">ф.7</div>
														<div class="postmail" data-blank="f112" data-from="Логвинов">112 ЭП</div>
														<div class="postmail" data-blank="2f" data-from="Логвинов">оба</div>												
													</div>
												</li>
											</ul>
										</div>
										<div>											
											<ul>
												<li class="show_div"><span>Злотников</span>
													<div class="right_block">
														<div class="postmail" data-blank="f7" data-from="Злотников">ф.7</div>
														<div class="postmail" data-blank="f112" data-from="Злотников">112 ЭП</div>
														<div class="postmail" data-blank="2f" data-from="Злотников">оба</div>												
													</div>
												</li>
											</ul>
										</div>-->
									</div>
								</li class="show_div">
								<li class="show_div"><span>юр.лицо</span>
									<div class="right_block">
										<div class="postmail">Партионная почта</div>
									</div>
								</li>
							</ul>
						</div>
					</li>
					
					<li class="show_div"><span class="btn_order_action">Сдэк</span>
						<div class="right_block">
							<div class="postmail">накладная сдэк</div>
						</div>
					</li>
					
					<li class="show_div"><span class="btn_order_action">Сменить статус</span>
						<div class="right_block">
							<div class="status_block">
								<!--<div class="close"></div><div class="gruop_status_1" data-value="new">Новый</div><div class="gruop_status_1" data-value="call">Звонок с сайта</div><div class="gruop_status_1" data-value="new_frod">Новый подозрение на фрод</div><div class="gruop_status_2" data-value="adopted">Принят</div><div class="gruop_status_2" data-value="call_back">Перезвонить</div><div class="gruop_status_2" data-value="pre_payment">Ждем предоплату</div><div class="gruop_status_2" data-value="coordinated">На согласовании</div><div class="gruop_status_3" data-value="courier">Курьер</div><div class="gruop_status_3" data-value="completed">Комплектуется</div><div class="gruop_status_3" data-value="equipped">Укомплектован</div><div class="gruop_status_3" data-value="awaiting_submission">Ожидает отправки</div><div class="gruop_status_3" data-value="awaiting_submission_cc">Ожидает отправки КЦ</div><div class="gruop_status_3" data-value="pending">Отложено</div><div class="gruop_status_4" data-value="sent">Отправлен</div><div class="gruop_status_4" data-value="delivered">Доставлен</div><div class="gruop_status_4" data-value="collector">Коллектор</div><div class="gruop_status_5" data-value="made">Выполнен</div><div class="gruop_status_5" data-value="presentation">Вручение</div><div class="gruop_status_5" data-value="payed">Оплачено</div><div class="gruop_status_5" data-value="return">Возврат</div><div class="gruop_status_5" data-value="compensation">Компенсация</div><div class="gruop_status_6" data-value="call_not">Недозвон</div><div class="gruop_status_6" data-value="double_unconfirmed">Не подтвержден дважды</div><div class="gruop_status_6" data-value="repeal">Отмена</div><div class="gruop_status_6" data-value="curiosities_double">Неформат/дубль</div><div class="gruop_status_6" data-value="not_satisfied">Не устроила клиента</div><div class="gruop_status_6" data-value="claims">Претензии</div>-->
							

							<!--	<div class="close"></div><div class="gruop_status_1" data-value="new">Новый</div><div class="gruop_status_1" data-value="call">Звонок с сайта</div><div class="gruop_status_1" data-value="new_frod">Новый подозрение на фрод</div><div class="gruop_status_2" data-value="adopted">Принят</div><div class="gruop_status_2" data-value="call_back">Перезвонить</div><div class="gruop_status_2" data-value="pre_payment">Ждем предоплату</div><div class="gruop_status_2" data-value="coordinated">На согласовании</div>
								<div class="gruop_status_3" data-value="send_mail">Отправка почта</div><div class="gruop_status_3" data-value="send_kur">Отправка курьер</div><div class="gruop_status_3" data-value="deferred">Отложено</div>
								<div class="gruop_status_4" data-value="sent">Отправлен</div><div class="gruop_status_4" data-value="delivered">Доставлен</div><div class="gruop_status_4" data-value="payed_date">Выкупит в определенную дату</div>
								<div class="gruop_status_5" data-value="presentation">Вручено</div><div class="gruop_status_5" data-value="payed">Оплачено</div><div class="gruop_status_5" data-value="return">Возврат</div><div class="gruop_status_5" data-value="return_get">Возврат получен</div><div class="gruop_status_6" data-value="call_not">Недозвон</div><div class="gruop_status_6" data-value="double_unconfirmed">Не подтвержден дважды</div><div class="gruop_status_6" data-value="repeal">Отмена</div><div class="gruop_status_6" data-value="curiosities_double">Неформат/дубль</div><div class="gruop_status_6" data-value="not_satisfied">Не устроила клиента</div><div class="gruop_status_6" data-value="claims">Претензии</div>-->
								<div class="close"></div>
								<div class="gruop_status_1" data-value="new">Новый</div>
								<div class="gruop_status_1" data-value="new_hot">Новый горячий</div>
								<div class="gruop_status_1" data-value="new_cold">Новый холодный</div>
								<div class="gruop_status_1" data-value="exact_time">Точное время</div>
								<div class="gruop_status_2" data-value="prepayment">Предоплата</div>
								<div class="gruop_status_2" data-value="spb_courier">Спб курьер</div>
								<div class="gruop_status_2" data-value="pending">Отложено</div>
								<div class="gruop_status_2" data-value="on_check">На проверку</div>
								<div class="gruop_status_2" data-value="confirmed">Подтвержден</div>
								<div class="gruop_status_3" data-value="on_sending">На отправку</div>
								<div class="gruop_status_3" data-value="equipped">Укомплектовано</div>
								<div class="gruop_status_4" data-value="sent">Отправлено</div>
								<div class="gruop_status_4" data-value="delivered">Доставлено</div>
								<div class="gruop_status_4" data-value="awarded">Вручено</div>
								<div class="gruop_status_5" data-value="money_received">Деньги получены</div>
								<div class="gruop_status_6" data-value="claims">Претензии</div>
								<div class="gruop_status_6" data-value="autofac">Автофейк</div>
								<div class="gruop_status_6" data-value="cancelled_failure">Отменен (отказ)</div>
								<div class="gruop_status_6" data-value="call_not">Недозвон</div>
								<div class="gruop_status_6" data-value="cancelled_after_confirmation">Отменен после подтверждения</div>
								<div class="gruop_status_6" data-value="frod_proven">Фрод проверенный</div>
								<div class="gruop_status_7" data-value="return">Возврат</div>
								<div class="gruop_status_7" data-value="return_received">Возврат получен</div>
							</div>
						</div>
					</li>
					
					<li class="show_div"><span class="btn_order_action">Отправить смс</span>
						<div class="right_block">
							<div class="sms" data-type="1">отправка</div>
							<div class="sms" data-type="2">доставка</div>
							<div class="sms" data-type="3">подарок</div>
							<div class="sms" data-type="4">гарантия выкупа</div>
							<div class="sms" data-type="5">коллектор1</div>
							<div class="sms" data-type="6">коллектор2</div>
							<div class="sms" data-type="7">кредитная история</div>
						</div>
					</li>
						<?}?>
				</ul>
			</div>
		</div>
		<a modal="sms_message" style="margin-left: 10px; cursor: pointer; text-decoration: underline;">тексты sms сообщений</a>
	</div>

	</div>
	
	<div id="sms_message" class="modal" style="display: none;">
		<div class="modal-block modal-top modal-left" style="border-radius: 15px 15px 10px 10px; margin-top: -103px; margin-left: -299px;">
			<div class="icon-close"></div>
			<div class="title" style="border-radius: 10px 10px 0px 0px;"><h1>Тексты sms оповещений</h1></div>
			<div class="content">
				<div class="sms_form">
					<input type="hidden" name="partner_id" value="<?=$this->vars['partner_id']?>">
					<span>Текс сообщения отправки:</span>
					<textarea class="sms_message" data-type="1"><?=$this->vars['message_1']?></textarea>
					<span>Текс сообщения доставки:</span>
					<textarea class="sms_message" data-type="2"><?=$this->vars['message_2']?></textarea>
					<span>Текс сообщения подарка:</span>
					<textarea nclass="sms_message" data-type="3"><?=$this->vars['message_3']?></textarea>
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
		</div>
	</div>
	
</body>
</html>