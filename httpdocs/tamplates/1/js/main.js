$(document).ready(function(){
	count_slide = $('#sliders').children().length;
	menu = '';
	menu_name = '';
	for(i=1; i<=count_slide; i++){
		menu_name = $('#slide' + i).data('name');
		if(i == 1){
			active = 'class="active"';
		}else{
			active = '';
		}
		menu += '<li data-slide="slide' + i + '" ' + active + '><div class="active_icon"><i class="zmdi zmdi-hc-fw"></i></div><span>' + menu_name + '</span></li>';
	}
	$('nav ul').html(menu);
	$('nav ul li').on('click', function(){
		slide_active = $(this).data('slide');
		console.log(slide_active);
		$('nav ul li').removeClass('active');
		$(this).addClass('active');
		$('.slide').css({opacity:0,zIndex:0});
		setTimeout(function(){
			$('#'+slide_active).css({opacity:1,zIndex:1});
		},500);
	});
});


