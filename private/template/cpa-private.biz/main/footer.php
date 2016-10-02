	<div id="enter_modal" class="modal" style="display: none;">
		<div class="modal-block modal-top modal-left" style="border-radius: 15px 15px 10px 10px; margin-top: -323px; margin-left: -299px;">
			<div class="icon-close"></div>
			<div class="title" style="border-radius: 10px 10px 0px 0px;"><h1>Войти</h1></div>
			<div class="content">				
				<div class="return_password">
					<form method="post" id="form_webmaster_return">
						<input type="email" name="email" placeholder="Email*" required>
						<input type="submit" value="Востановить пароль">
					</form>
				</div>
				<div class="enter" style="display: block;">
					<form method="post" id="form_webmaster_enter">
						<input type="email" name="email" placeholder="Email*" required>
						<input type="password" name="password" placeholder="Пароль*" required>
						<input type="submit" value="Войти">
					</form>
				</div>
				<div class="form_nav">
					<span title="востановить пароль" data-form="recover"><i class="zmdi zmdi-hc-fw"></i></span>
					<span title="войти" data-form="aut" class="active"><i class="zmdi zmdi-hc-fw"></i></span>
				</div>
			</div>
		</div>
	</div>
	<div id="webmaster" class="modal" style="display: none;">
		<div class="modal-block modal-top modal-left" style="border-radius: 15px 15px 10px 10px; margin-top: -323px; margin-left: -299px;">
			<div class="icon-close"></div>
			<div class="title" style="border-radius: 10px 10px 0px 0px;"><h1>Зарегистрировваться как вебмастер</h1></div>
			<div class="content">				
				<div class="return_password">
					<form method="post" id="form_webmaster_return">
						<input type="email" name="email" placeholder="Email*" required>
						<input type="submit" value="Востановить пароль">
					</form>
				</div>
				<div class="registration">
					<form method="post" id="form_webmaster_reg">
						<input type="hidden" name="refid" value="<?=$this->vars['refid']?>">
						<input type="email" name="email" placeholder="Email*" required>
						<input type="password" name="password" placeholder="Пароль*" required>
						<input type="password" name="repeat_password" placeholder="Повторите пароль*" required>
						<input type="hidden" name="type_user" value="1">
						<textarea maxlength="30" name="about" placeholder="Расскажите о себе, вашем опыте:" required></textarea>
						<input type="checkbox" id="c1" name="rules" />
						<label for="c1"><span><i class="zmdi zmdi-hc-fw"></i></span>Я принимаю <a href="" target="_blank">правила</a> работы с системой</label>
						<div class="capcha">
							<span>Выставите число <?=$this->vars['capcha_u'];?> :</span>
							<div class="c_number">
								<i class="zmdi zmdi-hc-fw"></i>
								<div>
									<select class="n1">
										<option selected disabled>-</option>
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
									</select>
								</div>
							</div>
							<div class="c_number">
								<i class="zmdi zmdi-hc-fw"></i>
								<div>
									<select class="n2">
										<option selected disabled>-</option>
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
									</select>
								</div>
							</div>
							<div class="c_number">
								<i class="zmdi zmdi-hc-fw"></i>
								<div>
									<select class="n3">
										<option selected disabled>-</option>
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
									</select>
								</div>
							</div>
							<div class="c_number">
								<i class="zmdi zmdi-hc-fw"></i>
								<div>
									<select class="n4">
										<option selected disabled>-</option>
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
									</select>
								</div>
							</div>
						</div>
						<input type="submit" value="Зарегистрироваться">
					</form>
				</div>
				<div class="enter">
					<form method="post" id="form_webmaster_enter">
						<input type="email" name="email" placeholder="Email*" required>
						<input type="password" name="password" placeholder="Пароль*" required>
						<input type="submit" value="Войти">
					</form>
				</div>
				<div class="form_nav">
					<span title="востановить пароль" data-form="recover"><i class="zmdi zmdi-hc-fw"></i></span>
					<span title="зарегистрироваться" data-form="reg" class="active"><i class="zmdi zmdi-hc-fw"></i></span>
					<span title="войти" data-form="aut"><i class="zmdi zmdi-hc-fw"></i></span>
				</div>
			</div>
		</div>
	</div>
	<div id="partner" class="modal" style="display: none;">
		<div class="modal-block modal-top modal-left" style="border-radius: 15px 15px 10px 10px; margin-top: -323px; margin-left: -299px;">
			<div class="icon-close"></div>
			<div class="title" style="border-radius: 10px 10px 0px 0px;"><h1>Зарегистрировваться как партнер</h1></div>
			<div class="content">
				<div class="return_password">
					<form method="post" id="form_partner_return">
						<input type="email" name="email" placeholder="Email*" required>
						<input type="submit" value="Востановить пароль">
					</form>
				</div>
				<div class="registration">
					<form method="post" id="form_parter_reg">
						<input type="email" name="email" placeholder="Email*" required>
						<input type="text" name="middle_name" placeholder="Фамилия*" required>
						<input type="text" name="first_name" placeholder="Имя*" required>
						<input type="text" name="last_name" placeholder="Отчество*" required>
						<input type="tel" name="phone" class="phonefield" placeholder="Ваш номер телефона*" required>
						<input type="password" name="password" placeholder="Пароль*" required>
						<input type="password" name="repeat_password" placeholder="Повторите пароль*" required>						
						<input type="hidden" name="type_user" value="2">
						<textarea maxlength="30" name="about" placeholder="Расскажите о себе, о вашем товаре:" required></textarea>
						<input type="checkbox" id="c2" name="rules" />
						<!--<label for="c2"><span><i class="zmdi zmdi-hc-fw"></i></span>Я принимаю <a href="" target="_blank">правила</a> работы с системой</label>-->
						<div class="capcha">
							<span>Выставите число <?=$this->vars['capcha_p'];?> :</span>
							<div class="c_number">
								<i class="zmdi zmdi-hc-fw"></i>
								<div>
									<select class="n1">
										<option selected disabled>-</option>
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
									</select>
								</div>
							</div>
							<div class="c_number">
								<i class="zmdi zmdi-hc-fw"></i>
								<div>
									<select class="n2">
										<option selected disabled>-</option>
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
									</select>
								</div>
							</div>
							<div class="c_number">
								<i class="zmdi zmdi-hc-fw"></i>
								<div>
									<select class="n3">
										<option selected disabled>-</option>
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
									</select>
								</div>
							</div>
							<div class="c_number">
								<i class="zmdi zmdi-hc-fw"></i>
								<div>
									<select class="n4">
										<option selected disabled>-</option>
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
									</select>
								</div>
							</div>
						</div>
						<input type="submit" value="Зарегистрироваться" disabled="">
					</form>
				</div>
				<div class="enter">
					<form method="post" id="form_parter_enter">
						<input type="email" name="email" placeholder="Email*" required>
						<input type="password" name="password" placeholder="Пароль*" required>
						<input type="submit" value="Войти">
					</form>
				</div>
				<div class="form_nav">
					<span title="востановить пароль" data-form="recover"><i class="zmdi zmdi-hc-fw"></i></span>
					<span title="зарегистрироваться" data-form="reg" class="active"><i class="zmdi zmdi-hc-fw"></i></span>
					<span title="войти" data-form="aut"><i class="zmdi zmdi-hc-fw"></i></span>
				</div>
			</div>
		</div>
	</div>
	<div id="send_letter_support" class="modal" style="display: none;">
		<div class="modal-block modal-top modal-left" style="border-radius: 15px 15px 10px 10px; margin-top: -323px; margin-left: -299px;">
			<div class="icon-close"></div>
			<div class="title" style="border-radius: 10px 10px 0px 0px;"><h1>отправить письмо в службу поддержки</h1></div>
			<div class="content">
				<form method="post" id="send_support">
						<input type="text" name="name" placeholder="Имя*" required>
						<textarea maxlength="30" name="message" placeholder="Сообщение:" required></textarea>
						<input type="submit" value="отправить">
					</form>
			</div>
		</div>
	</div>
	<div id="information" class="modal" style="display: none; ;z-index: 99999;background: rgba(0,0,0,0.9);">
		<div class="modal-block modal-top modal-left" style="border-radius: 15px 15px 10px 10px; margin-top: -323px; margin-left: -299px;">
			<div class="icon-close"></div>
			<div class="content">
				<p></p>
			</div>
		</div>
	</div>
</body>
</html>