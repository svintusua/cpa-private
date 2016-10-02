<!DOCTYPE html>  
<html>
<head>
	<meta charset="utf-8">
	<meta property="og:image" content="/img/logo_ss.png" />
	<meta name="description" content="" />
	<meta name="keywords" content="">
	<title></title>
	<link rel="icon" href="favicon.ico" type="image/x-icon" /> 
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="./css/simple-line-icons.css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<link rel="stylesheet" type="text/css" href="./css/mfglabs_iconset.css">
	<link rel="stylesheet" type="text/css" href="./css/modal.css">
	<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.1.2/css/material-design-iconic-font.min.css">
	<script type="text/javascript" src="./js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="./js/jquery.nav.min.js"></script>
	<script type="text/javascript" src="./js/jquery.maskedinput.min.js"></script>
	<script type="text/javascript" src="./js/main.js"></script>
	<script type="text/javascript" src="./js/modal.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
	
</head>
<body>
	<div id="slide1">
		<div class="left">
			<div class="center">
				<div class="logo"><div class="logo_text"><h1>строй<span></span>комфорт</h1><p>для людй знающих толк в комфорте</p></div></div>
				<div id="plushki">
					<div class="prem">
						<h2><span>10</span><span>на рынке</span></h2>
					</div>
					<div class="prem">
						<h2><span>89</span><span>довольных<br>клиентов</span></h2>
					</div>
					<div class="prem">
						<h2><span>57</span><span>проектов</span></h2>
					</div>
					<div class="prem">
						<h2><span>5</span><span>лет<br>гарантии</span></h2>
					</div>
				</div>
				<div class="contancts">
					<span>
						<i class="zmdi zmdi-hc-fw"></i>
						8 (499) 993-79-43
					</span>
					<span>
						<i class="zmdi zmdi-hc-fw"></i>
						г. Москва, ул.Карбышева, д.19
					</span>
				</div>
				<div class="prava"><span>2015 все права защищены</span></div>
			</div>
		</div>
		<div class="right">
			<div class="top">
				<h1>О нас</h1>
				<div class="paragraf">
					<p>Добро пожаловать в компанию номер 1 в своей отрасли! Вы пришли в нужное место. Мы профессиональны своего дела, не первый год на рынке, а главная наша задача чтобы Вы остались довольны. Мы ценим Ваше доверие!</p>
					<p>На нашем сайте вы найдете кучу информации о различных аспектах нашей деятельности. Мы занимаемся как строительством домов в целом, так и монтажем отдельных частей. Наша команда профессионалов с радостью помогут вам разобраться с любым вопросом. Если у вас есть вопросы позвоните нам или закажите обратный звонок и наши менеджеры втечении нескольких минут свяжутся с вами.</p>
				</div>
			</div>
			<div class="bottom">
				<h1>оставить заявку</h1>
				<div class="form">
					<form id="one">
						<input type="text" name="name" placeholder="Имя :" required>
						<input type="text" name="name" class="phonefield" placeholder="Телефон :" required>
						<input type="text" name="name" placeholder="E-mail :" required>
						<textarea maxlength="30" placeholder="Сообщение :"></textarea>
						<input type="submit" value="Отправить">
					</form>
				</div>
			</div>
		</div>
	</div>
	
	
	<nav>
		<ul>
			<li><a href=""></a></li>
			<li><a href=""></a></li>
			<li><a href=""></a></li>
			<li><a href=""></a></li>
		</ul>
	</nav>
	<div id="order" class="modal" style="display: none;">
	<a modal="promo" class="btn_promo" href="#" ></a>
			<div class="modal-block modal-top modal-left" style="border-radius: 15px 15px 10px 10px; margin-top: -103px; margin-left: -299px;">
			<div class="icon-close"></div>
			<div class="title" style="border-radius: 10px 10px 0px 0px;">Оставить заявку</div>
			<div class="content">
				<div class="response"><p></p></div>
				<div class="form">
					<p>Вас интересует: <span class="intresting"></span></p>
					<form method="POST" id="order_send">
						<input type="hidden" name="product">						
						<input type="text" name="name" placeholder="Ваше имя*" pattern="[A-Za-zА-Яа-яЁё\s]{2,15}" required>
						<input type="text" name="phone" class="phonefield" placeholder="Ваш телефон*" required>
						<input type="text" name="promo" placeholder="Промокод"> 
						<input type="submit" value="отправить заявку"/>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="promo" class="modal" style="display: none;">
			<div class="modal-block modal-top modal-left" style="border-radius: 15px 15px 10px 10px; margin-top: -103px; margin-left: -299px;">
			<div class="icon-close"></div>
			<div class="title" style="border-radius: 10px 10px 0px 0px;">Получи промокод на скидку для деталей!</div>
			<div class="content" style="padding: 20px;">
				<p>Для того чтобы получить промокод вам нужно:<br>
1. Добавить запись<br>
2. Перейти по ссылке<br>
3. Скопировать промокод</p>
				<script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script><div class="yashare-auto-init" data-yasharelink="http://дымчик.рф/promo.php" data-yashareImage="http://дымчик.рф/img/logo_ss.png" data-yashareTitle="Дымчик.рф производство и монтаж дымоходов" data-yashareDescription="Мы изготавливаем дымоходы любой сложности и без накрутки. Скидка до 25%! Консультаци и выезд мастера БЕСПЛАТНО!" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir,lj,friendfeed,moikrug,gplus,surfingbird"></div>
			</div>
		</div>
	</div>
	<div id="information" class="modal" style="display: none;">
			<div class="modal-block modal-top modal-left" style="border-radius: 15px 15px 10px 10px; margin-top: -103px; margin-left: -299px;">
			<div class="icon-close"></div>
			<div class="title" style="border-radius: 10px 10px 0px 0px;"><h1>Что нужно знать о дымоходах</h1></div>
			<div class="content">
				<div id="info_text">
					<p>Дымоход - это труба, предназначенная для отвода продуктов сгорания от котла. От того, из какого материала и каким образом изготовлен дымоход, зависит качество и эффективность работы котла. Дымоход, к которому подключается котел, как правило, размещается во внутренней капитальной стене дома. Стенки дымохода должны исключать возможность интенсивного охлаждения продуктов сгорания в нем. Если дымоход находится снаружи дома, он обязательно должен быть теплоизолирован. Кладка наружной стенки кирпичного дымохода должна иметь не менее двух кирпичей, учитывая вероятность снижения температуры наружного воздуха до -30 ° С. </p>
					<p>Предпочтение следует отдавать дымоходам из двустенных теплоизолированных металлических коррозиестойких труб, которые быстро прогреваются и высыхают. Кроме того, кирпичные дымоходы имеют квадратную или прямоугольную форму и отличаются долгим временем прогрева, что ухудшает тягу вследствие образования паровых пробок при запуске и периодической работы котлов. Высота дымохода для котлов с тепловой мощностью до 30 кВт должна быть не менее 5 м, для котлов мощностью свыше 30 до 60 кВт не менее 8 м, свыше 60 до 100 кВт - не менее 10 м. Если поблизости дымохода находятся более высокие части здания или деревья, то он должен выводиться выше них.</p>
					<p>На дымоходах не разрешается устанавливать дефлекторы, зонты и другие насадки, уменьшающие тягу. При необходимости для усиления естественной тяги на дымоходе можно установить специальные тягоусилители или вентиляторы. Канал дымохода должен быть вертикальным, гладким, ровным, без выступов, поворотов и сужений, плотным, без трещин. Перегородки между дымовыми каналами в многоканальном дымоходе должны быть не тоньше, чем 1/2 кирпича.</p>
					<p>В нижней части дымового канала ниже входа дымоотводящего патрубка котла в дымоход должен быть "карман" с сечением, не меньше сечения дымохода и глубиной не менее 25 см с люком для очистки, который закрывается герметичными дверцами или заглушкой. Место ввода дымового патрубка котла в дымоход необходимо уплотнить асбестовым или глиняным раствором. Подключив котел к дымоходу, желательно изолировать дымовой патрубок котла любым теплоизоляционным термостойким материалом.</p>
					<p>Иногда стенки дымохода сыреют. Это наблюдается при чрезмерно низкой температуре дымовых газов, при их охлаждении вследствие недостаточного утепления стенок дымохода, например на чердаке и снаружи дома. Нередко влага просачивается через кирпичные стенки дымохода на их внешнюю поверхность, образуя темные пятна. Чтобы предотвратить увлажнение и разрушение дымохода, его стенки необходимо утеплить: заштукатурить, термоизолировать негорючими синтетическими утеплителями или наложить металлический футляр, в который засыпать шлак или другой теплоизоляционный материал. </p>
					<p>Современные экономичные котлы с высоким КПД имеют низкую температуру отходящих дымовых газов и работают в автоматическом периодическом режиме с постоянным перепадом температур. Поэтому дымоход плохо прогревается и в нем при недостаточном утеплении может образоваться агрессивный конденсат - фактор низкотемпературной коррозии дымохода. При недостаточной теплоизоляции дымохода, чтобы защитить его от вредного воздействия конденсата и разрушения, можно воспользоваться специальными вставками из нержавеющей кислотостойкой стали или использовать для отвода продуктов сгорания специальные двустенные теплоизолированные дымоходы из коррозиестойких стали заводского исполнения. </p>
					<p>Подсоединять к дымоходу котла другие отопительные устройства категорически запрещается. Дымоход должен обеспечивать отвод продуктов сгорания при любых погодных условиях. Перед включением котла и во время его работы необходимо проверять наличие тяги. При нормальной тяге пламя спички будет втягиваться в топку и гаснуть. Для котлов парапетного типа с закрытой герметичной камерой сгорания отвод продуктов сгорания и всасывание свежего воздуха для горения осуществляется с помощью специального двустенного металлического трубного канала, проложенного горизонтально во внешней стене дома.</p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>