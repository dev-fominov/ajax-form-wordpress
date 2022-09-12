<?php get_header(); ?>

<?php if (is_user_logged_in()) { ?>

	<a href="<?php echo wp_logout_url(home_url()); ?>">Logout</a>

<?php } else { ?>

	<div class="register-section">
		<div class="wrapper">
			<div class="register-title">Регистрация</div>
			<p class="register-description">Для регистрации, пожалуйста, заполните несколько полей.<br>Ваши данные необходимы для подтверждения, что Вы
				являетесь специалистом здравоохранения</p>
			<button class="log-in-btn">У меня уже есть аккаунт</button>

			<form id="register" method="POST">

				<?php wp_nonce_field('ajax-register-nonce', 'register_security'); ?>

				<div class="form-block">
					<div class="block-title">
						<span class="form-block-title">Личные данные</span>
						<span class="form-block-description">Все поля обязательны для заполнения</span>
					</div>
					<div class="form-content">
						<label>
							<span>Фамилия</span>
							<input type="text" name="register_surname" class="required">
						</label>
						<label>
							<span>Имя</span>
							<input type="text" name="register_name" class="required">
						</label>
						<label>
							<span>Отчество</span>
							<input type="text" name="register_middle_name" class="required">
						</label>
						<label class="register_address_hidden input_hidden">
							<span>Город</span>
							<div class="city_content"><span>Начните вводить название города</span></div>
							<input type="text" name="register_city" id="city_id" class="required" placeholder="Начните вводить название города">
							<div class="city_array"></div>
						</label>
					</div>
				</div>

				<div class="form-block">
					<div class="block-title">
						<span class="form-block-title">Место работы</span>
					</div>
					<div class="form-content form-content-second">

						<div class="radio-block">
							<span class="left-block">Способ ввода места работы</span>
							<div class="right-block">
								<label class="label-radio">
									<input type="radio" name="place_of_work" value="register_name_lpu" checked>
									<span>По названию ЛПУ</span>
								</label>
								<label class="label-radio">
									<input type="radio" name="place_of_work" value="register_address">
									<span>По адресу</span>
								</label>
							</div>
						</div>

						<label class="register_name_lpu_hidden input_hidden">
							<span>Адрес ЛПУ</span>
							<div class="lpu_content"><span>Начните вводить адрес ЛПУ</span></div>
							<input type="text" name="register_address_lpu" id="address_lpu_id" class="required" placeholder="Начните вводить адрес ЛПУ">
							<div class="register_address"></div>
						</label>
						<label class="label-error-address-lpu">
							<span class="error-address-lpu">Вашего ЛПУ нет в выпадающем списке. Введите название своего ЛПУ в поле ниже</span>
							<input type="text" name="register_address_lpu2" id="address_lpu_id2" class="required" placeholder="Введите адрес ЛПУ" value="">
						</label>
						<label class="register_address_hidden select-hidden">
							<span>Тип учреждения</span>
							<div class="input-hidden">Искать по всем типам</div>
							<input type="text" name="register_type_institution" id="type_inst_id" class="required" placeholder="Искать по всем типам">
							<div class="type_of_inst"></div>
							<div class="select-btn">
								<span>
									<svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M6.53033 0.46967C6.23744 0.176777 5.76256 0.176777 5.46967 0.46967L0.696699 5.24264C0.403806 5.53553 0.403806 6.01041 0.696699 6.3033C0.989592 6.59619 1.46447 6.59619 1.75736 6.3033L6 2.06066L10.2426 6.3033C10.5355 6.59619 11.0104 6.59619 11.3033 6.3033C11.5962 6.01041 11.5962 5.53553 11.3033 5.24264L6.53033 0.46967ZM5.25 1L5.25 2L6.75 2L6.75 1L5.25 1Z" fill="#5B5D5C" />
									</svg>
								</span>
								<span>
									<svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M5.46967 6.53033C5.76256 6.82322 6.23744 6.82322 6.53033 6.53033L11.3033 1.75736C11.5962 1.46447 11.5962 0.989593 11.3033 0.696699C11.0104 0.403806 10.5355 0.403806 10.2426 0.696699L6 4.93934L1.75736 0.696699C1.46447 0.403806 0.989593 0.403806 0.696699 0.696699C0.403806 0.989592 0.403806 1.46447 0.696699 1.75736L5.46967 6.53033ZM5.25 5L5.25 6L6.75 6L6.75 5L5.25 5Z" fill="#5B5D5C" />
									</svg>
								</span>
							</div>
						</label>
						<label class="register_address_hidden input_hidden">
							<span>Название учреждения</span>
							<div class="inst_content"><span>Начните вводить название учреждения</span></div>
							<input type="text" name="register_name_institution" id="name_inst_id" class="required" placeholder="Начните вводить название учреждения">
							<div class="name_inst"></div>
						</label>
						<label class="register_speciality_hidden select-hidden">
							<span>Специальность</span>
							<div class="input-hidden">Не выбрана</div>
							<input type="text" name="register_speciality" class="required" placeholder="Не выбрана">
							<div class="name_lpu"></div>
							<div class="select-btn">
								<span>
									<svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M6.53033 0.46967C6.23744 0.176777 5.76256 0.176777 5.46967 0.46967L0.696699 5.24264C0.403806 5.53553 0.403806 6.01041 0.696699 6.3033C0.989592 6.59619 1.46447 6.59619 1.75736 6.3033L6 2.06066L10.2426 6.3033C10.5355 6.59619 11.0104 6.59619 11.3033 6.3033C11.5962 6.01041 11.5962 5.53553 11.3033 5.24264L6.53033 0.46967ZM5.25 1L5.25 2L6.75 2L6.75 1L5.25 1Z" fill="#5B5D5C" />
									</svg>
								</span>
								<span>
									<svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M5.46967 6.53033C5.76256 6.82322 6.23744 6.82322 6.53033 6.53033L11.3033 1.75736C11.5962 1.46447 11.5962 0.989593 11.3033 0.696699C11.0104 0.403806 10.5355 0.403806 10.2426 0.696699L6 4.93934L1.75736 0.696699C1.46447 0.403806 0.989593 0.403806 0.696699 0.696699C0.403806 0.989592 0.403806 1.46447 0.696699 1.75736L5.46967 6.53033ZM5.25 5L5.25 6L6.75 6L6.75 5L5.25 5Z" fill="#5B5D5C" />
									</svg>
								</span>
							</div>
						</label>
					</div>
				</div>

				<div class="form-block">
					<div class="block-title">
						<span class="form-block-title">Данные для входа на сайт</span>
					</div>
					<div class="form-content form-content-third">

						<label>
							<span>Email</span>
							<input type="text" name="register_email" class="required">
						</label>
						<label>
							<span>Пароль</span>
							<input type="password" name="register_password" class="required">
						</label>
						<label>
							<span>Повторите пароль</span>
							<input type="password" name="register_password2" class="required">
						</label>
						<span class="validate-password-style">Минимум 8 символов, должна быть хотя бы одна буква и хотя бы одна цифра</span>
						<label>
							<span class="label-tel">Номер телефона</span>
							<input type="tel" name="register_phone" class="required">
						</label>

					</div>
				</div>

				<div class="form-block form-content-fourth">
					<div class="form-content ">

						<label class="label-checkbox">
							<input type="checkbox" name="personal_data" class="required-checkbox">
							<span>Я соглашаюсь на обработку моих персональных данных для цели моего взаимодействия с ООО «Биологише Хейльмиттель Хеель ГМБХ» в соответствии с условиями Политики конфиденциальности на сайте heel.kz и принимаю такие условия</span>
						</label>
						<label class="label-checkbox">
							<input type="checkbox" name="notifications" class="required-checkbox">
							<span>Настоящим выражаю свое согласие на получение по указанным мной контактным данным рекламных и информационных материалов от ООО «Биологише Хейльмиттель Хеель ГМБХ» на периодической основе, а также персонализированных уведомлений о предстоящих мероприятиях.</span>
						</label>

					</div>
				</div>

				<p class="error-message"></p>

				<button class="send-btn">Зарегистрироваться</button>

				<input type="hidden" name="email_status" value="no-active" />

			</form>

		</div>
	</div>

	<div class="log-in-section">
		<div class="wrapper">
			<div class="log-in-title">Авторизация</div>
			<p class="log-in-description">Войдите для доступа ко всем научно-медицинским материалам ресурса</p>

			<form id="login" method="POST">

				<?php wp_nonce_field('ajax-login-nonce', 'security'); ?>

				<div class="form-block">
					<div class="form-content">
						<label>
							<span>Email</span>
							<input type="email" class="required" name="username">
						</label>
						<label>
							<span>Пароль</span>
							<input type="password" class="required" name="password">
						</label>

						<div class="bottom-form-info">
							<label class="label-checkbox">
								<input type="checkbox" name="remember" class="required-checkbox">
								<span>Запомнить меня на этом устройстве</span>
							</label>

							<span class="text-link forgot-btn">Забыли пароль?</span>
						</div>

						<p class="error-message"></p>

						<button class="send-btn">Войти</button>
						<span class="register-btn">Зарегистрироваться</span>

					</div>
				</div>

			</form>

			<p class="info-text">Информация, размещенная на веб-сайте heel.kz в разделе «Для специалистов здравоохранения», предназначена только для дипломированных специалистов здравоохранения. Пожалуйста, подтвердите, что Вы являетесь медицинским или фармацевтическим работником и согласны с данным утверждением.</p>

		</div>
	</div>

	<div class="forgot-section">
		<div class="wrapper">
			<div class="forgot-title">Восстановление пароля</div>
			<p class="forgot-description">Введите e-mail, указанный при регистрации, и мы отправим ссылку для восстановления пароля</p>

			<form id="forgot_password" method="POST">

				<?php wp_nonce_field('ajax-forgot-nonce', 'forgot_security'); ?>

				<div class="form-block">
					<div class="form-content">
						<label>
							<span>Email</span>
							<input type="email" class="required" name="user_login">
						</label>

						<p class="error-message"></p>

						<button class="send-btn">Отправить</button>
						<span class="log-in-btn">Авторизоваться</span>

					</div>
				</div>

			</form>

		</div>
	</div>

<?php } ?>

<?php get_footer(); ?>