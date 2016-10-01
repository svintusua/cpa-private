
$(function(){	
$('.phonefield').mask('+7(999)999-9999');
top = 0;
r = $("body").height()*0.4;
	$( window ).resize(function() {
		$("#header").height($("body").height());
		if(top==0){
			$("#logo").css({width: r, height: r});
		}
	});
	$(window).load(function(){	 
		$("body").mCustomScrollbar({
		theme:"minimal-dark"
		});	
		$("#header").height($("body").height());		
		$("#logo").css({width: r, height: r, marginTop: -(r/2)});
			setTimeout(function(){
				$("#logo").css({transform: 'scale(1)'});
				$(".fon").css({background:'rgba(0,0,0,0)'});
			}, 100);
			setTimeout(function(){
				top=0;
				$("#header .fon").remove();
				$("#logo h1").css({fontSize: '0', margin: '0px'});
				$("#logo").css({width: '175px', height: '175px', top: '50%', marginTop: '-175px'});
			}, 4100);
			setTimeout(function(){
				$("#logo h1").addClass("undeline");
				setTimeout(function(){
					$(".undeline").css({width: '400px'});
					$(".undeline:last-child").css({right: '-412px'});
					$(".undeline:first-child").css({left: '-412px'});				
				}, 10);
				$("#block_top").css({opacity: '1'});
				$("#logo").addClass('aft');
				$("#header .text").css({opacity: '1'});
			}, 6010);
			setTimeout(function(){				
				$("#absolut_text p:nth-child(3)").css({opacity: '1'});
			}, 6610);
			setTimeout(function(){				
				$("#absolut_text p:nth-child(5)").css({opacity: '1'});
			}, 7210);
			setTimeout(function(){				
				$(".enter_btn").css({opacity: '1'}); 
			}, 7310);
	});
	$(document).ready(function(){
		
		
	});
	first_open=0;
	class_show='';
	open=0;
	$('#header .top_btn, footer .abs_btn span').on('click', function(){
		
		action =$(this).data('action');
		// $('#partner').css({display: 'block'});
		$('#'+action).css({display: 'block'});
		switch(action){
			//-убрать - удалить чтобы работало
			case 'webmaster-убрать':
				div_class = 'for_wm';
				div_class_close = 'for_partner';
			break;
			case 'partner-убрать':
				div_class = 'for_partner';
				div_class_close = 'for_wm';
			break;
		}
			if(first_open == 0){
					if(open !=1){
						open = 1;
						class_show = div_class;
						$('.'+div_class).css({display: 'block'});
						s2=parseInt($('#slide2').css('height'),10);
						s3=parseInt($('#slide3').css('height'),10);
						s4=parseInt($('#slide4').css('height'),10);
						//f=parseInt($('footer').css('height'),10);
						height = s2+s3+s4;	
						$('#content').css('height', height+'px');
						setTimeout(function(){
							$('#mCSB_1_container').animate({
								top: -$('#slide3').offset().top
							}, 'slow');
						},100);					
						first_open = 1;
						open = 0;
					}
				}else{
					if(class_show != div_class && open != 1){
						class_show = div_class;
						open = 1;
						$('#content').css('height', '0px');
						$('#mCSB_1_container').animate({
							top: 0
						}, 'slow');
						setTimeout(function(){
							$('.'+div_class_close).css({display: 'none'});
							$('.'+div_class).css({display: 'block'});
						}, 1500);
						setTimeout(function(){
							s2=parseInt($('#slide2').css('height'),10);
							s3=parseInt($('#slide3').css('height'),10);
							s4=parseInt($('#slide4').css('height'),10);
							//f=parseInt($('footer').css('height'),10);
							height = s2+s3+s4;	
							$('#content').css('height', height+'px');
							
							$('#mCSB_1_container').animate({
									top: -$('#slide3').offset().top
								}, 'slow');
								open = 0;
						}, 1505);
						
					}
				}
				
		//$('#content').css({display: 'block'});
		
	});
	
	$(window).scroll(function () {
		if($('#slide2').offset().top <=0){
			
		}
	});
	$('#webmaster .form_nav span, #slide4 .form_nav span').on('click', function(){
		form = $(this).data('form');
		switch(form){
			case 'recover':
				$('#webmaster .form_nav span').removeClass('active');
				$('#webmaster .title h1').text('востановить пароль');
				$(this).addClass('active');;
				$('#webmaster .return_password').css({display: "block"});
				$('#webmaster .registration').css({display: "none"});
				$('#webmaster .enter').css({display: "none"});
			break;
			case 'reg':
				$('#webmaster .title h1').text('Зарегистрировваться как вебмастер');
				$('#webmaster .form_nav span').removeClass('active');
				$(this).addClass('active');
				$('#webmaster .registration').css({display: "block"});
				$('#webmaster .return_password').css({display: "none"});
				$('#webmaster .enter').css({display: "none"});
			break;
			case 'aut':
				$('#webmaster .title h1').text('войти в личный кабинет');
				$('#webmaster .form_nav span').removeClass('active');
				$(this).addClass('active');;
				$('#webmaster .enter').css({display: "block"});
				$('#webmaster .registration').css({display: "none"});
				$('#webmaster .return_password').css({display: "none"});
			break;
		}
	});
	$('#partner .form_nav span, #slide4 .form_nav span').on('click', function(){
		form = $(this).data('form');
		switch(form){
			case 'recover':
				$('#partner .title h1').text('востановить пароль');
				$('#partner .form_nav span').removeClass('active');
				$(this).addClass('active');;
				$('.return_password').css({display: "block"});
				$('.registration').css({display: "none"});
				$('.enter').css({display: "none"});
			break;
			case 'reg':
				$('#webmaster .title h1').text('Зарегистрировваться как партнер');
				$('#partner .form_nav span').removeClass('active');
				$(this).addClass('active');;
				$('#partner .registration').css({display: "block"});
				$('#partner .return_password').css({display: "none"});
				$('#partner .enter').css({display: "none"});
			break;
			case 'aut':
				$('#partner .title h1').text('войти в личный кабинет');
				$('#partner .form_nav span').removeClass('active');
				$(this).addClass('active');;
				$('#partner .enter').css({display: "block"});
				$('#partner .registration').css({display: "none"});
				$('#partner .return_password').css({display: "none"});
			break;
		}
	});
	$('#enter_modal .form_nav span').on('click', function(){
		form = $(this).data('form');
		switch(form){
			case 'recover':
				$('#enter_modal .title h1').text('востановить пароль');
				$('#enter_modal .form_nav span').removeClass('active');
				$(this).addClass('active');;
				$('.return_password').css({display: "block"});
				$('.registration').css({display: "none"});
				$('.enter').css({display: "none"});
			break;			
			case 'aut':
				$('#enter_modal .title h1').text('войти в личный кабинет');
				$('#enter_modal .form_nav span').removeClass('active');
				$(this).addClass('active');;
				$('#enter_modal .enter').css({display: "block"});
				$('#enter_modal .registration').css({display: "none"});
				$('#enter_modal .return_password').css({display: "none"});
			break;
		}
	});
	
	$('#form_webmaster_reg, #form_parter_reg').on('submit', function(e){
		capcha_ok = 0;
		
		e.preventDefault();			
		form_id = $(this).attr('id');
		$('#' + form_id + ' input[type="submit"]').prop('disabled',true);
		switch(form_id){
			case 'form_webmaster_reg':
				capcha_code = $.cookie('capcha_u');
			break;
			case 'form_parter_reg':
				capcha_code = $.cookie('capcha_p');
			break;
		}
		
		n1 = $('#' + form_id + ' .n1').val();
		n2 = $('#' + form_id + ' .n2').val();
		n3 = $('#' + form_id + ' .n3').val();
		n4 = $('#' + form_id + ' .n4').val();
		
		capcha = n1+''+n2+''+n3+''+n4;
		if(capcha==capcha_code){
		  capcha_ok = 1;
		}
		if(capcha_ok == 1){
			pas1 = $('#' + form_id + ' input[name="password"]').val();
			pas2 = $('#' + form_id + ' input[name="repeat_password"]').val();
			rules = $('#' + form_id + ' input[name="rules"').prop("checked");
			if(rules == false && form_id == 'form_webmaster_reg'){
				$('#information .content p').text('Вы не приняли наши правила работы с системой!');
				$('#information').css('display','block');
			}else{
				if(pas1 == pas2){
					e.preventDefault();
					post = $(this).serialize();
					post += '&is_ajax=1';
					$.post('/register', post, function(resp){
							if(resp.success==1){
								$('#information .content p').text(resp.text);
								$('#information').css('display','block');
								//$('#nav').html('<span style="width: 100%;font-size: 20px;text-align: center;" data-form="exit" title="выйти">ВЫХОД</span>');
								window.location.reload();
							}else if(resp.success==0){
								$('#information .content p').text(resp.text);
								$('#information').css('display','block');
							}else if(resp.error==1){
								$('#information .content p').text(resp.text);
								$('#information').css('display','block');
							}
							
						}, 'json');	
				
				}else{
					$('#information .modal-block .content p').text('Пароли не совпадают!');
					$('#information').css('display', 'block');
					
				}
			}
		}else{
			$('#information .modal-block .content p').text('Вы не правильно выставили число. Пожалуйста подтвердите, что вы не робот.');
			$('#information').css('display', 'block');
		}
		$('#' + form_id + ' input[type="submit"]').prop('disabled',false);
	});
	
	$('#form_webmaster_return, #form_partner_return').on('submit', function(e){
			e.preventDefault();	
			post = $(this).serialize();
			post += '&is_ajax=1';
			$.post('/recoverpassword', post, function(resp){
						if(resp.success){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}else if(resp.error){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}
				}, 'json');	
	});
	
	$('#form_webmaster_enter, #form_parter_enter').on('submit', function(e){
			e.preventDefault();	
			post = $(this).serialize();
			post += '&is_ajax=1';
			$.post('/auth', post, function(resp){
					if(resp.good){
						window.location.reload();
					}else if(resp.error){
						$('#information .content p').text(resp.text);
						$('#information').css('display','block');
					}					
				}, 'json');	

	});
	
	
	
	
/*

	$('.btn_promo .item').on('click', function(e){
		$('.btn_promo').css('display', 'none');
	});
	$('.icon-close, #order').on('click',function(event){
		if (($(event.target).closest("modal-block.modal-top.modal-left").length) || ($(event.target).closest(".content").length) || ($(event.target).closest(".title").length)) {
            return;
        }else{
			$('.form input[type="text"]').val('');
			$('.response p').text('');
			$('.form').css('display', 'block');
			$('.response').css({display:"none",opacity:"0"});			
		}
	});
	$('.phonefield').mask('+7(999)999-9999');
	$('.btn').on('click',function(){
		yaCounter32721385.reachGoal('action_open');
		product = $(this).data('product');
		$('.form input[name="product"]').val(product);
		$('.intresting').text(product);
	});
	$('#order_send').on('submit', function(e){
		e.preventDefault();
		promo = $('input[name="promo"]').val();		
		send='no';
		promo_to_send = '';
		if(promo){			
			$.post('promo.php', 'promocode='+promo, function(resp){ 
				if(resp.response == 'used'){
					$( "#dialog-confirm" ).dialog({
					  resizable: false,
					  height:140,
					  modal: true,
					  buttons: {
						"Да": function() {
							$('input[name="promo"]').val('')
							$( this ).dialog( "close" );
							send="no";
						},
						"Нет": function() {
							alert('mmmm');
							$('input[type="submit"]').prop('disabled', true);
							var data = $('#order_send').serialize();
							$.post('order.php', data, function(resp){
									$('input[type="submit"]').prop('disabled', false);
									$('.form').css('display', 'none');
									$('.response').css({display:"block",opacity:"1"});
									$('.response p').text(resp.response);
									yaCounter32721385.reachGoal('send_mail');
							}, "json");
							$( this ).dialog( "close" );
						}
					  }
					});
				}else if(resp.response == 'noused'){
					promo_to_send = '&promo=' + promo;
					send='yes';
				}else{
					send='no';
					alert(resp.response);					
				}
				
				if(send =='yes'){
					$('input[type="submit"]').prop('disabled', true);
					var data = $('#order_send').serialize();
					data += promo_to_send;
					$.post('order.php', data, function(resp){
							$('input[type="submit"]').prop('disabled', false);
							$('.form').css('display', 'none');
							$('.response').css({display:"block",opacity:"1"});
							$('.response p').text(resp.response);
							yaCounter32721385.reachGoal('send_mail');
					}, "json");
				}
					
			}, "json");
		}else{
			$('input[type="submit"]').prop('disabled', true);
			var data = $('#order_send').serialize();
			$.post('order.php', data, function(resp){
					$('input[type="submit"]').prop('disabled', false);
					$('.form').css('display', 'none');
					$('.response').css({display:"block",opacity:"1"});
					$('.response p').text(resp.response);
					yaCounter32721385.reachGoal('send_mail');
			}, "json");
		}
	});
	$('#menu .center ul li:nth-child(1)').on('click',function(){
		$('html, body').animate({
			scrollTop: ($('#slide2').offset().top-100)
		}, 'slow');
	});
	$('#menu .center ul li:nth-child(2), .romb2').on('click',function(){
		$('html, body').animate({
			scrollTop: ($('#slide5').offset().top-100)
		}, 'slow');
	});
	$('#menu .center ul li:nth-child(3)').on('click',function(){
		$('html, body').animate({
			scrollTop: ($('#slide6').offset().top-100)
		}, 'slow');
	});	
		$(window).scroll(function () {
			var s_h =50;
            if ($(this).scrollTop() > s_h) {
               // $('#menu').css('background','rgba(0, 0, 0, 0.5)');
			
            }else{
                //$('#menu').css('background','none');
			}
			
			var show_slide2=0;
			
			if($(window).scrollTop()>($('#slide2').offset().top-500) && show_slide2==0 ){
				show_slide2 = 1;
				animation_slide2();				
			}
			
			var show_slide3=0;
			
			if($(window).scrollTop()>($('#slide3').offset().top-200) && show_slide3==0 ){
				show_slide3 = 1;
				animation_slide3();				
			}
			
			var show_slide4=0;
			
			if($(window).scrollTop()>($('#slide4').offset().top-200) && show_slide4==0 ){
				show_slide4 = 1;
				animation_slide4();				
			}
		});
		
		$(window).load(function() {
			setTimeout(animation_slide1, 50);
			
		});
		*/
		
});