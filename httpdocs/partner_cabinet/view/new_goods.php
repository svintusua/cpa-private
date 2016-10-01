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
		});
</script>
<div id="content">
	<div class="caption"><h1><?=$this->vars['title']?></h1></div>
	<div id="block">
		<div class="block_left">
			<div class="row img">
				<div id="upload" ><span>Загрузить картинку<span></div><span id="status" ></span><!--<input name="picture" type="file" placeholder="Картинка"/>-->
			</div>
			<div class="row">
				<input type="text" name="name" placeholder="Название">
				<input type="hidden" name="img">
			</div>
			<div class="row">
				<textarea name="description" placeholder="Описание"></textarea>
			</div>	
			<div class="row">
				<input type="text" name="price" placeholder="Розничная цена">
			</div>
			<div class="row">
				<input type="text" name="purchase_price" placeholder="Закупочная цена">
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
				<select name="offer_id">
					<?=$this->vars['offers']?>
				</select>
				<span class="dop_button" data-historyby="offer">создать оффер</span>
				<div id="add_new_offers">
				<div class="icon-close"></div>
					<form id="add_offers" action="post">
						<div class="block_left">
							<div class="row">
                                                                <input type="text" name="partner_id" value="<?=$this->vars['user_id']?>" <?if($this->vars['user_id'] != 11){?>disabled<?}?>>
							</div>
							<div class="row">
								<input type="text" name="location_name" placeholder="Таргетинг" required pattern="[А-Яа-яЁ-ё]{3,}">
							</div>
                                                        <div class="row">
								<input type="text" name="name" placeholder="Название оффера" required>
							</div>	
							<div class="row">
								<ul class="traffs_ul">
									<?=$this->vars['traffs1']?>
								</ul>
							</div>
						</div>
						<div class="block_right">
							<div class="row">
								<input type="text" name="postclick" placeholder="Постклик" required pattern="[0-9]{1,}">
							</div>
							<div class="row">
								<input type="text" name="hold" placeholder="Холд" required pattern="[0-9]{1,}">
							</div>
							<div class="row">
								<ul class="traffs_ul">
									<?=$this->vars['traffs2']?>
								</ul>
							</div>
						</div>
						<input type="submit" value="создать">
					</form>
				</div>
			</div>
			<!--<div class="row" style="">
				<select name="category_id" style="display: none;">
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
				<input type="number" name="count" placeholder="Остаток по складу">
			</div>
			<div class="row">
				<input type="text" name="weight" placeholder="Вес">
			</div>
			<div class="row">
				<input type="text" name="height" placeholder="Высота">
			</div>
			<div class="row">
				<input type="text" name="width" placeholder="Ширина">
			</div>
			<div class="row">
				<input type="text" name="long" placeholder="Длина">
			</div>
			<div class="row">
				<input type="text" name="barcode" placeholder="Штрих код">
			</div>
			<div class="row" >
				<input type="text" name="shop" placeholder="Магазин">
			</div>
			<div class="row">
				<input type="text" name="link_site" placeholder="Ссылка">
			</div>			
		</div>
		<div class="center">
			<span id="add_goods" class="send_order">добавить</span>
		</div>
	</div>
</div>
