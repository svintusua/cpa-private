<style>
.filters_block {
	min-height: 60px;
}
</style>
<div id="content">
	<div class="caption"><h1><?=$this->vars['title']?></h1>
		<a href="/partner_cabinet/new_goods"><span id="new_goods" class="send_order">добавить товар</span></a>	
		<div class="icon"><span><i class="zmdi zmdi-hc-fw"></i></span></div>
	</div>
	<div class="hidden_filters">
			<span class="close"><i class="zmdi zmdi-hc-fw"></i></span>
			<div class="block">
				<label><input type="checkbox" class="fh fr" data-filter="purchase_price">Закупочная цена</label>
				<label><input type="checkbox" class="fh fr" data-filter="date">Дата</label>
				<label><input type="checkbox" class="fh fr" data-filter="count">Остаток по складу</label>						
			</div>
		</div>
	<div id="block">		
		<div class="filters_block">			
			<div class="filter">
				<input type="text" name="name" placeholder="Название" value="">
				</div>
			<div class="filter">
				<select name="goods_id">
					<option selected value="">Артикул</option>
					<?=$this->vars['goods_option']?>
				</select>
			</div>
			<div class="filter">
				<div class="info_block">
					<span>розничная цена </span>
					<input type="text" name="price_start" class="short" >
					<span> - </span>
					<input type="text" name="price_end" class="short" >					
				</div>
			</div>	
			<div class="filter">
				<input type="text" name="barcode" placeholder="Штрих код">
			</div>				
			<div class="filter hidde" data-filtr="purchase_price">
					<div class="info_block">
						<span>закупочная цена </span>
						<input type="text" name="purchase_price_start" class="short" >
						<span> - </span>
						<input type="text" name="purchase_price_end" class="short" >					
					</div>
				</div>	
				<div class="filter hidde" data-filtr="date">
					<div class="info_block">
						<span>дата</span>
						<input type="text" name="date_start" class="datepicker" >
						<span> - </span>
						<input type="text" name="date_end" class="datepicker" >					
					</div>
				</div>
				<div class="filter hidde" data-filtr="count">
					<input type="text" name="count" placeholder="Остаток по складу">
				</div>			
		</div>
		<div class="filter_control">
				<div class="info_block">
					<span id="apply" data-source="warehouse">
						<i class="zmdi zmdi-hc-fw"></i>
						применить
					</span>
					
					<span id="hidden" data-action="hidden">						
						скрыть фильтр
						<i class="zmdi zmdi-hc-fw"></i>
					</span>
				</div>
		</div>
		<div id="goods">
			<?=$this->vars['goods']?>
		</div>
	</div>
</div>
	