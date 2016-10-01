<div class="title">
	<div id="roll_up_down" data-action="up">
		<i class="zmdi zmdi-caret-up"></i>
	</div>
	<h1><?=$this->vars['title'];?></h1>	
</div>
<div class="storefront">
<? if(is_array($this->vars['goods'])){?>
<?foreach($this->vars['goods'] as $goods){?>
<div class="goods">
		<div class="view">
			<div class="name">
				<h2><?=$goods['name']?></h2>
			</div>
		</div>
		<div class="description">
				<span><?=$goods['price']?> <?=$goods['currency']?></span>
				<p><?=$goods['description']?></p>
		</div>
	</div>
<?}?>
<?}else{
	echo $this->vars['goods'];
}?>
</div>