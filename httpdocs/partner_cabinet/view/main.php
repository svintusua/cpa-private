<div id="content">
	<div class="caption"><a href="/"><h1><?=$this->vars['title']?></h1></a>
	<label for="not_color"><input type="checkbox" id="not_color">Скрыть цвета</label>
	<a href="/partner_cabinet/new_order"><span class="send_order">добавить заказ</span></a>
		<div class="icon"><span><i class="zmdi zmdi-hc-fw"></i></span></div>
	</div>
<div id="paginations">
			<label for="size2" style="<?=$this->vars['disp']?>">Показывать:
				<select id="size2" style="<?=$this->vars['disp']?>">
						<option>-</option>
						<option value="50">по 50</option>
						<option value="100">по 100</option>
				</select>
			</label> 
			<span class="prev" style="<?=$this->vars['disp']?>"><i class="zmdi zmdi-hc-fw"></i></span>
			<div id="pages" style="<?=$this->vars['disp']?>"><div><?=$this->vars['pages']?></div></div>
			<span class="next" style="<?=$this->vars['disp']?>"><i class="zmdi zmdi-hc-fw"></i></span>
		</div>	
	<div class="hidden_filters">
			<span class="close"><i class="zmdi zmdi-hc-fw"></i></span>
			<div class="block">
				<label><input type="checkbox" class="fh fr" data-filter="status">Статус</label>
				<label><input type="checkbox" class="fh fr" data-filter="offer_id">ID оффера</label>
				<label><input type="checkbox" class="fh fr" data-filter="wm_id">ID вебмастера</label>
				<label><input type="checkbox" class="fh fr" data-filter="delivery_type">Тип доставки</label>
				<label><input type="checkbox" class="fh fr" data-filter="time_delivery">Время доставки</label>
				<label><input type="checkbox" class="fh fr" data-filter="pay_type">Тип оплаты</label>
				<span style="display: block;">Показать данные:</span>
				<label><input type="checkbox" class="fh ds" data-filter="wm_status">Статус</label>
				<label><input type="checkbox" class="fh ds" data-filter="offer_id">ID оффера</label>
				<label><input type="checkbox" class="fh ds" data-filter="wm_id">ID вебмастера</label>
				<label><input type="checkbox" class="fh ds" data-filter="pay">Ставка</label>
				<label><input type="checkbox" class="fh ds" data-filter="date_status">Дата статуса</label>
				<label><input type="checkbox" class="fh ds" data-filter="payout_id">ID выплаты</label>
					<!--<div class="filter hidde" data-filtr="status">
						<select name="status">
							<?=$this->vars['option_order_status']?>
						</select>
					</div>
					<div class="filter">
						<select name="offer_id hidde" data-filtr="offer_id">
							<?=$this->vars['option_offer']?>
						</select>
					</div>		
					<div class="filter">
						<select name="wm_id hidde" data-filtr="wm_id">
							<?=$this->vars['option_wm_id']?>
						</select>
					</div>			
					
					<div class="filter">
						<select name="type_delevery hidde" data-filtr="delivery_type">
							<option selected disabled>Тип доставки</option>
							<option value="all">-</option>
						</select>
					</div>
					<div class="filter">
						<select name="time_delevery hidde" data-filtr="time_delivery">
							<option selected disabled>Время доставки</option>
							<option value="all">-</option>
						</select>
					</div>
					<div class="filter">
						<select name="type_pay hidde" data-filtr="pay_type">
							<option selected disabled>Тип оплаты</option>
							<option value="all">-</option>
						</select>
					</div>-->
			</div>
		</div>
	<div id="block">		
		<div class="filters_block">
                        <input type="hidden" name="type_order_by">
                        <input type="hidden" name="col_order_by">
			<div class="filter">
				<input type="text" name="id_order" placeholder="Номер заказа">
			</div>
			<div class="filter">
				<input type="text" name="fio_buyer" placeholder="ФИО покупателя">
			</div>
			<div class="filter">							
				<input type="text" name="phone" class="for_filter" placeholder="Телефон">
			</div>	
			<div class="filter">
				<div class="info_block">
					<span>дата заказа</span>
					<input type="text" name="date_start" class="datepicker" >
					<span> - </span>
					<input type="text" name="date_end" class="datepicker" >					
				</div>
			</div>
			<div class="filter">
						<select name="goods_id">
							<option selected>Товар</option>
							<?=$this->vars['goods_option']?>
						</select>
					</div>
			<div class="filter">
				<div class="info_block">
					<span>сумма заказа </span>
					<input type="text" name="sum_start" class="short" >
					<span> - </span>
					<input type="text" name="sum_end" class="short" >					
				</div>
			</div>
			<div class="filter">
				<input type="text" name="manager" placeholder="Менеджер" style="display: <?=$this->vars['spec_filter']?>">
			</div>
			<div class="filter" >
				<input type="text" name="shop" placeholder="Магазин" style="display: <?=$this->vars['spec_filter']?>">
			</div>
			<div class="filter" >
				<input type="text" name="target" placeholder="Ресурс">
			</div>
                        <div class="filter" >
                            <div class="info_block">
                                <span id="clearfilter">Очистить фильтер</span>
                            </div>
			</div>
			<div class="filter hidde" data-filtr="status">
						<select name="status">
							<?=$this->vars['option_order_status']?>
						</select>
					</div>
					<div class="filter hidde" data-filtr="offer_id">
						<select name="offer_id">
							<?=$this->vars['option_offer']?>
						</select>
					</div>		
					<div class="filter hidde" data-filtr="wm_id">
						<select name="wm_id">
							<?=$this->vars['option_wm_id']?>
						</select>
					</div>			
					
					<div class="filter hidde" data-filtr="delivery_type">
						<select name="type_delevery">
							<option selected disabled>Тип доставки</option>
							<option value="all">-</option>
						</select>
					</div>
					<div class="filter hidde" data-filtr="time_delivery">
						<select name="time_delevery"">
							<option selected disabled>Время доставки</option>
							<option value="all">-</option>
						</select>
					</div>
					<div class="filter hidde" data-filtr="pay_type">
						<select name="type_pay">
							<option selected disabled>Тип оплаты</option>
							<option value="all">-</option>
						</select>
					</div>
						
		</div>
		<div class="filter_control">
				<div class="info_block">
					<span id="apply">
						<i class="zmdi zmdi-hc-fw"></i>
						применить
					</span>
					<p>
						<span>Всего заказов: <span id="all_orders">1111</span>;</span>
						<span>на сумму: <span id="all_sum">9999</span>;</span>
						<span>подтверженных: <span id="apruv">111</span>;</span>
						<span>отклоненных: <span id="deny">222</span>;</span>
						<span>в ожидании: <span id="hold">233</span>;</span>
					</p>
					<span id="hidden" data-action="hidden">						
						скрыть фильтр
						<i class="zmdi zmdi-hc-fw"></i>
					</span>
					<div id="b">
						<div id="b_c" data-action="show"><i class="zmdi zmdi-hc-fw"></i></div>
						<?=$this->vars['b']?>
					</div>
				</div>
		</div>
		<div id="orders">
			<?=$this->vars['orders']?>
		</div>		
		<div id="paginations">
			<div id="export">
				<span data-action="show" id="export_btn">Выгрузка</span>
				<div class="export_div">
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
					<p class="export">Выгрузить</p>
				</div>
			</div>
			<label for="size" style="<?=$this->vars['disp']?>">Показывать:
				<select id="size" style="<?=$this->vars['disp']?>">
						<option>-</option>
						<option value="20">по 20</option>
						<option value="50">по 50</option>
						<option value="100">по 100</option>
				</select>
			</label> 
			<span class="prev" style="<?=$this->vars['disp']?>"><i class="zmdi zmdi-hc-fw"></i></span>
			<div id="pages" style="<?=$this->vars['disp']?>"><div><?=$this->vars['pages']?></div></div>
			<span class="next" style="<?=$this->vars['disp']?>"><i class="zmdi zmdi-hc-fw"></i></span>
		</div>
	</div>
</div>