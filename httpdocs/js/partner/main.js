$(function(){

	
pracent = 	$('input[name="sale_s"]').val();
start_delyvery = 	$('input[name="delivery"]').prop('checked');
$('.phonefield').mask('79999999999');
//$('.for_info_data_phone').mask('99999999999'); 
updatecolor();
				
				$.post('/partner_cabinet/getStatusBlock', 'is_ajax=1', function(resp){
					if(resp.response=='success'){
						status_block = resp.text;
					}
				}, 'json');
// status_block='<div id="status_block"><div class="close"></div><div class="gruop_status_1" data-value="new">Новый</div><div class="gruop_status_1" data-value="call">Звонок с сайта</div><div class="gruop_status_1" data-value="new_frod">Новый подозрение на фрод</div><div class="gruop_status_2" data-value="adopted">Принят</div><div class="gruop_status_2" data-value="call_back">Перезвонить</div><div class="gruop_status_2" data-value="pre_payment">Ждем предоплату</div><div class="gruop_status_2" data-value="coordinated">На согласовании</div><div class="gruop_status_3" data-value="courier">Курьер</div><div class="gruop_status_3" data-value="completed">Комплектуется</div><div class="gruop_status_3" data-value="equipped">Укомплектован</div><div class="gruop_status_3" data-value="awaiting_submission">Ожидает отправки</div><div class="gruop_status_3" data-value="awaiting_submission_cc">Ожидает отправки КЦ</div><div class="gruop_status_3" data-value="pending">Отложено</div><div class="gruop_status_4" data-value="sent">Отправлен</div><div class="gruop_status_4" data-value="delivered">Доставлен</div><div class="gruop_status_4" data-value="collector">Коллектор</div><div class="gruop_status_5" data-value="made">Выполнен</div><div class="gruop_status_5" data-value="presentation">Вручение</div><div class="gruop_status_5" data-value="payed">Оплачено</div><div class="gruop_status_5" data-value="return">Возврат</div><div class="gruop_status_5" data-value="compensation">Компенсация</div><div class="gruop_status_6" data-value="call_not">Недозвон</div><div class="gruop_status_6" data-value="double_unconfirmed">Не подтвержден дважды</div><div class="gruop_status_6" data-value="repeal">Отмена</div><div class="gruop_status_6" data-value="curiosities_double">Неформат/дубль</div><div class="gruop_status_6" data-value="not_satisfied">Не устроила клиента</div><div class="gruop_status_6" data-value="claims">Претензии</div></div>';
function updatecolor(){
	class_status_color=$('.select_status option:selected').attr('class');
	switch(class_status_color){
		case 'gruop_status_1':
			color = '#fedeae';
		break;
		case 'gruop_status_2':
			color = '#f2eda9';
		break;
		case 'gruop_status_3':
			color = '#d6e9a7';
		break;
		case 'gruop_status_4':
			color = '#c9ede2';
		break;
		case 'gruop_status_5':
			color = '#cfe1e7';
		break;
		case 'gruop_status_6':
			color = '#f9d6d6';
		break;
		case 'gruop_status_7':
			color = '#cfcfcf';
		break;
		default: color = '#eee';
	}
	$('.select_status').css({borderColor:color});
}

// var 	$region = $('[name="state"]'),
		// $zip = $('[name="index"]'),
		// $street = $('[name="street"]'),
		// $city = $('[name="city"]'),
		// $building = $('[name="house"]');

	// var $tooltip = $('.tooltip');

	// if($('[name="city"]').val()){
	  // $city = $('[name="city"]').val();
	// }
	
	// if($('[name="state"]').val()){
	  // $city = $('[name="state"]').val();
	// }
	$('body').on('click', '.go_on_us', function(){ 
		user_id = $(this).data('wm');
		alert('http://cpa-private.biz/main_cabinet/wm/changeHash?user_id='+user_id);
		// window.open('http://cpa-private.biz/main_cabinet/wm/changeHash?user_id='+user_id, '_blank');
		// $('#iframe iframe').attr('src','http://cpa-private.biz/main_cabinet/wm/changeHash?user_id='+user_id);
		// $('#iframe iframe').css({display: "block"});
		// if(wallet_id != 0){
			// post = 'user_id='+user_id+'&is_ajax=1';
			// $.post('/main_cabinet/wm/changeHash', post, function(resp){
				
			// }, 'json');
			// setTimeout(function(){
				// location.reload();
			// },300);
			
		
	});
	$('body').on('click', '#iframe span', function(){
		$('#iframe').css({display: "none"});
		$('#iframe iframe').attr('src','');
	});
	$('body').on('change', '.status_payments', function(){
		val = $(this).val();
		p_id = $(this).data('id');
		// if(wallet_id != 0){
			post = 'val='+val+'&p_id='+p_id+'&is_ajax=1';
			$.post('/main_cabinet/payments/updatestatus', post, function(resp){
				
			}, 'json');
			setTimeout(function(){
				location.reload();
			},300);
			
		
	});
	$("#orders table tr td textarea").keypress(function(e){
	     	   if(e.keyCode==13){
				   // alert('22222');
					$(this).trigger('change');
	     	   }
	     	 });
	$(".filters_block").keypress(function(e){
	     	   if(e.keyCode==13){
				   // alert('22222');
					$('#apply').trigger('click');
	     	   }
	     	 });
	
	// $.kladr.setDefault({
		// parentInput: '.block_right',
		// verify: true,
		// select: function (obj) {
			// console.log($(this));
			// setLabel($(this), obj.type);
			// $tooltip.hide();
		// },
		// check: function (obj) {
			// var $input = $(this);

			// if (obj) {
				// setLabel($input, obj.type);
				// $tooltip.hide();
			// }
			// else {
				// showError($input, 'Введено неверно');
			// }
		// },
		// checkBefore: function () {
			// var $input = $(this);

			// if (!$.trim($input.val())) {
				// $tooltip.hide();
				// return false;
			// }
		// }
	// });
	
	// $('input[name="fio_buyer"]').keydown(function (e) {
	$('body').keydown(function (e) {
		// if (e.which == 13) {//13 - это код клавиши "Enter"
			// $('#apply').trigger('click');
		// }
	});

	// console.log($city.kladr('type', $.kladr.type.city));
	// $region.kladr('type', $.kladr.type.region);
	// $street.kladr('type', $.kladr.type.street);
	// $building.kladr('type', $.kladr.type.building);
	// $city.kladr('type', $.kladr.type.city);
	// Отключаем проверку введённых данных для строений
	// $building.kladr('verify', false);

	// Подключаем плагин для почтового индекса
	// $zip.kladrZip();

	function setLabel($input, text) {
		text = text.charAt(0).toUpperCase() + text.substr(1).toLowerCase();
		$input.parent().find('label').text(text);
	}

	function showError($input, message) {
		$tooltip.find('span').text(message);

		var inputOffset = $input.offset(),
			inputWidth = $input.outerWidth(),
			inputHeight = $input.outerHeight();

		var tooltipHeight = $tooltip.outerHeight();

		$tooltip.css({
			left: (inputOffset.left + inputWidth + 10) + 'px',
			top: (inputOffset.top + (inputHeight - tooltipHeight) / 2 - 1) + 'px'
		});

		$tooltip.show();
	}

function citySelect(name){	
	post = 'q='+name;
	$.post("http://api.cdek.ru/city/getListByTerm/jsonp.php?callback=?", post, function(resp){	         
         $('#select_city').html($.map(resp.geonames, function(item) {
	 
			  // return{
	         //console.log('<li data-cityid="'+item.id+'">'+item.name+'</li>'); 
          // return '<li data-cityid="'+item.id+'">'+item.name+'</li>'; 
		   return '<li data-cityid="'+item.id+'">'+item.name+'</li>';
			  // }
	          }));
			  //console.log(aaa);
	}, 'json');
	
}
// $('input[name="city"]').on('keyup', function(){
	// name = $(this).val();	
	// if(name != null && name != '' && name != ' '){
		// city = citySelect(name);	
		// console.log(city);
		
	// }	
	
// });
$('body').on('click','#select_city li', function(){
	cityid = $(this).data('cityid');
	name = $(this).text();
	cn = name.split(',');
	console.log(cn);
	$('input[name="city"]').val(cn[0].trim());
	if(cn[1] != null){
		$('input[name="state"]').val(cn[1].trim());
	}
	if(cn[2] != null){
		$('input[name="country"]').val(cn[2].trim());
	}
	$('#receiverCityId').val(cityid);
	$('#select_city').html('');	
});
$('select[name="status"]').on('change', function(){
	updatecolor();
});

	$('.goout').on('click', function(){
			post = $(this).serialize();
			post += 'exit=1&is_ajax=1';
			$.post('/goout', post, 'json');	
			setTimeout(function(){
				window.location.reload();
			}, 500);
				
	});
	
	$( ".datepicker" ).datepicker({
		dateFormat:"dd.mm.yy",
		 //changeMonth: true,
		changeYear: true,
		monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь', 'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'], 
		monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн', 'Июл','Авг','Сен','Окт','Ноя','Дек'], 
		dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'], 
		dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'], 
		dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб']
	 });
	 $( ".datepicker_delivery" ).datepicker({
		dateFormat:"yy-mm-dd",
		 //changeMonth: true,
		changeYear: true,
		monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь', 'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'], 
		monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн', 'Июл','Авг','Сен','Окт','Ноя','Дек'], 
		dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'], 
		dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'], 
		dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб']
	 });
	$('#hidden').on('click',function(){
		action=$('#hidden').data('action');
		switch(action){
			case 'hidden':
			$('.filters_block').css({minHeight: '0px', height: '0px'});
			$('#hidden').data('action', 'show');
			break;
			case 'show':
				$('.filters_block').css({minHeight: '120px', height: 'auto'});
				$('#hidden').data('action', 'hidden');
			break;
		}
	});
	/*$('#apply').on('click',function(){
		id_order = $('input[name="id_order"]').val();
		status = $('input[name="status"]').val();
		date_start = $('input[name="date_start"]').val();
		date_end = $('input[name="date_end"]').val();
		wm_id = $('input[name="wm_id"]').val();
		sum_start = $('input[name="sum_start"]').val();
		offer_id = $('input[name="offer_id"]').val();
		
	})*/;
	$('div.icon').on('click', function(){
		$('.hidden_filters').css({display: 'block'});
		setTimeout(function(){
			$('.hidden_filters').css({opacity: '1'});
		},10);
	});
	$('.close').on('click', function(){
		$('.hidden_filters').css({opacity: '0'});
		setTimeout(function(){
			$('.hidden_filters').css({display: 'none'});
		},500);
	});
	$('#information').on('click', function(e){
			if(e.target != this){
			}else{
				if($('div').is('#map')){
					$('#map').remove();
				}
			}
	});
        $('body').on('click','#pages div a',function(){
            $('#pages div a').removeClass('sel');
            $(this).addClass('sel');
           p=$(this).data('page');
           s=$(this).data('size');
           source = $('#apply').data('source');
           flt(source,p,s);
        });
	$('#apply').on('click',function(){
		source = $(this).data('source');
                flt(source);
            });
        
        function flt(source, p, s){
            if(!p){
                p=1;
            }
			if(!s){
                s=30;
            }
        switch(source){
			case 'warehouse':				
				name = $('select[name="name"]').val();			
				goods_id = $('select[name="goods_id"]').val();				
				purchase_price_start = $('input[name="purchase_price_start"]').val();
				purchase_price_end = $('input[name="purchase_price_end"]').val();
				barcode = $('input[name="barcode"]').val();
				date_start = $('input[name="date_start"]').val();
				date_end = $('input[name="date_end"]').val();
				count = $('input[name="count"]').val();
				price_start = $('input[name="price_start"]').val();
				price_end = $('input[name="price_end"]').val();
				
				post = 'name='+name+'&goods_id='+goods_id+'&purchase_price_start='+purchase_price_start+'&purchase_price_end='+purchase_price_end+'&barcode='+barcode+'&date_start='+date_start+'&date_end='+date_end+'&count='+count+
				'&price_start='+price_start+'&price_end='+price_end+'&is_ajax=1';
				
				$.post('/partner_cabinet/warehouse/filter', post, function(resp){
					if(resp.response=='success'){
						$('#goods').html(resp.text);
					}else if(resp.response=='error'){
						$('#information .content p').text(resp.text);
						$('#information').css('display','block');
					}
				}, 'json');
			break;
			default:
			id_order = $('input[name="id_order"]').val();
			status = $('select[name="status"]').val();
			goods_id = $('select[name="goods_id"]').val();
			date_start = $('input[name="date_start"]').val();
			fio_buyer = $('input[name="fio_buyer"]').val();
			phone = $('input[name="phone"]').val();
			date_end = $('input[name="date_end"]').val();
			wm_id = $('select[name="wm_id"]').val();
			sum_start = $('input[name="sum_start"]').val();
			sum_end = $('input[name="sum_end"]').val();
			offer_id = $('select[name="offer_id"]').val();		
			manager = $('input[name="manager"]').val();		
			shop = $('input[name="shop"]').val();		
			target = $('input[name="target"]').val();
                        type_order_by = $('input[name="type_order_by"]').val();
                        col_order_by = $('input[name="col_order_by"]').val();
                        t='';
                        if (typeof type_order_by !== "undefined") {
                            t += '&type_order_by='+type_order_by;
                        }
                        if (typeof col_order_by !== "undefined") {
                            t += '&col_order_by='+col_order_by;
                        }
			post = 'size='+s+'&limit='+p+'&id_order='+id_order+'&fio_buyer='+fio_buyer+'&target='+target+'&manager='+manager+'&shop='+shop+'&phone='+phone+'&goods_id='+goods_id+'&status='+status+'&date_start='+date_start+'&date_end='+date_end+'&wm_id='+wm_id+'&sum_start='+sum_start+'&sum_end='+sum_end+'&offer_id='+offer_id+'&is_ajax=1'+t;
			$.get( '/partner_cabinet/filter',post, function( resp){
				if(resp.success==1){
					$('#orders table').html(resp.text);
                                        $('#pages div').html(resp.pages);
				}else if(resp.error==1){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
				}
								
			}, 'json');
//			$.post('/partner_cabinet/filter', post, function(resp){
//				if(resp.success==1){
//					$('#orders table').html(resp.text);
//				}else if(resp.error==1){
//					$('#information .content p').text(resp.text);
//					$('#information').css('display','block');
//				}
//								
//			}, 'json');
		}
	}
	$('#send_order_form select[name="offer_id"]').on('change', function(){	
		offer_id = $(this).val();
		if(offer_id!='all'){
				post='offer_id='+offer_id;
				$.post('/partner_cabinet/getgoodsbyofferid', post, function(resp){
						if(resp.response=='success'){
							$('#send_order_form select[name="goods_id"]').html(resp.text);
							$('#send_order_form select[name="goods_id"]').prop('disabled', false);
							
						}else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}
				}, 'json');
			}else{
				$('#information .content p').text('Выберите оффер!');
				$('#information').css('display','block');
			}
	});
	
	$('#send_order_form').on('submit', function(e){
		e.preventDefault();	
		post = $(this).serialize();
		post += '&is_ajax=1';
				$.post('/partner_cabinet/addorder', post, function(resp){
						if(resp.response=='success'){
							$('#information .content p').text('Заказа №'+resp.text+' добавлен!');
							setTimeout(function(){
								window.location.reload();
							}, 1000);
							$('#information').css('display','block');
							
						}else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}
				}, 'json');
			
	});
	$('input[name="phone"]').on('change', function(e){
		phone = $(this).val();
		classname = e.target.className;
		if(classname !='for_filter'){
		post = 'phone_number='+phone+'&is_ajax=1';
				$.post('/partner_cabinet/getinfobyphonenumber', post, function(resp){
						if(resp.response=='success'){
							$('#operator').val('Оператор: '+resp.operator);
							$('#state').val('Регион: '+resp.state);							
						}else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}
				}, 'json');
		}
	});
	
/*	$('input[name="adr"]').on('keyup', function(){
		if($(this).val() != '' && $(this).val() != ' '){
			post = 'adr='+$(this).val()+'&is_ajax=1';
				$.post('/partner_cabinet/getInfoAddress', post, function(resp){
						if(resp.response=='success'){
							console.log(resp.adr);						
						}else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}
				}, 'json');
		}
		
	});
	*/
	$('input[name="search"]').on('change', function(){
		if($(this).val() != '' && $(this).val() != ' '){
			post = 'adr='+$(this).val()+'&is_ajax=1';
				$.post('/partner_cabinet/getInfoAddress', post, function(resp){
						if(resp.response=='success'){
							$('input[name="country"]').val(resp.country);						
							$('input[name="state"]').val(resp.state);						
							$('input[name="city"]').val(resp.city);						
							$('input[name="street"]').val(resp.street);						
							$('input[name="house"]').val(resp.house);						
							$('input[name="flat"]').val(resp.flat);						
							$('input[name="index"]').val(resp.index);						
						}else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}
				}, 'json');
		}
	});
	
	$('.dop_button').on('click', function(){
		historyby = $(this).data('historyby');		
		switch(historyby){
			case 'add_phone':
				show = $(this).data('show');
				switch(show){
					case 'show':
						$('#extension_phone').css({display: 'block'});
						$(this).data('show','hidde');
					break;
					case 'hidde':
						$('#extension_phone').css({display: 'none'});
						$(this).data('show','show');
					break;
				}
			break;
			case 'post_office':
			ind = $('input[name="index"]').val();
				if(ind != '' && ind != ' '){
			post = 'index='+ind+'&is_ajax=1';
				$.post('/partner_cabinet/searchNearestPostOffice', post, function(resp){
						if(resp.response=='success'){
							text = 'Отделение: <b>'+resp.name+'</b><br>'+
							'Адрес: <b>'+resp.address+'</b><br>'+
							'Телефон: <b>'+resp.phone+'</b><br>';
							$('#information .content p').css({fontSize: '15px', textAlign: 'left'});
							$('#information .content p').html(text);
							if($('div').is('#map')){
								
							}else{
								$('#information .content').append('<div id="map"></div>');
							}
							ymaps.ready(function () {
								var myMap = new ymaps.Map('map', {
										center: [resp.pos2, resp.pos1],
										zoom: 15
									}, {
										searchControlProvider: 'yandex#search'
									}),
									myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
										hintContent: resp.name
									});

								myMap.geoObjects.add(myPlacemark);
							});
							$('#information').css('display','block');					
						}else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}
				}, 'json');
				}
			break;
			case 'middle_name':
				middle_name = $('input[name="middle_name"]').val();
				post = 'history_by=params&value='+middle_name+'&is_ajax=1';
				$.post('/partner_cabinet/history', post, function(resp){
						if(resp.response=='success'){
							$('#history .content').html(resp.block);
							$('#history').css('display','block');					
						}else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}
				}, 'json');
			break;
			case 'phone':
				phone = $('input[name="phone"]').val();
				post = 'history_by=params&value='+phone+'&is_ajax=1';
				$.post('/partner_cabinet/history', post, function(resp){
						if(resp.response=='success'){
							$('#history .content').html(resp.block);
							$('#history').css('display','block');					
						}else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}
				}, 'json');
			break;
			case 'ip':
				ip = $('input[name="ip"]').val();
				post = 'history_by=ip&value='+ip+'&is_ajax=1&des=ip';
				$.post('/partner_cabinet/history', post, function(resp){
						if(resp.response=='success'){
							$('#history .content').html(resp.block);
							$('#history').css('display','block');					
						}else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}
				}, 'json');
			break;
			case 'address':
				street = $('input[name="street"]').val();
				house = $('input[name="house"]').val();
				flat = $('input[name="flat"]').val();
				if(street != "" && street!=" " && house != "" && house!=" " && flat != "" && flat!=" "){
					post = 'street='+street+'&house='+house+'&flat='+flat+'&is_ajax=1';
					$.post('/partner_cabinet/historyadr', post, function(resp){
							if(resp.response=='success'){
								$('#information .content p').text(resp.text);
								$('#information').css('display','block');				
							}else if(resp.response=='error'){
								$('#information .content p').text(resp.text);
								$('#information').css('display','block');
							}
					}, 'json');
				}else{
					$('#information .content p').text('Укажите адрес');
					$('#information').css('display','block');
				}
			break;
			case 'track_number':
				track_number = $('input[name="track_number"]').val();
				post = 'track_number='+track_number+'&is_ajax=1';
				$.post('/partner_cabinet/trackingInfo', post, function(resp){
						if(resp.response=='success'){
							$('#history .content').html(resp.block);
							$('#history').css('display','block');	
						}else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}
				}, 'json');
			break;
			case 'offer':
				$('#add_new_offers').css({display: 'block'});
			break;	
			case 'category':
				$('.category').css({display: 'block'});
			break;	
		}
		
	});
	o_id=0;
	$('body').on('dblclick','#orders table tr', function(e){
		element = e.target.nodeName;	
		o_id = $(this).data('order_id');
		if(element != "TEXTAREA" && element != "TH" && element != "SPAN" && element != "DIV" && element != "INPUT"){
			window.location.href='/partner_cabinet/edit_order?order_id='+$(this).data('order_id');
			// window.open('/partner_cabinet/edit_order?order_id='+$(this).data('order_id') , '_blank')
		}
		
	});
	$('body').on('click','#goods table tr', function(e){
		element = e.target.nodeName;	
		if(element != "TEXTAREA" && element != "TH" && element != "SPAN" && element != "DIV" && element != "INPUT"){
			window.location.href='/partner_cabinet/edit_goods?goods_id='+$(this).data('goods_id');
		}		
	});
	$('body').on('change','#orders table tr td textarea', function(e){
		comment = $(this).val();
               o_id=$(this).parent().parent().data('order_id');
		post = 'comment='+encodeURIComponent(comment)+'&order_id='+o_id+'&is_ajax=1';
				$.post('/partner_cabinet/quickEdit', post, function(resp){
						if(resp.response=='success'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');	
						}else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}
				}, 'json');
		
		
	});
	$('body').on('change','input[name="track_number"]', function(e){
		a = window.location.toString();
		b = a.split('/');
		c = b[b.length-1].split('?')[0];
	
		if(c == 'edit_order'){
			track_number = $(this).val();
			o_id = $('#oid').text();
			post = 'track_number='+track_number+'&order_id='+o_id+'&is_ajax=1&table=info_orders';
				$.post('/partner_cabinet/quickEdit', post, function(resp){
						if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}
				}, 'json');
		}		
		
		
	});
	/*$(document).click( function(event){
      if( $(event.target).closest("#status_block").length ) 
        return;
      $("#status_block").remove();
      event.stopPropagation();
    });*/ 
	cli = 0;
	h_d = 0;
	$(document).on('click','body',function(event){
		if( $(event.target).closest(".h_d").length || $(event.target).closest(".a").length ) 
        return;
		if(h_d == 1){ 
			$(".h_d").css({display: 'none'});
			h_d = 0;
		}
      event.stopPropagation();
	});
	$(document).on('click','body',function(event){
		if( $(event.target).closest(".h_p").length || $(event.target).closest(".h").length || $(event.target).closest(".b").length ){ 
        return;
		}else{		
			$(".h_p, .h").css({display: 'none'});
		}
      event.stopPropagation();
	});
	
	$('body').on('click','#orders table td:nth-child(14) span', function(e){
		if($("div").is("#status_block")){ 
			$("#status_block").remove();
			$('#orders').css({paddingBottom: '0'});
		
		}else{
			$('#orders').css({paddingBottom: '150px'});
			$(this).parent().append(status_block); 
			setTimeout(function(){
				cli = 1;
			}, 500)
		}
	});
	$('body').on('click','#status_block div', function(e){
		o_id = $(this).parent().parent().parent().data('order_id');
		class_status_color = $(this).attr('class');//css('background');
		switch(class_status_color){
			case 'gruop_status_1':
				color = '#fedeae';
			break;
			case 'gruop_status_2':
				color = '#f2eda9';
			break;
			case 'gruop_status_3':
				color = '#d6e9a7';
			break;
			case 'gruop_status_4':
				color = '#c9ede2';
			break;
			case 'gruop_status_5':
				color = '#cfe1e7';
			break;
			case 'gruop_status_6':
				color = '#f9d6d6';
			break;
			default: color = '#eee';
		}
		$('#status_block').prev().css('background',color);		
		status = $(this).data('value');
		$('#status_block').prev().text($(this).text());		
		if(status == 'sent'){			
			var oids = new Array(); 										
			oids.push(o_id);
			
			post = 'order_ids='+JSON.stringify(oids)+'&type=1&is_ajax=1';
			// $.post('/partner_cabinet/sendSms', post, function(resp){		
				// $('#information .content p').text(resp.text);
						// $('#information').css('display','block');								
			// }, 'json');
		}else if(status == 'delivered'){
			var oids = new Array(); 										
			oids.push(o_id);
			
			post = 'order_ids='+JSON.stringify(oids)+'&type=2&is_ajax=1';
			// $.post('/partner_cabinet/sendSms', post, function(resp){		
				// $('#information .content p').text(resp.text);
						// $('#information').css('display','block');								
			// }, 'json');
		}else if(status == 'collector'){
			var oids = new Array(); 										
			oids.push(o_id);
			
			post = 'order_ids='+JSON.stringify(oids)+'&type=5&is_ajax=1';
			// $.post('/partner_cabinet/sendSms', post, function(resp){		
				// $('#information .content p').text(resp.text);
						// $('#information').css('display','block');								
			// }, 'json');
		}
		post = 'status='+status+'&order_id='+o_id+'&is_ajax=1';
				$.post('/partner_cabinet/quickEdit', post, function(resp){
						if(resp.response=='success'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');	
							$('#status_block').remove();	
						}else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}
				}, 'json');
				
				
		
	});
	$('body').on('click','.status_block div', function(e){
		var selectedItems = new Array();
		$(".select_order:checked").each(function() {selectedItems.push($(this).val());});	
		// '&order_ids='+JSON.stringify(selectedItems);
		status = $(this).data('value');
		if(status == 'sent'){			

			post = 'order_ids='+JSON.stringify(selectedItems)+'&type=1&is_ajax=1';
			$.post('/partner_cabinet/sendSms', post, function(resp){		
				console.log(resp.text);									
			}, 'json');
		}else if(status == 'delivered'){

			post = 'order_ids='+JSON.stringify(selectedItems)+'&type=2&is_ajax=1';
			$.post('/partner_cabinet/sendSms', post, function(resp){		
				console.log(resp.text);									
			}, 'json');
		}else if(status == 'collector'){

			post = 'order_ids='+JSON.stringify(selectedItems)+'&type=5&is_ajax=1';
			$.post('/partner_cabinet/sendSms', post, function(resp){		
				console.log(resp.text);									
			}, 'json');
		}
		// console.log(selectedItems);
		
		$('#status_block').prev().text($(this).text());		
		post = 'status='+status+'&m_o=1&order_id='+JSON.stringify(selectedItems)+'&is_ajax=1';
				$.post('/partner_cabinet/quickEdit', post, function(resp){
						if(resp.response=='success'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');	
							$('#status_block').remove();	
							setTimeout(function(){
								location.reload();
							}, 150);
						}else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}
				}, 'json');
				
				
		
	});
	$('select[name="status"]').on('change', function(){
		$( "#update_add_info" ).trigger( "click" );

		a = window.location.toString();
		b = a.split('/');
		c = b[b.length-1];
		d = c.split('?');
		e = d[1].split('=');
		oid = e[e.length-1];
		status = $(this).val();
		if(d[0] == 'edit_order'){
			var oids = new Array();
			oids.push(oid);
			if(status == 'sent'){	 																
			post = 'order_ids='+JSON.stringify(oids)+'&type=1&is_ajax=1';
			$.post('/partner_cabinet/sendSms', post, function(resp){		
				$('#information .content p').text(resp.text);
						$('#information').css('display','block');								
			}, 'json');
		}else if(status == 'delivered'){
			post = 'order_ids='+JSON.stringify(oids)+'&type=2&is_ajax=1';
			$.post('/partner_cabinet/sendSms', post, function(resp){		
				$('#information .content p').text(resp.text);
						$('#information').css('display','block');								
			}, 'json');
		}else if(status == 'collector'){
			post = 'order_ids='+JSON.stringify(oids)+'&type=5&is_ajax=1';
			$.post('/partner_cabinet/sendSms', post, function(resp){		
				$('#information .content p').text(resp.text);
						$('#information').css('display','block');								
			}, 'json');
		}
		
			post = 'status='+status+'&order_id='+oid+'&is_ajax=1';
				$.post('/partner_cabinet/quickEdit', post, function(resp){
						
				}, 'json');
		}
	});
	$('input[name="delivery"]').on('change', function(){
		a = window.location.toString();
		b = a.split('/');
		c = b[b.length-1];
		d = c.split('?');		
		delivery = $(this).prop('checked');
		
			if(delivery == true){
				delivery = 1;
				$('#all_price').text(parseInt($('#all_price').text())+350);
			}else{
				delivery=0;
				$('#all_price').text(parseInt($('#all_price').text())-350);
			}
		
		if(d[0] == 'edit_order'){
			e = d[1].split('=');
			oid = e[e.length-1];
			post = 'table=info_orders&delivery='+delivery+'&upd_order_sum=1&order_id='+oid+'&is_ajax=1';
				$.post('/partner_cabinet/quickEdit', post, function(resp){
					
				}, 'json');
		}
	});
	$('.show_img').on('click', function(){
		action = $(this).data('action');
		switch(action){
			case 'show':	
				$('.all_img').css({display: 'inline-block'});
				$(this).data('action','hidde');				
				$(this).text('Скрыть картинки');
			break;
			case 'hidde':
				$('.all_img').css({display: 'none'});
				$(this).data('action','show');
				$(this).text('Отобразить картинки');
			break;
		}
	});
	$('input[name="sale_s"],input[name="sale_f"]').on('change', function(){
		a = window.location.toString();
		b = a.split('/');
		c = b[b.length-1];
		d = c.split('?');		
		sale = $(this).val();
		sale_type = $(this).data('sale_type');
		// if(sale_type == 1){
			// if(sale == 0){
				// $('#all_price').text(parseInt($('#all_price').text())+(parseInt(pracent)*0.01)*parseInt($('#all_price').text()));
				// if(parseInt($('input[name="sale_f"]').val()) == 0){
					// sale_type = 0;
				// }
			// }else{
				// $('#all_price').text((parseInt(sale)*0.01)*parseInt($('#all_price').text()));
				// pracent = sale;
				// if(parseInt($('input[name="sale_s"]').val()) == 0){
					// sale_type = 0;
				// }
			// }
		// }else{
			// $('#all_price').text(parseInt($('#all_price').text())-(parseInt(sale)));
		// }
		summa = 0;
		$("#goods_table table td:nth-child(5)").each(function() {summa += parseInt($(this).text());});
		if(sale_type == 1){
				
				if(sale == 0){								
					
					sale_sum = 0					
				}else{										
					sale_sum = (parseFloat(sale)*0.01)*parseFloat(summa).toFixed(1);										
				}
			}else{
				
				sale_sum = sale;
			}
		
		
		
		if(d[0] == 'edit_order'){
			e = d[1].split('=');
			oid = e[e.length-1];
			post = 'upd_order_sum=1&table=info_orders&sale='+sale+'&sale_type='+sale_type+'&order_id='+oid+'&is_ajax=1';
				$.post('/partner_cabinet/quickEdit', post, function(resp){
					if(resp.response=='success'){
						$('#all_price').text(resp.order_sum);	
					}else if(resp.response=='error'){
						$('#information .content p').text(resp.text);
						$('#information').css('display','block');
					}	
				}, 'json');
		}else{
			if(sale_type == 1){
				
				if(sale == 0){					
					
					$('#all_price').text(summa);
					sale_sum = 0
					if(parseInt($('input[name="sale_f"]').val()) == 0){
						sale_type = 0;
					}
					if($('input[name="delivery"]').prop('checked') == true){
						summa += 350;
					}	
				}else{					
					// $('#all_price').text(parseFloat($('#all_price').text())-(parseFloat(sale)*0.01)*parseFloat($('#all_price').text()));
					$('#all_price').text(parseFloat($('#all_price').text())-(parseFloat(sale)*0.01)*parseFloat(summa));
					sale_sum = (parseFloat(sale)*0.01)*parseFloat(summa).toFixed(1);
					pracent = sale;
					if(parseInt($('input[name="sale_s"]').val()) == 0){
						sale_type = 0;
					}
				}
			}else{
				$('#all_price').text(parseFloat($('#all_price').text())-(parseFloat(sale)));
				sale_sum = sale;
			}
		}
		$('#sele_order').text(sale_sum);
	});
	$('#update_add_info').on('click', function(){
		order_id = $('#oid').text();
		a = window.location.toString();
		b = a.split('/');
		c = b[b.length-1];
		post_dop = '';
		if(c == 'new_order'){			
			offer_id = $('select[name="offer_id"').val();
			if($('input[name="delivery"').prop('checked') == true){
				delivery = 1;
			}else{
				delivery = 0;
			}
			if($('input[name="sale_s"').val() != 0){
				sale_type = 1;
				sale = $('input[name="sale_s"').val();
			}else if($('input[name="sale_f"').val() != 0){
				sale_type = 2;
				sale = $('input[name="sale_f"').val();				
			}else{
				sale_type = 0;
				sale = 0;
			}
			post_dop = '&delivery='+delivery+'&sale_type='+sale_type+'&sale='+sale;
		}else{
			offer_id = $('.offer_id').text();
		}
		
		middle_name = $('input[name="middle_name"]').val();
		first_name = $('input[name="first_name"]').val();
		last_name = $('input[name="last_name"]').val();
		ip = $('input[name="ip"]').val();
		status = $('select[name="status"]').val();
		otpravitel = $('select[name="otpravitel"]').val();
		track_number = $('input[name="track_number"]').val();
		country = $('input[name="country"]').val();
		state = $('input[name="state"]').val();
		city = $('input[name="city"]').val();
		house = $('input[name="house"]').val();
		flat = $('input[name="flat"]').val();
		index = $('input[name="index"]').val();		
		street = $('input[name="street"]').val();		
		phone = $('input[name="phone"]').val();		
		comment = encodeURIComponent($('textarea[name="comment"]').val());		
		goods = $('#select_goods').val();		
		
		
		post = 'middle_name='+middle_name+
		'&first_name='+first_name+
		'&last_name='+last_name+
		'&ip='+ip+
		'&status='+status+
		'&sender='+otpravitel+
		'&track_number='+track_number+
		'&country='+country+
		'&state='+state+
		'&city='+city+
		'&street='+street+
		'&house='+house+
		'&flat='+flat+
		'&index='+index+
		'&order_id='+order_id+
		'&offer_id='+offer_id+
		'&phone='+phone+
		'&comment='+comment+
		'&goods='+goods+
		'&is_ajax=1';
		if(post_dop != ''){
			post += post_dop;
		}
		if($('#extension_phone').css('display') == 'block'){
			var e_phone = new Array();
			$(".e_phone").each(function() {
				if($(this).val() != '' && $(this).val() != ' '){
					e_phone.push($(this).val());
				}
			});	
			post += '&e_phone='+JSON.stringify(e_phone);
		}
			
		
				$.post('/partner_cabinet/insertUpdateOrder', post, function(resp){
						if(resp.response=='success'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');	
							if(c == 'new_order'){
								setTimeout(function(){
								// alert('/partner_cabinet/edit_order?order_id='+resp.o_id);
								// console.log(resp.o_id);
								location.href ='/partner_cabinet/edit_order?order_id='+resp.o_id;
							}, 500);
							}
							
						}else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}
				}, 'json');
		
	});
	$('#add_new_offers .icon-close').on('click', function(){
		$('#add_new_offers').css({display: 'none'});
		$('.category').css({display: 'none'});
	});
	
	$('#add_offers').on('submit', function(e){		
		e.preventDefault();	
		post = $(this).serialize();
		post += '&is_ajax=1&partner_id='+$('input[name="partner_id"]').val();
		$.post('/partner_cabinet/addoffer', post, function(resp){
			if(resp.response=='success'){
				$('#information .content p').text(resp.text);				
				$('#information').css('display','block');	
				$('select[name="offer_id"]').prop('selected', false);
				$('select[name="offer_id"]').prepend('<option value="'+resp.offer_id+'" selected>'+resp.offer_id+'</option>');				
				$('#add_new_offers').css({display:'none'});
			}else if(resp.response=='error'){
				$('#information .content p').text(resp.text);
				$('#information').css('display','block');
			}
		}, 'json');			
	});
	$('#add_category').on('submit', function(e){		
		e.preventDefault();	
		post = $(this).serialize();
		post += '&is_ajax=1';
		$.post('/partner_cabinet/warehouse/setcategory', post, function(resp){
			if(resp.response=='success'){
				$('select[name="category_id"]').append(resp.option);
				$('#information .content p').text('Категория добавлена');
				$('#information').css('display','block');
			}else if(resp.response=='error'){
				$('#information .content p').text(resp.text);
				$('#information').css('display','block');
			}
		}, 'json');			
	});
	
	$('#add_apical, #add_goods').on('click', function(evt){
		a = window.location.toString();
		b = a.split('/');
		c = b[b.length-1];
		if(c == 'new_goods'){
			img = $('input[name="img"]').val();
			name = $('input[name="name"]').val();
			price = $('input[name="price"]').val();
			purchase_price = $('input[name="purchase_price"]').val();
			currency = 1;//$('select[name="currency"]').val();
			offer_id = $('select[name="offer_id"]').val();
			count = $('input[name="count"]').val();
			weight = $('input[name="weight"]').val();
			height = $('input[name="height"]').val();
			width = $('input[name="width"]').val();
			znach_long = $('input[name="long"]').val();
			barcode = $('input[name="barcode"]').val();
			link_site = $('input[name="link_site"]').val();
			shop = $('input[name="shop"]').val();
			// description = $('textarea[name="description"]').val();
			apical = 0;
		}else{		
			img = $('input[name="a_img"]').val();
			name = $('input[name="a_name"]').val();
			price = $('input[name="a_price"]').val();
			purchase_price = $('input[name="a_purchase_price"]').val();
			currency = 1;//$('select[name="currency"]').val();
			offer_id = $('select[name="a_offer_id"]').val();
			count = $('input[name="a_count"]').val();
			weight = $('input[name="a_weight"]').val();
			height = $('input[name="a_height"]').val();
			width = $('input[name="a_width"]').val();
			znach_long = $('input[name="a_long"]').val();
			barcode = $('input[name="a_barcode"]').val();
			apical = $('input[name="apical"]').val();
			link_site ='';
			shop='';
		}
		if($(this).attr('id') == 'add_apical'){
			description = $('textarea[name="a_description"]').val();		
		}else{
			description = $('textarea[name="description"]').val();
		}
		
		post = 'img='+img+
		'&name='+name+
		'&description='+description+
		'&price='+price+
		'&purchase_price='+purchase_price+
		'&currency='+currency+
		'&count='+count+
		'&weight='+weight+
		'&height='+height+
		'&width='+width+
		'&long='+znach_long+		
		'&barcode='+barcode+		
		'&offer_id='+offer_id+		
		'&apical='+apical+		
		'&site_link='+link_site+		
		'&shop='+shop+		
		'&is_ajax=1';
		$.post('/partner_cabinet/new_goods/addgoods', post, function(resp){
						if(resp.response=='success'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');	
							setTimeout(function(){
								window.location.href="/partner_cabinet/warehouse";
							},200);
						}else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}
		}, 'json');
		

	});
	$('#clearfilter').on('click',function(){
           window.location.reload(); 
        });
	$('#edit_goods').on('click', function(){
		goods_id = $('#oid').text();
		name = $('input[name="name"]').val();
		price = $('input[name="price"]').val();
		purchase_price = $('input[name="purchase_price"]').val();
		// currency = $('select[name="currency"]').val();
		 currency = 1;//$('select[name="currency"]').val();
		offer_id = $('select[name="offer_id"]').val();
		count = $('input[name="count"]').val();
		weight = $('input[name="weight"]').val();
		height = $('input[name="height"]').val();
		width = $('input[name="width"]').val();
		znach_long = $('input[name="long"]').val();
		barcode = $('input[name="barcode"]').val();
		link_site = $('input[name="link_site"]').val();
		category_id = $('select[name="category_id"]').val();
		shop = $('input[name="shop"]').val();
		description = $('textarea[name="description"]').val();		
		
		post = 'name='+name+
		'&description='+description+
		'&goods_id='+goods_id+
		'&price='+price+
		'&purchase_price='+purchase_price+
		'&currency='+currency+
		'&count='+count+
		'&weight='+weight+
		'&height='+height+
		'&width='+width+
		'&long='+znach_long+		
		'&barcode='+barcode+		
		'&offer_id='+offer_id+		
		'&category_id='+category_id+		
		'&site_link='+link_site+		
		'&shop='+shop+		
		'&is_ajax=1';
		$.post('/partner_cabinet/edit_goods/updateInfoGoods', post, function(resp){
						if(resp.response=='success'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');					
						}else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}
		}, 'json');
		

	});
	$('.fh.fr').on('change', function(){
		filtr = $(this).data('filter');
		display = $('.filter.hidde[data-filtr="'+filtr+'"]').css('display');
		if(display == 'inline-block'){
			$('.filter.hidde[data-filtr="'+filtr+'"]').css('display', 'none');
		}else{
			$('.filter.hidde[data-filtr="'+filtr+'"]').css('display', 'inline-block');
		}
	});
	$('.fh.ds').on('change', function(){		
		filtr = $(this).data('filter');
		display = $('.t.'+filtr).css('display');
		if(display == 'table-cell'){
			$('.t.'+filtr).css('display', 'none');
		}else{
			$('.t.'+filtr).css('display', 'table-cell');
		}
	});
	
	$('.all_img img').on('click', function(){
		img_path = $(this).attr('src');
		// goods_id = $('#oid').text();
		img = img_path.split('/');
		// post = 'img='+img[img.length-1]+	
		// '&goods_id='+goods_id+
		// '&is_ajax=1';
		// $.post('/partner_cabinet/edit_goods/updateInfoGoods', post, function(resp){
						// if(resp.response=='success'){
							// $('.goods_img').attr('src',img_path);				
						// }else if(resp.response=='error'){
							// $('#information .content p').text(resp.text);
							// $('#information').css('display','block');
						// }
		// }, 'json');
		post = 'img='+img[img.length-1]+	
		'&is_ajax=1';
		$.post('/partner_cabinet/delImg', post, function(resp){
						if(resp.response=='success'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
							setTimeout(function(){
								location.reload();							
							}, 500); 
						}else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}
		}, 'json');
	});
	
	// $('body').on('change','#goods_table input',function(){
		// a = window.location.toString();
		// b = a.split('/');
		// c = b[b.length-1];
		// if(c == 'new_order'){
			// id = $(this).attr('id');
			// val = $(this).val();
			// count = parseInt($('#goods_id_'+id+' .count').text())+parseInt(val);
			// if(count>0){
				// $('#goods_id_'+id+' .count').text(count);
				// $('#sel_opt_'+id).val(id+':'+count);			
				
			// }else{
				// $('#goods_id_'+id).remove();
				// $('#sel_opt_'+id).remove();
			// }
			
			// $(this).val('');
		// }
	// });
	
	// $('body').on('click','#goodstable table tr',function(){
	$('body').on('click','.add',function(){
		good_id = $(this).data('goods_id');
		ap = $(this).parent().parent().attr('class');
						if(ap == 'apical'){
							yea = 1;
						}else{
							yea = 0;
						}
		if(good_id != 0){
			a = window.location.toString();
			b = a.split('/');
			c = b[b.length-1];
			if(c == 'new_order'){
				if(good_id != 0){
					if($('tr').is('#goods_id_'+good_id)){
						$('#goods_id_'+good_id+' .count').text(parseInt($('#goods_id_'+good_id+' .count').text())+1);
					}else{
						post = 'goods_id='+good_id+'&is_ajax=1';
						$.post('/partner_cabinet/new_order/getGoodsInfo', post, function(resp){
										if(resp.response=='success'){
											
											if(yea == 1){
												co = $('.add[data-goods_id="'+good_id+'"]').parent().parent().prev().text().split(' ');
												$('.add[data-goods_id="'+good_id+'"]').parent().parent().prev().text(parseInt(co[0])-1+' шт.');
												if(co[0]==1){
													$('.add[data-goods_id="'+good_id+'"]').parent().addClass('not_goods');
													$('.add[data-goods_id="'+good_id+'"]').parent().parent().parent().addClass('not_goods');
												}
											}else{
												co = $('.add[data-goods_id="'+good_id+'"]').next().next().next().next().next().next().text().split(' ');
												$('.add[data-goods_id="'+good_id+'"]').next().next().next().next().next().next().text(parseInt(co[0])-1+' шт.');
												if(co[0]==1){
													$('.add[data-goods_id="'+good_id+'"]').parent().addClass('not_goods');
												}
											}
											if(co[0]==1){
												$('.add[data-goods_id="'+good_id+'"]').parent().addClass('not_goods');
											}
											$('#goods_table table').append(resp.text);
											// $('#all_price').text(parseInt($('#all_price').text())+parseInt(resp.price));
											$('#select_goods').append('<option id="sel_opt_'+resp.goods_id+'" value="'+resp.goods_id+':1" selected>товар</option>');	
											summa = 0;
											$("#goods_table table td:nth-child(5)").each(function() {summa += parseInt($(this).text());});
											
											per = parseInt($('input[name="sale_s"]').val());
											fix = parseInt($('input[name="sale_f"]').val());
											if(per != 0){
												sale = ((per*0.01)*summa).toFixed(1);
												summa -= (per*0.01)*summa;												
											}else if(fix != 0){
												summa -= parseInt($('input[name="sale_f"]').val());
												sale = $('input[name="sale_f"]').val();
											}
											if($('input[name="delivery"]').prop('checked') == true){
												summa += 350;
											}
											$('#all_price').html(summa);
																				
											$('#sele_order').html(sale);												
										}else if(resp.response=='error'){
											$('#information .content p').text(resp.text);
											$('#information').css('display','block');
										}
						}, 'json');
					}
				}
			}else{			
				order_id = $('#oid').text();
				if(good_id != 0){
					//if($('tr').is('#goods_id_'+good_id)){
						//$('#goods_id_'+good_id+' input[name="Goods[count]"]').val(parseInt($('#goods_id_'+good_id+' input[name="Goods[count]"]').val())+1);
					//}else{
						post = 'goods_id='+good_id+'&order_id='+order_id+'&count=1'+	
						'&is_ajax=1';
						
						$.post('/partner_cabinet/main/addGoodsInOrder', post, function(resp){
										if(resp.response=='success'){
											if(yea == 1){
												co = $('.add[data-goods_id="'+good_id+'"]').parent().parent().prev().text().split(' ');
												$('.add[data-goods_id="'+good_id+'"]').parent().parent().prev().text(parseInt(co[0])-1+' шт.');
												if(co[0]==1){
													$('.add[data-goods_id="'+good_id+'"]').parent().addClass('not_goods');
													$('.add[data-goods_id="'+good_id+'"]').parent().parent().parent().addClass('not_goods');
												}
											}else{
												co = $('.add[data-goods_id="'+good_id+'"]').next().next().next().next().next().next().text().split(' ');
												$('.add[data-goods_id="'+good_id+'"]').next().next().next().next().next().next().text(parseInt(co[0])-1+' шт.');
												if(co[0]==1){
													$('.add[data-goods_id="'+good_id+'"]').parent().addClass('not_goods');
												}
											}
											
											
											$('#goods_table table').append(resp.text);										
											summa = 0;
											$("#goods_table table td:nth-child(5)").each(function() {summa += parseInt($(this).text());});

											per = parseInt($('input[name="sale_s"]').val());
											fix = parseInt($('input[name="sale_f"]').val());
											if(per != 0){
												sale = ((per*0.01)*summa).toFixed(1);
												summa -= (per*0.01)*summa;											
												
											}else if(fix != 0){
												summa -= parseInt($('input[name="sale_f"]').val());
												sale = $('input[name="sale_f"]').val();
											}
											if($('input[name="delivery"]').prop('checked') == true){
												summa += 350;
											}
											$('#all_price').html(summa);																		
											$('#sele_order').html(sale);																		
										}else if(resp.response=='error'){
											$('#information .content p').text(resp.text);
											$('#information').css('display','block');
										}
						}, 'json');
					//}				
				}
			}
			
			$('#goodstable').css('display','none');	
			$('.modal-show').css('overflow','auto');
		}		
	});
		
	$('#cdek').on('submit', function(e){
		e.preventDefault();	
		post = $(this).serialize();
		post += '&is_ajax=1';
		$.post('/partner_cabinet/main/costDelivery', post, function(resp){
			if(resp.response=='success'){
				$('#delivery').html(resp.text);																		
			}else if(resp.response=='error'){
				$('#information .content p').text(resp.text);
				$('#information').css('display','block');
			}
		}, 'json');
	});
	
	  // $('input[name="city"]').autocomplete({
	    // source: function(request,response) {
	      // $.ajax({
	        // url: "http://api.cdek.ru/city/getListByTerm/jsonp.php?callback=?",
	        // dataType: "jsonp",
	        // data: {
	        	// q: function () { return $('input[name="city"]').val() },
	        	// name_startsWith: function () { return $('input[name="city"]').val() }
	        // },
	        // success: function(data) {
	          // response($.map(data.geonames, function(item) {
	            // return {
	              // label: item.name,
	              // value: item.name,
	              // id: item.id
	            // }
	          // }));
	        // }
	      // });
	    // },
	    // minLength: 1,
	    // select: function(event,ui) {
	    	// console.log("Yep!");
	    	// $('#senderCityId').val(ui.item.id);
	    // }
	  // });
	$('body').on('change','input[name="Goods[count]"]',function(){
		good_id = $(this).data('goods_id');
		a = window.location.toString();
		b = a.split('/');
		c = b[b.length-1];
		if(c == 'new_order'){
			
			count = $(this).val();
			if(count <= 0){
				$('#goods_id_'+good_id).remove();
				$('#sel_opt_'+good_id).remove();				
			}else{
				$('#sel_opt_'+good_id).val(good_id+':'+count);				
				$('#goods_id_'+good_id+' td:nth-child(5)').text(parseInt(count)*parseInt($('#goods_id_'+good_id+' td:nth-child(3)').text()));		
			}
				summa = 0;
				$("#goods_table table td:nth-child(5)").each(function() {summa += parseInt($(this).text());});
				
				per = parseInt($('input[name="sale_s"]').val());
				fix = parseInt($('input[name="sale_f"]').val());
				if(per != 0){
					sale = ((per*0.01)*summa).toFixed(1);
					summa -= (per*0.01)*summa;					
				}else if(fix != 0){
					summa -= parseInt($('input[name="sale_f"]').val());
					sale = $('input[name="sale_f"]').val();
				}
				if($('input[name="delivery"]').prop('checked') == true){
					summa += 350;
				}
				$('#all_price').text(summa);
				$('#sele_order').text(sale);

		}else{
			count = $(this).val();
			id = $($('input[name="Goods[count]"]').parents().get(1)).attr('id').split('_');
			id = $($(this).parents().get(1)).attr('id').split('_');
			goods_id = id[id.length-1];
			order_id = $('#oid').text();
			post = 'goods_id='+goods_id+'&order_id='+order_id+'&count='+count;
			post += '&is_ajax=1';
			
			
			$.post('/partner_cabinet/main/incDecAmountGoods', post, function(resp){
				if(resp.response=='success'){
					$('#goods_table table').html('<tr><th>название</th><th>артикул</th><th>цена</th><th>количество</th><th>прибавить(шт.)</th></tr>'+resp.text);																		
					$('#all_price').text(resp.all_price);																		
					$('#goodstable .content table').html(resp.tgoods);																		
				}else if(resp.response=='error'){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
					setTimeout(function(){
						location.reload();
					}, 500);
				}
			}, 'json');
		}
	});
	$('.kladr').on('change', function(){		
		city = $('input[name="city"]').val();
		street = $('input[name="street"]').val();
		house = $('input[name="house"]').val();
		
		if(city !="" && city !=" " && street !="" && street !=" " && house !="" && house !=" "){
			post = 'city='+city+'&street='+street+'&house='+house;
		post += '&is_ajax=1';
		console.log(post);
		$.post('/partner_cabinet/getInfoAdr', post, function(resp){
			console.log(resp);
			if(resp.response=='success' && resp.zip != null){
				
				$('input[name="index"]').val(resp.zip);																		
			}
		}, 'json');
		}
	});
	
	$('#add_manager').on('submit', function(e){
		e.preventDefault();	
		post = $(this).serialize();
		$.post('/partner_cabinet/managers/addmanagers', post, function(resp){
				$('#information .content p').text(resp.text);
				$('#information').css('display','block');
				setTimeout(function(){
					window.location.reload();
				},200);
		}, 'json');
	});
	
	$('#b_c').on('click', function(){
		action = $(this).data('action');
		switch(action){
			case 'show':
				$('#b').css({height: '800px', width: 'auto'});
				$(this).data('action', 'hide');
				$('#b_c i').css({transform: 'rotate(180deg)'});
				$('#orders table').css({paddingLeft: '190px'});
				
			break;
			case 'hide':
				$('#b').css({height: '20px', width: '30px'});
				$(this).data('action', 'show');
				$('#b_c i').css({transform: 'rotate(0deg)'});
				$('#orders table').css({paddingLeft: '0px'});
			break;
		}
	});
	$('body').on('click', '#b span', function(){		
			status = $(this).data('status');			
			post = 'status='+status+'&is_ajax=1';
                        $('select[name="status').val(status);
			$.post('/partner_cabinet/filter', post, function(resp){
				if(resp.success==1){
					$('#orders table').html(resp.text);
					href = window.location.href;
					ind = href.indexOf('?');
					if(ind == '-1') {
					  h = '?status='+status;
					}else{
					   h = href.substr(ind)+'&status='+status;
					}
					history.pushState(null, null, h);
//					$('#paginations label[for="size"],#paginations select, #paginations .prev, #paginations .next, #pages').css({display:"none"});
				}else if(resp.error==1){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
				}
								
			}, 'json');
		});
		$('body').on('click', '.all_orders', function(){		
			history.pushState(null, null, '/partner_cabinet/');
			setTimeout(function(){
				location.reload();
			},10);
		});
	$('#not_color').on('change',function(){
		tr = $(this).prop('checked');
		if(tr == true){
			$('#orders table tr').addClass('notcolor');
		}else{
			$('#orders table tr').removeClass('notcolor');
		}
	});
	
	$('#size,#size2').on('change', function(){
		size = $(this).val();	
		if(size != "" && size != " "){
			href = window.location.href;
					ind = href.indexOf('?');
					if(ind == '-1') {
					  h = '?size='+size;
					}else{
					   h = href.substr(ind)+'&size='+size;
					}
			href = window.location.href;
			window.location.href = h;
		}
		
	});
	$('body').on('click', '.sort', function(){
		st = location.href.split('?status=')[1];
		col = $(this).data('order_by_col');
                $('input[name="col_order_by"').val(col);
		type = $(this).data('order_by_type');
                $('input[name="type_order_by"').val(type);
                $('#apply').trigger('click');
//		post = 'col_order_by='+col+'&type_order_by='+type+'&status='+st+'&is_ajax=1';
//			$.post('/partner_cabinet/filter', post, function(resp){
//				if(resp.success==1){
//					$('#orders table').html(resp.text);
//				}else if(resp.error==1){
//					$('#information .content p').text(resp.text);
//					$('#information').css('display','block');				}
//								
//			}, 'json');
	});
	$('#export_btn').on('click', function(){
		action = $(this).data('action');
		switch(action){
			case 'show':
			$(this).data('action','hide');
			$('.export_div').css({display: 'block'});
			setTimeout(function(){
				$('.export_div').css({opacity: '1'});
			}, 100);
			break;
			case 'hide':
			$(this).data('action','show');			
			$('.export_div').css({opacity: '0'});
			setTimeout(function(){
				$('.export_div').css({display: 'none'});
			}, 3000);
			break;
		}
	});
	$('.export').on('click', function(){
		from = $(this).data('from');		
		if(from == 'action_block'){
			var selectedItems = new Array();
			$(".select_order:checked").each(function() {selectedItems.push($(this).val());});		
			date = $('.e_div input[name="date"]').prop('checked');
			fio = $('.e_div input[name="fio"]').prop('checked');
			phone = $('.e_div input[name="phone_number"]').prop('checked');
			address = $('.e_div input[name="address"]').prop('checked');
			delivery_type = $('input[name="delivery_type"]').prop('checked');
			zip = $('.e_div input[name="zip"]').prop('checked');
			sum = $('.e_div input[name="sum"]').prop('checked');
			wm = $('.e_div input[name="wm"]').prop('checked');
			time_delydery = $('.e_div input[name="time_delydery"]').prop('checked');
			date_start = $('.e_div input[name="date_s"]').val();
			date_end = $('.e_div input[name="date_e"]').val();
			post = 'date='+date+'&date_start='+date_start+'&date_end='+date_end+'&fio='+fio+'&phone='+phone+'&address='+address+'&delivery_type='+delivery_type+'&zip='+zip+'&sum='+sum+'&wm='+wm+'&time_delydery='+time_delydery+'&is_ajax=1';
			if(selectedItems.length != 0){
				post += '&order_ids='+JSON.stringify(selectedItems);
			}	
		}else{				
			date = $('input[name="date"]').prop('checked');
			fio = $('input[name="fio"]').prop('checked');
			phone = $('input[name="phone_number"]').prop('checked');
			address = $('input[name="address"]').prop('checked');
			delivery_type = $('input[name="delivery_type"]').prop('checked');
			zip = $('input[name="zip"]').prop('checked');
			sum = $('input[name="sum"]').prop('checked');
			wm = $('input[name="wm"]').prop('checked');
			time_delydery = $('input[name="time_delydery"]').prop('checked');
			date_start = $('input[name="date_s"]').val();
			date_end = $('input[name="date_e"]').val();
			post = 'date='+date+'&date_start='+date_start+'&date_end='+date_end+'&fio='+fio+'&phone='+phone+'&address='+address+'&delivery_type='+delivery_type+'&zip='+zip+'&sum='+sum+'&wm='+wm+'&time_delydery='+time_delydery+'&is_ajax=1';	
		}
			$.post('/partner_cabinet/export', post, function(resp){				
			if(resp.response=='success'){
				// console.log('http://cpa-private.biz/partner_cabinet/download?filename='+resp.name);
				window.location.href = 'http://cpa-private.biz/partner_cabinet/download?filename='+resp.name;				
			}else if(resp.response=='error'){
				$('#information .content p').text(resp.text);
				$('#information').css('display','block');
			}
				// if(resp.success==1){
					// $('#orders table').html(resp.text);
				// }else if(resp.error==1){
					// $('#information .content p').text(resp.text);
					// $('#information').css('display','block');				}
								
			}, 'json');
	});
	
	// var selectedItems = new Array();
	// $(".select_order:checked").each(function() {selectedItems.push($(this).val());});
	$('body').on('change','.select_all_orders', function(){
		action = $(this).data('action');
		switch(action){
			case 'select':
				$(".select_order").prop('checked',true);
				$(this).data('action', 'not_select');
			break;
			case 'not_select':
				$(".select_order").prop('checked',false);
				$(this).data('action', 'select');
			break;
		}
	})
	$('body').on('change','.select_order,.select_all_orders', function(){
		count = $(".select_order:checked").length;
		$('#order_action p span').text(count);
		if(count == 0){
			$('#order_action').css({bottom: '-70px'});
		}else{
			$('#order_action').css({bottom: '0px'});
		}
	})
	$('.btn_order_action').on('click', function(){
		action = $(this).data('action');
		var selectedItems = new Array();
		$(".select_order:checked").each(function() {selectedItems.push($(this).val());});
		switch(action){
			case 'delete': 
				a = window.location.toString();
				b = a.split('/');
				c = b[b.length-1];
				if(c == 'warehouse'){
					post = 'goods_ids='+JSON.stringify(selectedItems)+'&is_ajax=1';
					$.post('/partner_cabinet/warehouse/deleteGoods', post, function(resp){				
						if(resp.response=='success'){	
							window.location.reload();
						}else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}									
					}, 'json');
				}else{
					post = 'order_ids='+JSON.stringify(selectedItems)+'&is_ajax=1';
					$.post('/partner_cabinet/deleteOrders', post, function(resp){				
						if(resp.response=='success'){	
							window.location.reload();
						}else if(resp.response=='error'){
							$('#information .content p').text(resp.text);
							$('#information').css('display','block');
						}									
					}, 'json');
				}
			break;
			case 'export': 
				post = 'order_ids='+JSON.stringify(selectedItems)+'&date='+'true'+'&fio='+'true'+'&phone='+'true'+'&address='+'true'+'&delivery_type='+'true'+'&zip='+'true'+'&sum='+'true'+'&wm='+'true'+'&time_delydery='+'true'+'&is_ajax=1';
			$.post('/partner_cabinet/export', post, function(resp){				
			if(resp.response=='success'){				
				window.location.href = 'http://cpa-private.biz/partner_cabinet/download?filename='+resp.name;				
				}else if(resp.response=='error'){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
				}
			
								
			}, 'json');
			break;
		}
	});
	$('.a').on('click', function(){
		action = $(this).data('action');
		
		switch(action){
			case 'show':
				$('#div_action .h_d').css({display: 'block'});
				$(this).data('action','hidde');
				h_d = 1;
			break;
			case 'hidde':
				$('#div_action .h_d').css({display: 'none'});
				$(this).data('action','show');
				h_d = 0;
			break;
		}
	});
	$('.show_div, .right_block').on('mouseenter', function(e){
		$(this).children(".right_block").css({display: 'block'});
	});
	$('.right_block').on('mouseenter', function(){
		$(this).css({display: 'block'});
	});
	$('.show_div').on('mouseleave ', function(){
		$(this).children(".right_block").css({display: 'none'});	
	});
	$('.right_block').on('mouseleave ', function(){
		$(this).css({display: 'none'});		
	});
	
	$('#ad_ph').on('click',function(){
		// $('#extension_phone ul').append('<li>'+$(this).val()+'</li>');
		$('#extension_phone').append('<p><input class="for_info_data_phone e_phone" type="text" placeholder="Номер доп телефона"><img src="https://cdn3.iconfinder.com/data/icons/linecons-free-vector-icons-pack/32/trash-512.png"></p>');
		// $(this).val('');
		$('.for_info_data_phone').mask('79999999999'); 
	});
	$('body').on('click','#extension_phone ul li',function(){
		$(this).remove();
	});
	
	$('body').on('click','.tr', function(e){
		element = e.target.className;	
		
		$('.tr').css({height: '50px'});
		$(this).css({height: 'unset'});
		
	});
	$('body').on('click','.g_tr', function(e){
		classname = $(this).attr('class');
		$('.apical').css({display: 'none'});
		if(classname != 'g_tr not_goods'){
			if ($(this).children(".apical").html() != '') {
				$(this).children(".apical").css({display: 'block'});		
			}
		}

		
	});
	
	$('body').on('click', '#extension_phone p img', function(){
		$(this).parent('p').remove();
	});
	
	$('.postmail').on('click',function(){
		var selectedItems = new Array();
		order_id = $(this).data('order_id');
		if(order_id){
			selectedItems.push(order_id);
		}else{
			$(".select_order:checked").each(function() {selectedItems.push($(this).val());});	
		}
		
		// '&order_ids='+JSON.stringify(selectedItems);
		// post = 'orders_id='+JSON.stringify(selectedItems)+'&from_name='+'жуков'+'&is_ajax=1';
		blank = $(this).data('blank');
		from_name = $(this).data('from');
		switch(blank){
			case 'f7':
				post = 'orders_id='+JSON.stringify(selectedItems)+'&from_name='+from_name+'&blank_type=f7';
				window.open('/blanks?'+post, '_blank');
				
				// post = 'orders_id='+JSON.stringify(selectedItems)+'&from_name='+from_name+'&blank_type=f7&blank_count=1';
				// window.open('http://pdf.cpa-private.biz?'+post, '_blank');
				
			break;
			case 'f112':
				post = 'orders_id='+JSON.stringify(selectedItems)+'&from_name='+from_name+'&blank_type=f112';
				window.open('/blanks?'+post, '_blank');
				
				// post = 'orders_id='+JSON.stringify(selectedItems)+'&from_name='+from_name+'&blank_type=f112&blank_count=1';
				// window.open('http://pdf.cpa-private.biz?'+post, '_blank');
			break;
			case '2f':
				post1 = 'orders_id='+JSON.stringify(selectedItems)+'&from_name='+from_name+'&blank_type=f7';
				post2 = 'orders_id='+JSON.stringify(selectedItems)+'&from_name='+from_name+'&blank_type=f112';
				window.open('/blanks?'+post1, '_blank');
				window.open('/blanks?'+post2, '_blank');
				
				// post = 'orders_id='+JSON.stringify(selectedItems)+'&from_name='+from_name+'&blank_type=f112&blank_count=2';
				// window.open('http://pdf.cpa-private.biz?'+post, '_blank');
			break;
		}
		

		// post1 = 'orders_id='+JSON.stringify(selectedItems)+'&from_name='+'жуков'+'&blank_type=f7';
		// post2 = 'orders_id='+JSON.stringify(selectedItems)+'&from_name='+'жуков'+'&blank_type=f112';
		// location.href = '/blanks?'+post;
		// window.open('/blanks?'+post1, '_blank');
		// window.open('/blanks?'+post2, '_blank');
			// $.post('/partner_cabinet/getBlanks', post, function(resp){				
			// $.post('/blanks', post, function(resp){				
			// if(resp.response=='success'){				
				// window.location.href = 'http://cpa-private.biz/partner_cabinet/download?filename='+resp.name;				
				// }else if(resp.response=='error'){
					// $('#information .content p').text(resp.text);
					// $('#information').css('display','block');
				// }
			
								
			// }, 'json');
	});
	
	$('body').on('click','.t_d',function(){		
		$(".t_d").each(function() {
			$(this).prop('checked', false);
		});
		$('.h_p').css({display: 'none'});
		$(this).prop('checked', true);
		c = $(this).val();
		$('.b.'+c+' .h_p').css({display: 'block'});
		
	});
	
	$('body').on('click','.h_pt_d',function(){		
		$(".h_pt_d").each(function() {
			$(this).prop('checked', false);
		});
		$('.h').css({display: 'none'});
		$(this).prop('checked', true);
		c = $(this).val();
		$('.h.'+c+'').css({display: 'block'});
		
	});
	$('.fiz_lic').on('click',function(){
		$(".fiz_lic div").each(function() {
			$(this).css('display', 'none');
		});
		$(this).children('div').css('display', 'block');
	});
	$('input[name="link_site"]').on('change',function(){
		gid = $(this).data('goods_id');
		link = $(this).val();
		post = 'goods_id='+gid+'&link='+link+'&is_ajax=1';
			$.post('/partner_cabinet/edit_goods/addLink', post, function(resp){				
			if(resp.response=='success'){						
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
				}else if(resp.response=='error'){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
				}
			
								
			}, 'json');
	});
	$('body').on('click','.a_table tr', function(e){
		cl = e.target.className;
		if(cl != 'del'){
			goods_id = $(this).data('goods_id');
			if(goods_id != 0){
				window.location.href = '/partner_cabinet/edit_goods?goods_id='+goods_id;
			}
		}
	});
	$('.del').on('click', function(){
		apical_id = $(this).data('apical_id');
		post = 'apical_id='+apical_id+'&is_ajax=1';
			$.post('/partner_cabinet/edit_goods/delApical', post, function(resp){				
				if(resp.response=='success'){						
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
					location.reload();
				}else if(resp.response=='error'){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
				}					
								
			}, 'json');
	});
	$('.sms_message').on('change',function(){
		type = $(this).data('type');
		partner_id = $('.sms_form input[name="partner_id"]').val();
		message = $(this).val();
		post = 'partner_id='+partner_id+'&type='+type+'&message='+message+'&is_ajax=1';
			$.post('/partner_cabinet/setSmsText', post, function(resp){				
					
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');		
								
			}, 'json');
	});
	
	$('.sms').on('click', function(){
		sms_type = $(this).data('type');
		var phones = new Array();
		var orders_ids = new Array();
		$(".select_order:checked").each(function() {
			o_id = $(this).val();
			phone = $('tr[data-order_id="'+o_id+'"] td:nth-child(11)').text();
			orders_ids.push(o_id);
			if(phone){
				phones.push(phone);
			}
		});	
		// '&order_ids='+JSON.stringify(selectedItems);
		post = 'phones='+JSON.stringify(phones)+'&order_ids='+JSON.stringify(orders_ids)+'&type='+sms_type+'&is_ajax=1';
			$.post('/partner_cabinet/sendSms', post, function(resp){		
					
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');		
								
			}, 'json');
	});
	
	$('.d_b').on('click', function(){
		action = $(this).data('action');
		switch(action){
			case 'sms_send':
			var phones = new Array(); 
			var oids = new Array(); 
			sms_type = $('select[name="type_sms"]').val();
			phone = $('input[name="phone"]').val();
			oid = $('#oid').text();
			phones.push(phone);
			oids.push(oid);
			
			post = 'phones='+JSON.stringify(phone)+'&order_ids='+JSON.stringify(oids)+'&type='+sms_type+'&is_ajax=1';
			$.post('/partner_cabinet/sendSms', post, function(resp){		
					
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');		
								
			}, 'json');
			break;
			
			case 'show_div_sms_text':
				action = $(this).data('show');
				switch(action){
					case 'show':
						$('.div_sms_text').css({display: 'block'});
						$(this).data('show','hidden');
					break;
					case 'hidden':
						$('.div_sms_text').css({display: 'none'});
						$(this).data('show','show');
					break;
				}
			break;
		}
	});
	$('.add_balans').on('click', function(){
			pid = $(this).parent().parent().data('partner_id');
			sum = $(this).parent().prev().children('input').val();
			operation = 1;
			post = 'p_id='+pid+'&sum='+sum+'&operation='+operation+'&is_ajax=1';
			$.post('/main_cabinet/operationBalans', post, function(resp){
					if(resp.response=='success'){
						$('#information .content p').text(resp.text);
						$('#information').css('display','block');
						setTimeout(function(){
							window.location.reload();
						}, 500);
					}else{
						$('#information .content p').text(resp.text);
						$('#information').css('display','block');
					}					
				}, 'json');	
	});
	$('.subtract_balans').on('click', function(){
			pid = $(this).parent().parent().data('partner_id');
			sum = $(this).parent().prev().children('input').val();
			operation = 2;
			post = 'p_id='+pid+'&sum='+sum+'&operation='+operation+'&is_ajax=1';
			$.post('/main_cabinet/operationBalans', post, function(resp){
					if(resp.response=='success'){
						$('#information .content p').text(resp.text);
						$('#information').css('display','block');
						setTimeout(function(){
							window.location.reload();
						}, 500);
					}else{
						$('#information .content p').text(resp.text);
						$('#information').css('display','block');
					}					
				}, 'json');	
	});
	$('body').on('click','#partner table tr', function(e){
		$('.history_operation').fadeOut(500);
		element = e.target.nodeName;	
		o_id = $(this).data('order_id');
		if(element != "INPUT" && element != "TH" && element != "SPAN"){
			pid = $(this).data('partner_id');
			post = 'p_id='+pid+'&is_ajax=1';
			$.post('/main_cabinet/getHistoryOperation', post, function(resp){
					if(resp.response=='success'){						
						$('tr[data-history_partner_id="'+pid+'"] td .history_operation_div').html(resp.text);
						setTimeout(function(){
							$('tr[data-history_partner_id="'+pid+'"]').fadeIn(500);
						},10);
					}else{
						$('#information .content p').text(resp.text);
						$('#information').css('display','block');
					}					
				}, 'json');	
		}
		
	});
	
	$('body').on('click','.activeted', function(e){
		element = e.target.nodeName;	
		wm_id = $(this).parent().parent().data('partner_id');
			post = 'wm_id='+wm_id+'&is_ajax=1';
			$.post('/main_cabinet/wmActivated', post, function(resp){
				if(resp.response=='success'){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
					setTimeout(function(){
						// location.reload();
					}, 1500);
				}else{
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
				}
			}, 'json');			
	});
	$('body').on('click','.baned', function(e){
		element = e.target.nodeName;	
		wm_id = $(this).parent().parent().data('partner_id');
			post = 'wm_id='+wm_id+'&is_ajax=1';
			$.post('/main_cabinet/wmBaned', post, function(resp){
				if(resp.response=='success'){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
					setTimeout(function(){
						location.reload();
					}, 1500);
				}else{
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
				}
			}, 'json');			
	});
	$('body').on('click','.delete', function(e){
		element = e.target.nodeName;	
		wm_id = $(this).parent().parent().data('partner_id');
			post = 'wm_id='+wm_id+'&is_ajax=1';
			$.post('/main_cabinet/wmDelete', post, function(resp){
				if(resp.response=='success'){
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
					setTimeout(function(){
						location.reload();
					}, 1500);
				}else{
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
				}
			}, 'json');			
	});
	$('body').on('click','.next', function(){
		w = parseInt($('#pages > div').css('left').split('px')[0]);
		$('#pages > div').css('left', w-45+'px');
	});
	$('body').on('click','.prev', function(){
		w = parseInt($('#pages > div').css('left').split('px')[0]);
		
		if(w<0){
			console.log(w+45+'px');
		$('#pages > div').css('left', w+45+'px');
		}else{
			$('#pages > div').css('left', '0px');
		}
	});
	$('body').on('click','.show_stat', function(){
	wm_id = $(this).parent().parent().data('wm_id');
			post = 'wm_id='+wm_id+'&is_ajax=1';
			$.post('/main_cabinet/infoWM', post, function(resp){
				if(resp.response=='success'){
					$('#clicks').text(resp.clicks);
					$('#uniq').text(resp.uniq);
					$('#leads').text(resp.all);
					$('#appr').text(resp.appr);
					$('#del').text(resp.del);
					$('#hold').text(resp.hold);
					$('#balans').text(resp.balans);
					$('#info_web').css('display','block');
				}else{
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
				}
			}, 'json');		
	});
	$('body').on('click','.payments_wm', function(){
	wm_id = $(this).parent().parent().data('partner_id');
			post = 'wm_id='+wm_id+'&is_ajax=1';
			$.post('/main_cabinet/infoPayments', post, function(resp){
				if(resp.response=='success'){
					$('#info_web_paymants .content ').html(resp.table);
					$('#info_web_paymants').css('display','block');
				}else{
					$('#information .content p').text(resp.text);
					$('#information').css('display','block');
				}
			}, 'json');		
	});
});