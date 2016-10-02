        <!-- <left-box> -->
                    <link rel="stylesheet" href="./files/chosenIcon.css" type="text/css">
<script type="text/javascript" src="./files/chosenIcon.js"></script>
<div class="single-block">
    <div class="statistics-summary">
        <h1>Сводная статистика</h1>
        <div class="download-widget">
            <i class="icon-download"></i>
            <div class="choose-box">
                <ul>
                    <li><a href="javascript:void(0);" class="exportFormat" data-format="csv">CSV</a></li>
                    <li><a href="javascript:void(0);" class="exportFormat" data-format="xml">XML</a></li>
                    <li><a href="javascript:void(0);" class="exportFormat" data-format="xls">XLS</a></li>
                </ul>
            </div>
        </div>
        <div class="clear"></div>
<!--
        <ul class="statistics-category tabs to-left">
    <li class="current">
        <a class="groupBtn" data-group="day" href="#">Дата</a>
    </li>
    <li>
        <a class="groupBtn" data-group="time" href="#">Время</a>
    </li>
    <li>
        <a class="groupBtn" data-group="idOffer" href="#">Оффер</a>
    </li>
    <li>
        <a class="groupBtn" data-group="idChannel" href="#">Поток</a>
    </li>
    <li>
        <a class="groupBtn" data-group="countrycode" href="#">Страна</a>
    </li>
    <li>
        <a class="groupBtn" data-group="data1" href="#">Subid1</a>
    </li>
    <li>
        <a class="groupBtn" data-group="data2" href="#">Subid2</a>
    </li>
    <li>
        <a class="groupBtn" data-group="data3" href="#">Subid3</a>
    </li>
</ul>
-->
<form id="statFilter">
    <input name="ok" value="1" type="hidden">
    <input name="export" id="isExport" value="" type="hidden">
    <input id="history" name="history" value="0" type="hidden">
    <input id="dateFrom" name="dateFrom" value="2016-04-02" type="hidden">
    <input id="dateTo" name="dateTo" value="2016-04-02" type="hidden">
    <input id="grouping" name="grouping" value="day" type="hidden">
    <input id="orderBy" name="orderBy" value="day" type="hidden">
    <input id="order" name="order" value="desc" type="hidden">

    <ul class="to-right statistics-filter-action clearfix">
        <li>
            <span class="button btnBlue filter_start" id="fs">Применить фильтр</span>
            <button type="reset" id="resetFilterBtn" class="button btnGrey">Сбросить</button>
        </li>
    </ul>
    <ul class="statistics-filter clearfix">
<!--
		<li>
            <label for="currency">Валюта</label><br>
            <select style="display: none;" name="idCurrency" id="currencyFilter" class="resetFilter">
                                    <option selected="selected" data-icon="fa-rub" value="RUB">&nbsp;</option>
                                    <option data-icon="fa-usd" value="USD">&nbsp;</option>
                            </select><div id="currencyFilter_chosen" title="" style="width: 85px;" class="chosen-container chosen-container-single chosen-container-single-nosearch chosenIcon-container"><a class="chosen-single" tabindex="-1"><span data-icon="?">&nbsp;</span><div><b></b></div></a><div class="chosen-drop"><div class="chosen-search"><input readonly="readonly" autocomplete="off" type="text"></div><ul class="chosen-results"></ul></div></div>
        </li>

        <li>
            <label for="hold">Холд</label><br>
            <input id="holdFilter_chosen" title="" style="width: 85px;height: 30px;" class="chosen-container chosen-container-single chosen-container-single-nosearch">
        </li>
        <li>
            <label for="percent-approve" title="Процент одобренных лидов">Approve</label><br>
            <input id="percAFilter_chosen" title="" style="width: 134px;height: 30px;" class="chosen-container chosen-container-single chosen-container-single-nosearch">
			</li>
        <li>
            <label for="traffback">Учет Traffback</label><br>
            <input id="traffback_chosen" title="" style="width: 109px;height: 30px;" class="chosen-container chosen-container-single chosen-container-single-nosearch">
			</li>
-->
        <li>
            <label for="offerFilter">Оффер</label><br>
			<select id="offerFilter">
				<?=$this->vars['op']?>
			</select>
            <!--<input id="offerFilter_chosen" title="" style="width: 170px;height: 30px;" class="chosen-container chosen-container-single chosen-container-single-nosearch">-->
			</li>
<!--
        <li class="hiddenFilters">
            <label for="landingFilter">Лендинг</label><br>
            <input id="landingFilter_chosen" title="" style="width: 170px;height: 30px;" class="chosen-container chosen-container-single chosen-container-single-nosearch">
			</li>
        <li class="hiddenFilters">
            <label for="prelandingFilter">Прелендинг</label><br>
            <input id="prelandingFilter_chosen" title="" style="width: 170px;height: 30px;" class="chosen-container chosen-container-single chosen-container-single-nosearch">
			</li>
-->
  <!--      <li class="relative hiddenFilters">
            <label>Страна</label><br>
			<input class="fake-select" data-fake="country">
			<a href="#" class="fake-select js-fake-select" data-fake="country">
                Страны <span class="count"></span>
                <div><b></b></div>
            </a>
            <div class="fake-select-block js-fake-select-block" data-fake="country">
                <div class="row">
                    <select name="countrycode[]" id="multiple_flags" multiple="multiple" class="input resetFilter" data-placeholder="Выберите страны">
                                                    <option value="RU" title="Россия">RU</option>
                                                    <option value="BY" title="Беларусь">BY</option>
                                                    <option value="UA" title="Украина">UA</option>
                                                    <option value="KZ" title="Казахстан">KZ</option>
                                                    <option value="MD" title="Молдова">MD</option>
                                                    <option value="AT" title="Австрия">AT</option>
                                                    <option value="AZ" title="Азербайджан">AZ</option>
                                                    <option value="AM" title="Армения">AM</option>
                                                    <option value="BE" title="Бельгия">BE</option>
                                                    <option value="BG" title="Болгария">BG</option>
                                                    <option value="BA" title="Босния и Герцеговина">BA</option>
                                                    <option value="HU" title="Венгрия">HU</option>
                                                    <option value="DE" title="Германия">DE</option>
                                                    <option value="HK" title="Гонконг">HK</option>
                                                    <option value="GR" title="Греция">GR</option>
                                                    <option value="GE" title="Грузия">GE</option>
                                                    <option value="DK" title="Дания">DK</option>
                                                    <option value="ID" title="Индонезия">ID</option>
                                                    <option value="IS" title="Исландия">IS</option>
                                                    <option value="ES" title="Испания">ES</option>
                                                    <option value="IT" title="Италия">IT</option>
                                                    <option value="CY" title="Кипр">CY</option>
                                                    <option value="KG" title="Киргизия">KG</option>
                                                    <option value="CN" title="Китай">CN</option>
                                                    <option value="KR" title="Республика Корея">KR</option>
                                                    <option value="KW" title="Кувейт">KW</option>
                                                    <option value="LV" title="Латвия">LV</option>
                                                    <option value="LI" title="Лихтенштейн">LI</option>
                                                    <option value="LU" title="Люксембург">LU</option>
                                                    <option value="MT" title="Мальта">MT</option>
                                                    <option value="MC" title="Монако">MC</option>
                                                    <option value="NL" title="Нидерланды">NL</option>
                                                    <option value="NO" title="Норвегия">NO</option>
                                                    <option value="PL" title="Польша">PL</option>
                                                    <option value="PT" title="Португалия">PT</option>
                                                    <option value="RO" title="Румыния">RO</option>
                                                    <option value="RS" title="Сербия">RS</option>
                                                    <option value="SG" title="Сингапур">SG</option>
                                                    <option value="SK" title="Словакия">SK</option>
                                                    <option value="GB" title="Великобритания">GB</option>
                                                    <option value="TJ" title="Таджикистан">TJ</option>
                                                    <option value="TM" title="Туркмения">TM</option>
                                                    <option value="TR" title="Турция">TR</option>
                                                    <option value="UZ" title="Узбекистан">UZ</option>
                                                    <option value="FI" title="Финляндия">FI</option>
                                                    <option value="FR" title="Франция">FR</option>
                                                    <option value="CZ" title="Чехия">CZ</option>
                                                    <option value="CH" title="Швейцария">CH</option>
                                                    <option value="SE" title="Швеция">SE</option>
                                                    <option value="EE" title="Эстония">EE</option>
                                                    <option value="JP" title="Япония">JP</option>
                                                    <option value="BR" title="Бразилия">BR</option>
                                                    <option value="US" title="США">US</option>
                                                    <option value="ALL" title="Весь мир">ALL</option>
                                                    <option value="CA" title="Канада">CA</option>
                                                    <option value="CL" title="Чили">CL</option>
                                                    <option value="MX" title="Мексика">MX</option>
                                                    <option value="VE" title="Венесуэла">VE</option>
                                                    <option value="PE" title="Перу">PE</option>
                                                    <option value="EC" title="Эквадор">EC</option>
                                                    <option value="GT" title="Гватемала">GT</option>
                                                    <option value="DO" title="Доминиканская Республика">DO</option>
                                                    <option value="HN" title="Гондурас">HN</option>
                                                    <option value="PY" title="Парагвай">PY</option>
                                                    <option value="SV" title="Сальвадор">SV</option>
                                                    <option value="CR" title="Коста-Рика">CR</option>
                                                    <option value="PR" title="Пуэрто-Рико">PR</option>
                                                    <option value="PA" title="Панама">PA</option>
                                                    <option value="UY" title="Уругвай">UY</option>
                                                    <option value="EG" title="Египет">EG</option>
                                                    <option value="AU" title="Австралия">AU</option>
                                                    <option value="NZ" title="Новая Зеландия">NZ</option>
                                                    <option value="AR" title="Аргентина">AR</option>
                                                    <option value="CU" title="Куба">CU</option>
                                                    <option value="IE" title="Ирландия">IE</option>
                                                    <option value="MK" title="Македония">MK</option>
                                            </select>
                </div>
            </div>

        </li>-->
        <li class="relative hiddenFilters">
            <label>Sub1</label><br>
            <!--            <a href="#" class="fake-select js-fake-select" data-fake="sub">
                Sub <span class="count"></span>
                <div><b></b></div>
            </a>
-->
			<input class="fake-select" id="sub1" data-fake="sub1">
			
			
            <div class="fake-select-block js-fake-select-block" data-fake="sub">
                <div class="row">
                    <label for="data1Filter">Subid1</label>
                    <select name="data1" id="data1Filter" class="input resetFilter">
                        <option selected="selected"></option>
                                            </select>
                </div>
                <div class="row">
                    <label for="data2Filter">Subid2</label>
                    <select name="data2" id="data2Filter" class="input resetFilter">
                        <option selected="selected"></option>
                                            </select>
                </div>
                <div class="row">
                    <label for="data3Filter">Subid3</label>
                    <select name="data3" id="data3Filter" class="input resetFilter">
                        <option selected="selected"></option>
                                            </select>
                </div>
                <div class="row">
                    <label for="data4Filter">Subid4</label>
                    <select name="data4" id="data4Filter" class="input resetFilter">
                        <option selected="selected"></option>
                                            </select>
                </div>
                <div class="row">
                    <label for="data5Filter">Subid5</label>
                    <select name="data5" id="data5Filter" class="input resetFilter">
                        <option selected="selected"></option>
                                            </select>
                </div>
            </div>
        </li>
        <li>
        	<label>Sub2</label><br>
        	<input class="fake-select" id="sub2" data-fake="sub2">
        </li>
        <li>
        	<label>Sub3</label><br>
        	<input class="fake-select" id="sub3" data-fake="sub3">
        </li>
    </ul>

    <ul class="clearfix statistics-filter-date">
        <li class="to-left date">
            <i class="fa fa-calendar"></i> <input class="datepicker date_from"  placeholder="от" type="text"> - <input class="datepicker2 date_to" placeholder="до" type="text">
        </li>
		<!--<li class="to-left date" style="margin-left: 20px;">
            <span>вывести лиды по subid</span><input name="subs" type="text" style="margin-left: 10px;margin-right: 10px;"><span>за все время</span> <span class="button btnBlue" id="f_p_subs">найти</span>
        </li>-->
    </ul>
</form>
        <div id="searchResult">
            <table>
                <tbody><tr class="top-header-results">
                    <th class="js-sortable border" data-order-by="day" rowspan="2">
                        Дата
                    </th>
                    <th class="border" colspan="3">Трафик</th>
                    <th class="border" colspan="3">Показатели</th>
                    <th class="border" colspan="3">Конверсии</th>
                    <th class="no-border" colspan="4">Финансы</th>
                </tr>
                <tr class="header-results">
                    <th data-order-by="clicks" class="js-sortable">Клики</th>
                    <th data-order-by="clicksUnique" class="js-sortable">Уники</th>
                    <th data-order-by="traffback" class="js-sortable border">Traffback</th>
                    <th data-order-by="cr" class="js-sortable" title="CR (Conversion Ratio) - это процентное отношение количества совершенных действий к количеству кликов.">CR%</th>
                    <th data-order-by="epc" class="js-sortable" title="EPC (Earnings Per Click) - средний заработок с одного клика.">EPC</th>
                    <th data-order-by="epc" class="js-sortable" title="% принятых конверсий">Approve</th>
                    <th data-order-by="salesApproved" class="js-sortable" title="Принято"><i class="fa fa-check"></i></th>
                    <th data-order-by="salesPending" class="js-sortable" title="Ожидает"><i class="fa fa-refresh"></i></th>
                    <th data-order-by="salesDeclined" class="js-sortable border" title="Отклонено"><i class="fa fa-times"></i></th>
                    <th data-order-by="commissionApproved" class="js-sortable" title="Зачислено"><i class="fa fa-check"></i></th>
                    <th data-order-by="commissionPending" class="js-sortable" title="Ожидает"><i class="fa fa-refresh"></i></th>
                    <th data-order-by="commissionDeclined" class="js-sortable no-border" title="Отклонено"><i class="fa fa-times"></i></th>
                </tr>
					
                                   <!-- <tr class="search-row">
                        <td><a href="#" class="search-day" data-date="2016-04-02">02/04/2016</a></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0%</td>
                        <td>0</td>
                        <td>0</td>
                        <td class="color-green">0 </td>
                        <td>0</td>
                        <td class="color-red">0</td>
                        <td class="color-green">0.00 </td>
                        <td>0.00</td>
                        <td class="no-border color-red">0.00</td>
                    </tr>-->
                    </tbody>
					<tbody id="rows">
						<?=$this->vars['stat_tr']?>
					</tbody>
					<tbody style="display: none;" id="expand-2016-04-02"></tbody>
                
                                    <tbody><tr class="result-row">
                        <td>Всего</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0%</td>
                        <td>0</td>
                        <td>0</td>
                        <td class="color-green">0 </td>
                        <td>0</td>
                        <td class="color-red">0</td>
                        <td class="color-green">0.00 </td>
                        <td>0.00</td>
                        <td class="color-red">0.00</td>
                    </tr>
                            </tbody></table>
        </div>
    </div>
</div>                <!-- </right-box> -->
<div id="lead_day" class="modal" style="display: none; ;z-index: 99999;background: rgba(0,0,0,0.9);">
		<div class="modal-block modal-top modal-left" style="border-radius: 15px 15px 10px 10px;margin-top: -103px; margin-left: -450px;">
			<div class="icon-close"></div>
			<div class="content">			
				<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>	
				<div class="inform"></div>
			</div>
		</div>
	</div>
	<div id="clicks_stat" class="modal" style="display: none; ;z-index: 99999;background: rgba(0,0,0,0.9);">
		<div class="modal-block modal-top modal-left" style="border-radius: 15px 15px 10px 10px;margin-top: -103px; margin-left: -300px;">
			<div class="icon-close"></div>
			<div class="content">			
				<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>	
				<div class="inform"></div>
			</div>
		</div>
	</div>
 