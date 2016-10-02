$(function(){

	$(document).on('submit', '#form_category', function(e){
		e.preventDefault();
		post = $('#form_category').serialize();
		post += '&is_ajax=1';
		
	});
	$(document).on('submit', '#form_company', function(e){
		e.preventDefault();
		post = $('#form_company').serialize();
		post += '&is_ajax=1';
		
	});
})