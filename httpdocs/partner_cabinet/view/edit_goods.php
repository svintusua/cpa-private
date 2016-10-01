<style>
#block,.caption {
	width: 80%;
}
</style>
<script>
$(window).on('load', function(){
var btnUpload=$('#upload');
		var status=$('#status');
		new AjaxUpload(btnUpload, {
			action: '/partner_cabinet/new_goods/uploadImg',
			name: 'uploadfile',
			onSubmit: function(file, ext, post){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Поддерживаемые форматы JPG, PNG или GIF');
					return false;
				}
				//status.text('Загрузка...');
			},
			onComplete: function(file, r){
				//On completion clear the status
				status.text('');
				//Add uploaded file to list
				resp = JSON.parse(r);
				if(resp.response=="success"){
					//alert(file);
					$('input[name="img"]').val(resp.img_name);
					$('#block .block_left .row.img').html('<img src="../img/goods/'+$('input[name="partner_id"]').val()+'/'+resp.img_name+'" style="width: 150px;">');
				}else if(resp.response=="error"){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
				}
			}
		});
		
	var btnUpload=$('#a_upload');
		var status=$('#status');
		new AjaxUpload(btnUpload, {
			action: '/partner_cabinet/new_goods/uploadImg',
			name: 'uploadfile',
			onSubmit: function(file, ext, post){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Поддерживаемые форматы JPG, PNG или GIF');
					return false;
				}
				//status.text('Загрузка...');
			},
			onComplete: function(file, r){
				//On completion clear the status
				status.text('');
				//Add uploaded file to list
				resp = JSON.parse(r);
				if(resp.response=="success"){
					//alert(file);
					$('input[name="a_img"]').val(resp.img_name);
					$('.row.a_img').html('<img src="../img/goods/'+$('input[name="partner_id"]').val()+'/'+resp.img_name+'" style="width: 150px;">');
				}else if(resp.response=="error"){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
				}
			}
		});
});
</script>
<div id="content">
	<div class="caption"><a class="come_back" onclick="history.back();return false;">Назад</a><h1><?=$this->vars['title']?></h1>
		
	</div>
	<div id="block">
		<div class="block_left">
			<div class="row">
				<span class="order_id">№<span id="oid"><?=$this->vars['goods_info']['id']?></span></span>
				<span class="show_img" data-action="show" style="cursor: pointer;">Отобразить картинку</span>
				<div class="im">
					<img src="<?=$this->vars['img']?>" class="goods_img">
					<div class="all_img" style="display:none;"><?=$this->vars['img_all']?></div>
					<div id="upload" ><span>Изменить картинку<span></div>
				</div>
			</div>
			<div class="row">
				<span class="des">Название:</span><input type="text" name="name" placeholder="Название" value="<?=$this->vars['goods_info']['name']?>">
			</div>
			<div class="row">
				<span class="des">Описание:</span><textarea name="description" placeholder="Описание"><?=$this->vars['goods_info']['description']?></textarea>
			</div>	
			<div class="row">
				<span class="des">Цена:</span><input type="text" name="price" placeholder="Цена"  value="<?=$this->vars['goods_info']['price']?>">
			</div>
			<div class="row">
				<span class="des">Закупочная цена:</span><input type="text" name="purchase_price" placeholder="Закупочная цена"  value="<?=$this->vars['goods_info']['purchase_price']?>">
			</div>
			<!--<div class="row">
				<span class="des">Валюта</span>
				<select name="currency">
					<option value="1">Р</option>
					<option value="2">$</option>
					<option value="3">&#8364;</option>
				</select>
			</div>-->	
			<?if($this->vars['apical_show'] == 1){?>
			<div class="row">	
				<a modal="apical"><span class="send_order" style="position: relative; top: 10px; bottom: 0;right:0;">добавить апесейл/акссесуар</span></a>
			</div>
			<div class="row">
				<?=$this->vars['apical']?>
			</div>
			<?}?>
		</div>
		
		
		
		
		<div class="block_right">
			<div class="row">
				<span class="des">Оффер</span>
				<select name="offer_id">
					<?=$this->vars['offers']?>
				</select>
			</div>
			<!--<div class="row">
				<select name="category_id">
					<?=$this->vars['category']?>
				</select>
				<span class="dop_button" data-historyby="category">добавить категорию</span>
				<div id="add_new_offers" class="category">
				<div class="icon-close"></div>
					<form id="add_category" action="post">
						<div class="block_left">
							<div class="row">
								<input type="text" name="c_name" placeholder="название категории">
							</div>							
						</div>	
						<input type="submit" value="добавить">						
					</form>
				</div>
			</div>-->
			<div class="row">
				<span class="des">Количество:</span><input type="number" name="count" placeholder="Количество" pattern="[0-9]{1,}"  value="<?=$this->vars['goods_info']['count']?>">
			</div>
			<div class="row">
				<span class="des">Вес:</span><input type="text" name="weight" placeholder="Вес" pattern="[0-9]{1,}"  value="<?=$this->vars['goods_info']['weight']?>">
			</div>
			<div class="row">
				<span class="des">Высота:</span><input type="text" name="height" placeholder="Высота" pattern="[0-9]{1,}"  value="<?=$this->vars['goods_info']['height']?>">
			</div>
			<div class="row">
				<span class="des">Ширина:</span><input type="text" name="width" placeholder="Ширина" pattern="[0-9]{1,}"  value="<?=$this->vars['goods_info']['width']?>">
			</div>
			<div class="row">
				<span class="des">Длина:</span><input type="text" name="long" placeholder="Длина" pattern="[0-9]{1,}"  value="<?=$this->vars['goods_info']['long']?>">
			</div>	
			<div class="row">
				<span class="des">Штрих-код:</span>
				<input type="text" name="barcode" placeholder="Штрих код" value="<?=$this->vars['goods_info']['barecode']?>">
			</div>	
			<div class="row" >
				<span class="des">Магазин:</span>
				<input type="text" name="shop" placeholder="Магазин" value="<?=$this->vars['goods_info']['shop']?>">
			</div>
			<div class="row">
				<span class="des">Ссылка:</span>
				<input type="text" name="link_site" placeholder="Ссылка" data-order_id="<?=$this->vars['goods_info']['id']?>" value="<?=$this->vars['goods_info']['site_link']?>">
				<div id="link">
				</div>
			</div>	
		</div>
		<div class="center">
			<span id="edit_goods" class="send_order">сохранить</span>
		</div>
	</div>
</div>





	<div id="apical" class="modal" style="display: none; ;z-index: 99999;background: rgba(0,0,0,0.9);">
		<div class="modal-block modal-top modal-left" style="background: #fff;border-radius: 15px 15px 10px 10px; margin-top: -103px; margin-left: -400px;width: 800px"> 
			<div class="icon-close"></div>
			<div class="content">
				<div class="block_left">
			<div class="row a_img">
				<div id="a_upload" ><span>Загрузить картинку<span></div><span id="status" ></span><!--<input name="picture" type="file" placeholder="Картинка"/>-->
			</div>
			<div class="row">
				<input type="text" name="a_name" placeholder="Название">
				<input type="hidden" name="a_img">
			</div>
			<div class="row">
				<textarea name="a_description" placeholder="Описание"></textarea>
			</div>	
			<div class="row">
				<input type="text" name="a_price" placeholder="Розничная цена">
			</div>
			<div class="row">
				<input type="text" name="a_purchase_price" placeholder="Закупочная цена">
			</div>
			<!--<div class="row">
				<select name="currency">
					<option value="1">Р</option>
					<option value="2">$</option>
					<option value="3">&#8364;</option>
				</select>
			</div>-->							
		</div>
		<div class="block_right">
			<div class="row">
				<select name="a_offer_id">
					<?=$this->vars['offers']?>
				</select>				
			</div>
			<div class="row">
				<input type="number" name="a_count" placeholder="Остаток по складу">
				<input type="hidden" name="apical" value="<?=$_GET['goods_id']?>">
			</div>
			<div class="row">
				<input type="text" name="a_weight" placeholder="Вес">
			</div>
			<div class="row">
				<input type="text" name="a_height" placeholder="Высота">
			</div>
			<div class="row">
				<input type="text" name="a_width" placeholder="Ширина">
			</div>
			<div class="row">
				<input type="text" name="a_long" placeholder="Длина">
			</div>
			<div class="row">
				<input type="text" name="a_barcode" placeholder="Штрих код">
			</div>		
			
		</div>
		<div class="center">
			<span id="add_apical" class="send_order">добавить</span>
		</div>
	</div>
			</div>
		</div>