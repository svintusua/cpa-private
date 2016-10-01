$(function(){
	$('body').on('click','.logout', function(){
		post = 'exit=1&is_ajax=1';
		$.post('/goout', post, 'json');	
		setTimeout(function(){
			window.location.reload();
		}, 500);
		
	});
	if(window.location.toString() == 'http://cpa-private.biz/webmaster_cabinet/'){
		countSumAll();
		
		$( ".datepicker, .datepicker2" ).datepicker({
			dateFormat:"dd.mm.yy",
			dateMax: '04.05.2016',
			changeMonth: true,
			changeYear: false,
			monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь', 'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'], 
			monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн', 'Июл','Авг','Сен','Окт','Ноя','Дек'], 
			dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'], 
			dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'], 
			dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб']
		});
	}
	$("#statFilter").keypress(function(e){
		if(window.location.toString() == 'http://cpa-private.biz/webmaster_cabinet/'){
	     	   if(e.keyCode==13){
				   // alert('22222');
					$('.filter_start').trigger('click');
	     	   }
		}
	});
	$('#offer_link_top').on('change', function(){
		text = $(this).val();
		url_gen = '';
		$('.see_offers_table_1 input[type="checkbox"]:checked').each(function(){			
			if ($(this).prop('checked')) {				
				param_name = $(this).parent().parent().children('td:eq(2)').children('input').val();
				macros = $(this).data('macros');
				url_gen += '&'+param_name+'='+macros;
			}
		});
		if(typeof(url_gen) != "undefined"){
			if(text.lastIndexOf('?') == -1){
				symb = '?';
			}else{
				symb = '&';
			}
			url_gen = symb+url_gen.substr(1);
		}else{
			url_gen = '';
		}
		$('#offer_link').val(text+url_gen);
	});
	$('.see_offers_table_1 input[type="checkbox"]').on('click', function(){	 
	  // param_name = $(this).parent().parent().children('td:eq(2)').children('input').val();
	  // macros = $(this).data('macros');
	  // str = param_name+'='+macros;
	  text = $('#offer_link_top').val();
	  // if($(this).prop('checked') == true){
	  	first = $('input[name="offer"]').val().indexOf('?');
	  	url_gen = '';
	  	$('.see_offers_table_1 input[type="checkbox"]:checked').each(function(){
	  		if ($(this).prop('checked')) {				
	  			param_name = $(this).parent().parent().children('td:eq(2)').children('input').val();
	  			macros = $(this).data('macros');
	  			url_gen += '&'+param_name+'='+macros;
	  		}
	  	});
		// url_gen = url_gen[url_gen.lenght-1] = '';
		// url_gen = url_gen.substr(0,url_gen.lenght-2);
		if(typeof(url_gen) != "undefined"){
			if(text.lastIndexOf('?') == -1){
				symb = '?';
			}else{
				symb = '&';
			}
			url_gen = symb+url_gen.substr(1);
		}else{
			url_gen = '';
		}
		$('#offer_link').val(text+url_gen);
		// if(first > 0){			
			// $('#offer_link').val(text+'&'+str);
		// }else{
			// $('#offer_link').val(text+'?'+str);
		// } 
	  // }else{
		  //b[b.length-1]
	  // }
	});
	$('.for_offer').on('click',function(){
		$('.for_offer').each(function(){
			$(this).prop('checked',false);
		});
		$(this).prop('checked',true);
	});
	$('#offer_save').on('click',function(){
		
		lp = $('#offer_link').val().split('?');
		link = lp[0];
		params = lp[1].split('&');
		for_offer = $('.for_offer').val();
		if($('#chek1_offer').prop('checked') == true){
			s_new = 1;
		}else{
			s_new = 0;
		}
		if($('#chek2_offer').prop('checked') == true){
			s_conf = 1;
		}else{
			s_conf = 0;
		}
		if($('#chek3_offer').prop('checked') == true){
			s_rej = 1;
		}else{
			s_rej = 0;
		}
		if(s_new == 0 && s_conf == 0 && s_rej == 0){
			alert('Вы не выбрали при каком событии должен срабатывать постбек');
			$('#information .content p').text('Вы не выбрали при каком событии должен срабатывать постбек');
			$('#information').css('display','block');
		}else{
			post = 'is_ajax=1&link='+link+'&params='+params.join(',')+'&for_offer='+for_offer+'&s_new='+s_new+'&s_conf='+s_conf+'&s_rej='+s_rej;
			console.log(post);
			$.post('/webmaster_cabinet/see_offer/setPostback', post, function(resp){
				if(resp.response=='success'){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');							
				}else if(resp.response=='error'){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
				}
			}, 'json');
		}
	});
	$('.upd_link').on('click', function(){
		subid1 = $('input[name="subid1"]').val();
		subid2 = $('input[name="subid2"]').val();
		subid3 = $('input[name="subid3"]').val();
		land_id = $('.select_land.selected').data('land_id');
		
		if(subid1 != '' || subid1 != ' '){
			s1 = '&subid1='+subid1;
		}else{
			s1 = '';
		}
		
		if(subid2 != '' || subid2 != ' '){
			s2 = '&subid2='+subid2;
		}else{
			s2 = '';
		}
		
		if(subid3 != '' || subid3 != ' '){
			s3 = '&subid3='+subid3;
		}else{
			s3 = '';
		}
		post = 'is_ajax=1&land_id='+land_id+s1+s2+s3;
		
		$.post('/webmaster_cabinet/see_offer/createdLink', post, function(resp){
			if(resp.response=='success'){
				$('input[name="work_link"]').val('http://link.cpa-private.biz/?i='+resp.identity);
				$('#information .content p').text(resp.text);
				$('#information').css('display','block');							
			}else if(resp.response=='error'){
				$('#information .content p').text(resp.text);
				$('#information').css('display','block');
			}
		}, 'json');
		
	});
	$('.bot_btn a').on('click', function(){
		action = $(this).data('action');
		$('.bot_btn a').removeClass('selected');		
		// switch(action){
			// case 'postback':
			if($('.perem.'+action).css('display') == 'none'){
				$('.perem').css('display', 'none');
				$('.perem.'+action).css('display', 'block');
				$(this).addClass('selected');
			}else{
				$('.perem').css('display', 'none');					
			}
			// break;
		// }
	});
	$('body').on('click', '.search-row', function(e){
		element = e.target.className;
		if(element != 'clicks'){
			$('#lead_day .inform').html('');		
			$('#lead_day').css('display','block');
			dt = $(this).children('td:first-child').text();
			subs = $('#sub').val();
			post = 'day='+dt+'&subs='+subs+'&is_ajax=1';
			$.post('/webmaster_cabinet/getStatisticByDay', post, function(resp){
				if(resp.response=='success'){
					$('#lead_day .inform').html(resp.text);					
				}else if(resp.response=='error'){
					$('#lead_day').css('display','none');
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
				}
			}, 'json');
		}
	});
	// $('body').on('click', '.clicks', function(){
			// $('#clicks_stat .inform').html('');		
			// $('#clicks_stat').css('display','block');
			// dt = $(this).prev().text();
			// post = 'day='+dt+'&is_ajax=1';
			// $.post('/webmaster_cabinet/getStatisticClicksByDay', post, function(resp){
				// if(resp.response=='success'){
					// $('#clicks_stat .inform').html(resp.text);					
				// }else if(resp.response=='error'){
					// $('#clicks_stat').css('display','none');
					// $('#information .content p').text(resp.text);
					// $('#information').css('display','block');
				// }
			// }, 'json');
	// });
	$('body').on('click', '#payments', function(){
		// wallet_id = $('#wallet').val();
		wallet_id = '0';
		summa = $('.s').text();
		// if(wallet_id != 0){
			post = 'wallet_id='+wallet_id+'&summa='+summa+'&is_ajax=1';
			$.post('/webmaster_cabinet/payments/payout', post, function(resp){
				if(resp.response=='success'){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
					setTimeout(function(){
						location.reload();
					}, 1000);						
				}else if(resp.response=='error'){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
				}
			}, 'json');
		// }else{
			// $('#information .content p').text('Вы не выбрали кошелек');
			// $('#information').css('display','block');
		// }
		
	});
	$('.land.landing input[type="radio"]').on('click',function(){
		$('.land.landing input[type="radio"]').prop('checked', false);
		$(this).prop('checked', true);
		$('.land.prelanding input[type="radio"]').prop('disabled', false);
	});
	$('.prl_link').on('click', function(){
		link=$(this).data('link');
		$('#connective_link').val(link);
		
	});
	$('#create_connective_link').on('click', function(){
		land_id=$('.land.landing input[type="radio"]:checked').val().split('-')[1];
		prelanding_id=$('.land.prelanding input[type="radio"]:checked').val().split('-')[1];
		name = $('input[name="name_connective_link"]').val();
		if(typeof(land_id) == "undefined"){
			$('#information .content p').text('Выберите лендинг');
			$('#information').css('display','block');
			return false;
		}else if(typeof(prelanding_id) == "undefined"){
			$('#information .content p').text('Выберите прелендинг');
			$('#information').css('display','block');
			return false;
		}else if(typeof(name) == "undefined"){
			$('#information .content p').text('Напишете название связки');
			$('#information').css('display','block');
			return false;
		}else{
			post = 'land_id='+land_id+'&preland_id='+prelanding_id+'&name='+name+'&is_ajax=1';
			$.post('/webmaster_cabinet/see_offer/createPelandLink', post, function(resp){
				if(resp.response=='success'){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
					$('#connective_link').val('http://link.cpa-private.biz/?i='+resp.identy);					
					$('.have_connective ol').append('<li><a class="prl_link" style="cursor: pointer;" data-link="http://link.cpa-private.biz/?i='+resp.identy+'">'+resp.name+'</a></li>');					
				}else if(resp.response=='error'){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
				}
			}, 'json');
		}
		
	});
	$('#retargeting').on('submit', function(e){
		e.preventDefault();	
		post = $(this).serialize();
		post += '&is_ajax=1';
		$.post('/webmaster_cabinet/see_offer/setRetargeting', post, function(resp){
						// if(resp.response=='success'){
							// $('#information .content p').text('Заказа №'+resp.text+' добавлен!');
							// setTimeout(function(){
								// window.location.reload();
							// }, 1000);
							// $('#information').css('display','block');
							
						// }else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						// }
					}, 'json');
		
	});
	$('#us_info').on('submit', function(e){
		e.preventDefault();	
		post = $(this).serialize();
		post += '&is_ajax=1';
		$.post('/webmaster_cabinet/profile/setInfo', post, function(resp){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
					}, 'json');		
	});
	$('#po').on('submit', function(e){
		e.preventDefault();	
		sum = $("#summa").val();
		post = 'summa='+sum+'&is_ajax=1';
		$.post('/webmaster_cabinet/payments/giveMoney', post, function(resp){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
					}, 'json');		
	});
	$('.filter_start').on('click', function(){
		filter = new Array();
		if($('#offerFilter').val()){
			filter.push('offer_name='+$('#offerFilter').val());
		}
		if($('#country').val()){
			filter.push('country='+$('#country').val());
		}
		if($('#sub1').val()){
			filter.push('sub1='+$('#sub1').val());
		}
		if($('#sub2').val()){
			filter.push('sub2='+$('#sub2').val());
		}
		if($('#sub3').val()){
			filter.push('sub3='+$('#sub3').val());
		}
		if($('.date_from').val()){
			filter.push('date_from='+$('.date_from').val());
		}
		if($('.date_to').val()){
			filter.push('date_to='+$('.date_to').val());
		}
		post = filter.join('&')+'&is_ajax=1';
		$.post('/webmaster_cabinet/filterstat', post, function(resp){
						// if(resp.response=='success'){
							// $('#information .content p').text('Заказа №'+resp.text+' добавлен!');
							// setTimeout(function(){
								// window.location.reload();
							// }, 1000);
							// $('#information').css('display','block');
							
						// }else if(resp.response=='error'){
							
							// $('.search-row').remove();
							
							$('#rows').html(resp.text);
							setTimeout(function(){
								countSumAll();
							},100);
							
						// }
					}, 'json');
	});
	function countSumAll(){
		c = 0;
		u = 0;
		tb = 0;
		all_l = 0;
		all_a = 0;
		all_h = 0;
		all_d = 0;
		sum_a = 0;
		sum_h = 0;
		sum_d = 0;

		$('.search-row').each(function(){
			c+=parseInt($(this).children('td:eq(1)').text());
			u+=parseInt($(this).children('td:eq(2)').text());
			tb+=parseInt($(this).children('td:eq(3)').text());
			all_l+=parseInt($(this).children('td:eq(6)').text());
			all_a+=parseInt($(this).children('td:eq(7)').text());
			all_h+=parseInt($(this).children('td:eq(8)').text());
			all_d+=parseInt($(this).children('td:eq(9)').text());
			sum_a+=parseInt($(this).children('td:eq(10)').text());
			sum_h+=parseInt($(this).children('td:eq(11)').text());
			sum_d+=parseInt($(this).children('td:eq(12)').text());	
			
		});
		epc = sum_a/c;
		approve = (all_a/(all_a+all_d+all_h))*100;
		cr = ((all_a+all_d+all_h)/c)*100;
		$('.result-row td:eq(1)').text(c);
		$('.result-row td:eq(2)').text(u);
		$('.result-row td:eq(3)').text(tb);
		$('.result-row td:eq(4)').text(cr.toFixed()+'%');
		$('.result-row td:eq(5)').text(epc.toFixed());
		$('.result-row td:eq(6)').text(approve.toFixed()+'%');
		$('.result-row td:eq(7)').text(all_a);
		$('.result-row td:eq(8)').text(all_h);
		$('.result-row td:eq(9)').text(all_d);
		$('.result-row td:eq(10)').text(sum_a);
		$('.result-row td:eq(11)').text(sum_h);
		$('.result-row td:eq(12)').text(sum_d);
		
	}
	$('body').on('click', '.search-row  td:nth-child(2)', function(e){						
			dt = $(this).prev().text();
			post = 'day='+dt+'&is_ajax=1';
			$.post('/webmaster_cabinet/getStatisticClicksByDay', post, function(resp){
				if(resp.response=='success'){
					$('#clicks_stat .inform').html(resp.text);		
					$('#clicks_stat').css('display','block');					
				}else if(resp.response=='error'){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
				}
			}, 'json');
			
	});
	$('body').on('click', '#create_tb_link', function(e){						
			tb_link = $('#tb_link').val();
			offer_id = window.location.toString().split('?offer_id=')[1];
			post = 'tb_link='+tb_link+'&is_ajax=1'+'&offer_id='+offer_id;
			$.post('/webmaster_cabinet/setTbLink', post, function(resp){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
			}, 'json');
			
	});
	$('body').on('change', '.lsel', function(){
		$('.lsel').prop('checked', false);
		$(this).prop('checked', true);
	});
	$('#upd_link_l').on('click', function(){
		ind = $('.l_f_upd').val();
		l_id = $('.lsel:checked').val();
		post = 'ind='+ind+'&is_ajax=1'+'&l_id='+l_id;
			$.post('/webmaster_cabinet/see_offer/updlinkland', post, function(resp){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
			}, 'json');
	});
	$('body').on('click','.select_land', function(){
		$('.select_land').removeClass('selected');
		$(this).addClass('selected');
		land_id = $(this).data('land_id');
		post = 'land_id='+land_id+'&is_ajax=1';
			$.post('/webmaster_cabinet/see_offer/createdLink', post, function(resp){
				if(resp.response=='success'){
					$('input[name="work_link"]').val('http://link.cpa-private.biz/?i='+resp.identity);
					$('#information .content p').text('Ленд выбран');
					$('#information').css('display','block');
				}else if(resp.response=='error'){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
				}
			}, 'json');
	});
	$('body').on('change','#metrica_sel', function(){
		land_id = $(this).val();
		post = 'land_id='+land_id+'&is_ajax=1';
			$.post('/webmaster_cabinet/see_offer/getRetargeting', post, function(resp){
					$('input[name="ym"]').val(resp.ym);
					$('input[name="rm"]').val(resp.rm);
					$('input[name="vk"]').val(resp.vk);
			}, 'json');
	});
	$('body').on('click','.del_link', function(){
		ind = $(this).data('ind');
		post = 'ind='+ind+'&is_ajax=1';
			$.post('/webmaster_cabinet/see_offer/delLink', post, function(resp){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
					setTimeout(function(){
						location.reload();
					},500);
			}, 'json');
	});
});