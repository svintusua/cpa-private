<div id="title"><h1><?=$this->vars["title"];?></h1></div>
<div id="table">
</div>
<div id="pagination"></div>
<div class="little_block">
<span>Добавить товар</span>
<form id="form_goods" action="/store/setInfo" method="POST">
<input type="text" name="name" placeholder="название товара">
<input type="text" name="features" placeholder="краткое описание">
<input type="text" name="description" placeholder="полное описание"> 
<input type="hidden" name="action" value="add_goods"> 
<input type="hidden" name="is_ajax" value="1"> 
<input type="text" name="price" placeholder="цена">
<?=$this->vars['currency'];?>
<?=$this->vars['category'];?>
<?=$this->vars['company'];?>
<?=$this->vars['type_goods'];?>
<input type="file" class="" name="img">
<input id="c1" type="checkbox" name="consent"><label for="c1">опубликовать</label>
<input type="submit" value="добавить">
</form>
</div>
<div class="little_block">
<span>Добавить категорию</span>
<form id="form_category">
<input type="text" name="name" placeholder="название категории">
<?=$this->vars['company'];?>
<input type="submit" value="добавить">
</form>
</div>
<div class="little_block">
<span>Добавить фирму</span>
<form id="form_company">
<input type="text" name="name" placeholder="название фирмы">
<?=$this->vars['type_goods'];?>
<input type="submit" value="добавить">
</form>
</div>