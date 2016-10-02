$(function(){	
	$(window).load(function() {		
		$('.prem:nth-child(1)').css('opacity', '1');
		setTimeout("$('.prem:nth-child(2)').css('opacity', '1');",800);
		setTimeout("$('.prem:nth-child(3)').css('opacity', '1');",1600);
		setTimeout("$('.prem:nth-child(4)').css('opacity', '1');",2400);
	})
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
});
function animation_slide1(){				
		$('.romb3').css('opacity',"1");
		setTimeout(function(){
			$('.romb1').css('left',"5px");
			$('.romb2').css('left',"0px");
			$('.romb4').css('left',"2px");
			$('.romb5').css('left',"-225px");
			$('.romb6').css('left',"-81px");
		},100);		
}
var i=2;
function animation_slide2(){
	if(i<=11){			
		$('#slide2 .prem:nth-child(' + i + ')').css('opacity','1');
		i++;
		setTimeout(animation_slide2, 300);
	}
}
var n=2;
var n_n = 1;
function animation_slide3(){
	if(n<=9){			
		$('#slide3 .usl:nth-child(' + n + ')').css('transform','scale(1)');
		n++;
		setTimeout(animation_slide3, 300);
	}else if(n>9 && n<=12){		
		$('#slide3 .center .usl:nth-child(' + n_n + ')').css('transform','scale(1)');
		n++;
		n_n++;
		setTimeout(animation_slide3, 300);
	}
}
var b=2;
function animation_slide4(){
	if(b<=8){	
		$('#slide4 .how_work:nth-child(' + b + ')').css('left','0px');
		setTimeout(function(){
			$('#slide4 .how_work:nth-child(' + b + ')::after').css('opacity','1');
		},450);
		setTimeout(animation_slide4, 650);
		b++;
	}
}

