
(function ($) {

	const type_of_inst = [
		'Искать по всем типам',
		'Амбулатория',
		'Больница',
		'Госпиталь',
		'Детская больница',
		'Детская поликлиника',
		'Диагностический центр',
		'Диспансер',
		'Дом престарелых, инвалидов',
		'Железнодорожная больница / поликлиника / амбулатория',
		'Женская консультация',
		'Кабинет, пункт, станция',
		'Клиника',
		'Лечебно-диагностический центр',
		'Медико-санитарная часть',
		'Медицинский центр',
		'Медицинское объединение',
		'Наркологический центр (клиника, амбулатория, диспансер)',
		'НИИ',
		'Патологоанатомическое бюро',
		'Перинатальный центр',
		'Поликлиника',
		'Родильный дом',
		'Стационар',
		'Стоматологическая поликлиника',
		'Хоспис',
		'Центр реабилитации',
		'Центр семьи',
		'Диагностическая лаборатория',
	]

	const name_lpu = [
		'Не выбрана',
		'Аллерголог',
		'Вертебролог',
		'ВОП',
		'Врач ЛФК',
		'Врач функциональной диагностики',
		'Гастроэнтеролог',
		'Гепатолог',
		'Гинеколог',
		'Гомеопат',
		'Дерматолог',
		'Иммунолог',
		'Инфекционист',
		'Кардиолог',
		'Клинический формаколог',
		'Косметолог',
		'ЛОР',
		'Массажист',
		'Невролог',
		'Нефролог',
		'Окулист',
		'Ортодонт',
		'Ортопед',
		'Отоневролог',
		'Педиатр',
		'Пластический хирург',
		'Психиатр',
		'Психолог',
		'Пульмонолог',
		'Реабилитолог',
		'Ревматолог',
		'Рефлексотерапевт',
		'Семейный врач',
		'Сомнолог',
		'Сосудистый хирург',
		'Спортивный врач',
		'Стоматолог',
		'Терапевт',
		'Травматолог',
		'Уролог',
		'Флеболог',
		'Хирург',
		'Эндокринолог',
		'Другая специальность',
	]

	$(document).on('click', function (event) {
		if (!$(event.target).closest(".input-hidden, #name_inst_id, #address_lpu_id, #type_inst_id, input[name=update_speciality], input[name=register_speciality], #city_id").length) {
			$("body").find(".name_lpu").removeClass('active')
			$("body").find(".type_of_inst").removeClass('active')
			$("body").find(".city_array").removeClass('active')
			$("body").find(".name_inst").removeClass('active')
			$("body").find(".register_address").removeClass('active')
			$('.select-hidden').find('.select-btn').css('z-index', '1')
			$('.input-hidden').css('display', 'block')
			$('input[name=update_speciality]').css('display', 'none')
			$('input[name=update_type_institution]').css('display', 'none')
			$('input[name=register_speciality]').css('display', 'none')
			$('input[name=register_type_institution]').css('display', 'none')
		}
	})

	$('.name_lpu').html(name_lpu.map(el => `<div class="item">${el}</div>`))
	$('.type_of_inst').html(type_of_inst.map(el => `<div class="item">${el}</div>`))

	$('.input-hidden').on('click', function () {
		$(this).css('display', 'none')
		$(this).next('input[type=text]').css('display', 'block')
		$(this).parents('.select-hidden').find('.select-btn').css('z-index', '-10')
	})

	$('input[name=update_speciality]').on('focus', function () {
		$(this).next('.name_lpu').addClass('active')
		$('.type_of_inst').removeClass('active')
	})

	$('input[name=update_type_institution]').on('focus', function () {
		$(this).next('.type_of_inst').addClass('active');
		$('.name_lpu').removeClass('active')
	})

	$('input[name=register_speciality]').on('focus', function () {
		$(this).next('.name_lpu').addClass('active')
		$('.type_of_inst').removeClass('active')
	})

	$('input[name=register_type_institution]').on('focus', function () {
		$(this).next('.type_of_inst').addClass('active');
		$('.name_lpu').removeClass('active')
	})

	$('#city_id').on('focus', function () {
		$(this).next('.city_array').addClass('active')
	})

	$('#name_inst_id').on('focus', function () {
		$(this).next('.name_inst').addClass('active')
	})
	$('#address_lpu_id').on('focus', function () {
		$(this).next('.register_address').addClass('active')
	})

	$('.name_lpu').on('click', '.item', function () {
		$(this).parents('.register_speciality_hidden').find('.input-hidden').text($(this).text())
		$(this).parents('.register_speciality_hidden').find('.input-hidden').css('display', 'block')
		$(this).parents('.register_speciality_hidden').find('input[type=text]').css('display', 'none')
		$(this).parents('.register_speciality_hidden').find('input[type=text]').val($(this).text())
		$(this).parents('.register_speciality_hidden').find('.name_lpu').removeClass('active')
	})

	$('.type_of_inst').on('click', '.item', function () {
		$(this).parents('.register_address_hidden').find('.input-hidden').text($(this).text())
		$(this).parents('.register_address_hidden').find('.input-hidden').css('display', 'block')
		$(this).parents('.register_address_hidden').find('input[type=text]').css('display', 'none')
		$(this).parents('.register_address_hidden').find('input[type=text]').val($(this).text())
		$(this).parents('.register_address_hidden').find('.type_of_inst').removeClass('active')
	})

	$(".label-radio").each(function () {
		const register_works_checked = $(this).find('input[name=place_of_work]').is(':checked')

		if (register_works_checked) {
			const register_works = $(this).find('input[name=place_of_work]').val()
			register_works == 'register_name_lpu'
				? $('.register_name_lpu_hidden').addClass('active-disabled')
				: $('.register_name_lpu_hidden').removeClass('active-disabled')

			register_works == 'register_address'
				? $('.register_address_hidden').addClass('active-disabled')
				: $('.register_address_hidden').removeClass('active-disabled')
		}
	})

	$('.label-radio').on('click', function () {
		const register_works = $(this).find('input[name=place_of_work]').val()

		if (register_works === 'register_name_lpu') {
			$('.register_name_lpu_hidden').addClass('active-disabled')
			$('.register_address_hidden').removeClass('active-disabled')

			$('#address_lpu_id').removeClass('error-required')
			$('.lpu_content').removeClass('error-required')
			$('#address_lpu_id').val('')
			$('#address_lpu_id2').removeClass('error-required')
			$('#address_lpu_id2').val('')
			$('.lpu_content span').text('Начните вводить адрес ЛПУ')

			$('.label-error-address-lpu').removeClass('active')
		} else {
			$('.register_name_lpu_hidden').removeClass('active-disabled')
			$('.register_address_hidden').addClass('active-disabled')
			$('#name_inst_id').removeClass('error-required')
			$('.inst_content').removeClass('error-required')
			$('#name_inst_id').val('')
			$('#type_inst_id').removeClass('error-required')
			$('#type_inst_id').val('')
			$('#type_inst_id').prev('.input-hidden').removeClass('error-required')
			$('#type_inst_id').prev('.input-hidden').text('Искать по всем типам')
			$('.inst_content span').text('Начните вводить название учреждения')
		}
	})

	$("input[type=tel]").mask("+7 ( 9 9 9 ) 9 9 9 - 9 9 - 9 9")
	$("input[type=tel]").attr('placeholder', '+7 ( _ _ _ ) _ _ _ - _ _ - _ _')

	$('.log-in-btn').on('click', function () {
		$('.register-section').css('display', 'none')
		$('.forgot-section').css('display', 'none')
		$('.log-in-section').css('display', 'block')
		$('.error-message').text('')
	})

	$('.register-btn').on('click', function () {
		$('.register-section').css('display', 'block')
		$('.log-in-section').css('display', 'none')
		$('.forgot-section').css('display', 'none')
		$('.error-message').text('')
	})

	$('.forgot-btn').on('click', function () {
		$('.register-section').css('display', 'none')
		$('.log-in-section').css('display', 'none')
		$('.forgot-section').css('display', 'block')
		$('.error-message').text('')
	})

	$('.close-modal').on('click', function () {
		$("body").removeClass("overhidden")
		$('.popup').fadeOut(300)
	})

	function validateForm() {

		// Согласие на обработку персональных данных
		let el_sign = $('input[name=personal_data]');
		let v_sign = el_sign.val() ? false : true;

		el_sign.is(':checked')
		if (!(el_sign.is(':checked'))) {
			v_sign = true;
			$('.error-message').text('Дайте свое согласие на обработку данных!');
		} else {
			v_sign = false;
		}

		// // Проверка e-mail
		var reg = /^\w+([\.-]?\w+)*@(((([a-z0-9]{2,})|([a-z0-9][-][a-z0-9]+))[\.][a-z0-9])|([a-z0-9]+[-]?))+[a-z0-9]+\.([a-z]{2}|(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|ru|museum))$/i;
		var el_e = $("input[name=register_email]");
		var v_email = el_e.val() ? false : true;

		if (!reg.test(el_e.val())) {
			v_email = true;
			$('.error-message').text('Вы указали недопустимый e-mail');
			el_e.addClass('error-required')
		} else {
			el_e.removeClass('error-required')
		}

		// Проверка паролей
		var el_p1 = $("input[name=register_password]");
		var el_p2 = $("input[name=register_password2]");

		var v_pass1 = el_p1.val() ? false : true;
		var v_pass2 = el_p1.val() ? false : true;

		if (el_p1.val() != el_p2.val()) {
			var v_pass1 = true;
			var v_pass2 = true;
			$('.error-message').text('Пароли не совпадают!');
			el_p1.addClass('error-required')
			el_p2.addClass('error-required')
		} else if (el_p1.val().length < 8 || !(/(?=.*\d)(?=.*[a-z\а-я])/i.test($("input[name=register_password]").val()))) {
			var v_pass1 = true;
			var v_pass2 = true;
			$('.error-message').text('Пароль должен содержать не менее восьми знаков и включать буквы и цифры');
			el_p1.addClass('error-required')
			el_p2.addClass('error-required')
		} else {
			el_p1.removeClass('error-required')
			el_p2.removeClass('error-required')
		}

		return (v_sign || v_email || v_pass1 || v_pass2);
	}

	function validateFormPassword() {

		// Проверка паролей
		var el_p1 = $("input[name=pwd2]");
		var el_p2 = $("input[name=pwd3]");

		var v_pass1 = el_p1.val() ? false : true;
		var v_pass2 = el_p1.val() ? false : true;

		if (el_p1.val() != el_p2.val()) {
			var v_pass1 = true;
			var v_pass2 = true;
			$('.error-message').text('Пароли не совпадают!');
		} else if (el_p1.val().length < 8 || !(/(?=.*\d)(?=.*[a-z\а-я])/i.test($("input[name=pwd2]").val()))) {
			var v_pass1 = true;
			var v_pass2 = true;
			$('.error-message').text('Пароль должен содержать не менее восьми знаков и включать буквы и цифры');
		}

		return (v_pass1 || v_pass2);
	}

	$('#register').on('submit', function (event) {
		if (validateForm()) { // если есть ошибки возвращает true
			event.preventDefault()
		} else {

			const login = $('#register')

			const action = 'ajax_register'

			const register_surname = $('input[name=register_surname]').val()
			const register_name = $('input[name=register_name]').val()
			const register_middle_name = $('input[name=register_middle_name]').val()
			const register_city = $('input[name=register_city]').val()

			const place_of_work = $('input[name=place_of_work]:checked').val()

			const register_address_lpu = $('input[name=register_address_lpu]').val()
			const register_address_lpu2 = $('input[name=register_address_lpu2]').val()
			const register_type_institution = $('input[name=register_type_institution]').val()
			const register_name_institution = $('input[name=register_name_institution]').val()
			const register_speciality = $('input[name=register_speciality]').val()

			const register_email = $('input[name=register_email]').val()
			const register_password = $('input[name=register_password]').val()
			const register_password2 = $('input[name=register_password2]').val()
			const register_phone = $('input[name=register_phone]').val()

			const personal_data = $('input[name=personal_data]').prop("checked")
			const notifications = $('input[name=notifications]').prop("checked")

			const security = $('#register_security').val()
			const email_status = $('input[name=email_status]').val()

			$.ajax({
				type: 'POST',
				url: ajax_auth_object.ajaxurl,
				data: {
					action, register_surname, register_name, register_middle_name, register_city,
					place_of_work, register_address_lpu, register_address_lpu2, register_type_institution, register_name_institution, register_speciality,
					register_email, register_password, register_password2, register_phone,
					personal_data, notifications, security, email_status
				},
				dataType: 'json',
				beforeSend: function () {
					$('.send-btn').text('Загрузка...')
				},
				success: function (data) {
					console.log(data)
					if (data.loggedin) {
						login[0].reset()
						// document.location.href = ajax_auth_object.redirecturl
						$('.user-email').text(data.user_email)
						$("body").addClass("overhidden")
						$('.popup-register').fadeIn(300)
					} else {
						$('.error-message').text(data.message)
						data.info.last_name.length >= 2
							? $('input[name=register_surname]').removeClass('error-required')
							: $('input[name=register_surname]').addClass('error-required')
						data.info.first_name.length >= 2
							? $('input[name=register_name]').removeClass('error-required')
							: $('input[name=register_name]').addClass('error-required')
						data.info.register_middle_name.length >= 2
							? $('input[name=register_middle_name]').removeClass('error-required')
							: $('input[name=register_middle_name]').addClass('error-required')


						if (data.info.register_city.length >= 2) {
							$('input[name=register_city]').removeClass('error-required')
							$('.city_content').removeClass('error-required')
						} else {
							$('input[name=register_city]').addClass('error-required')
							$('.city_content').addClass('error-required')
						}

						if (data.info.register_speciality.length >= 2) {
							$('input[name=register_speciality]').removeClass('error-required')
							$('input[name=register_speciality]').prev('.input-hidden').removeClass('error-required')
						} else {
							$('input[name=register_speciality]').addClass('error-required')
							$('input[name=register_speciality]').prev('.input-hidden').addClass('error-required')
						}
						data.info.user_email.length >= 2
							? $('input[name=register_email]').removeClass('error-required')
							: $('input[name=register_email]').addClass('error-required')
						data.info.user_pass.length >= 2
							? $('input[name=register_password]').removeClass('error-required')
							: $('input[name=register_password]').addClass('error-required')
						data.info.register_phone.length >= 2
							? $('input[name=register_phone]').removeClass('error-required')
							: $('input[name=register_phone]').addClass('error-required')

						if (data.info.place_of_work === 'register_name_lpu') {
							if (data.info.register_type_institution.length >= 2) {
								$('input[name=register_type_institution]').removeClass('error-required')
								$('input[name=register_type_institution]').prev('.input-hidden').removeClass('error-required')
							} else {
								$('input[name=register_type_institution]').addClass('error-required')
								$('input[name=register_type_institution]').prev('.input-hidden').addClass('error-required')
							}
							if (data.info.register_name_institution.length >= 2) {
								$('input[name=register_name_institution]').removeClass('error-required')
								$('.inst_content').removeClass('error-required')
							} else {
								$('input[name=register_name_institution]').addClass('error-required')
								$('.inst_content').addClass('error-required')
							}

							$('input[name=register_address_lpu]').removeClass('error-required')
						} else {

							if (data.info.register_address_lpu.length >= 2) {
								$('input[name=register_address_lpu]').removeClass('error-required')
								$('.lpu_content').removeClass('error-required')
							} else {
								$('input[name=register_address_lpu]').addClass('error-required')
								$('.lpu_content').addClass('error-required')
							}

							$('input[name=register_name_institution]').removeClass('error-required')
							$('input[name=register_type_institution]').removeClass('error-required')
							$('input[name=register_type_institution]').prev('.input-hidden').removeClass('error-required')
						}
					}
					$('.send-btn').text('Зарегистрироваться')
				}
			})
			return false
		}
	})

	$('#login').on('submit', function () {
		const login = $(this)

		const action = 'ajax_login'
		const username = $('input[name=username]').val()
		const password = $('input[name=password]').val()
		const remember = $('input[name=remember]').val()
		const security = $('#security').val()

		$.ajax({
			type: 'POST',
			url: ajax_auth_object.ajaxurl,
			data: { action, username, password, remember, security },
			dataType: 'json',
			beforeSend: function () {
				$('.send-btn').text('Загрузка...')
			},
			success: function (data) {
				data.loggedin ? login[0].reset() : $('.error-message').text(data.message)
				$('.send-btn').text('Войти')

				if (data.loggedin == true) {
					document.location.href = ajax_auth_object.redirecturl
				}
			}
		})
		return false
	})

	$('#update_profile').on('submit', function () {
		const action = 'ajax_update_profile'

		const update_last_name = $('input[name=update_last_name]').val()
		const update_first_name = $('input[name=update_first_name]').val()
		const update_middle_name = $('input[name=update_middle_name]').val()
		const update_city = $('input[name=update_city]').val()

		const place_of_work = $('input[name=place_of_work]:checked').val()

		const update_address_lpu = $('input[name=update_address_lpu]').val()
		const update_address_lpu2 = $('input[name=update_address_lpu2]').val()
		const update_type_institution = $('input[name=update_type_institution]').val()
		const update_name_institution = $('input[name=update_name_institution]').val()
		const update_speciality = $('input[name=update_speciality]').val()

		const update_email = $('input[name=update_email]').val()
		const pwd1 = $('input[name=pwd1]').val()
		const pwd2 = $('input[name=pwd2]').val()
		const pwd3 = $('input[name=pwd3]').val()
		const update_phone = $('input[name=update_phone]').val()

		const security = $('#update_security').val()

		$.ajax({
			type: 'POST',
			url: ajax_auth_object.ajaxurl,
			data: {
				action, update_last_name, update_first_name, update_middle_name, update_city,
				place_of_work, update_address_lpu, update_address_lpu2, update_type_institution, update_name_institution, update_speciality,
				update_email, pwd1, pwd2, pwd3, update_phone, security
			},
			dataType: 'json',
			beforeSend: function () {
				$('.send-btn').text('Загрузка...')
			},
			success: function (data) {
				console.log(data)
				if (data.loggedin) {
					$("body").addClass("overhidden")
					$('.popup-update-profile').fadeIn(300)
					$('input[name=pwd1]').val('')
					$('input[name=pwd2]').val('')
					$('input[name=pwd3]').val('')
					$('input').removeClass('error-required')
					$('.error-message').text('')
				} else {
					$('.error-message').text(data.message)
					data.info.update_middle_name.length >= 2
						? $('input[name=update_middle_name]').removeClass('error-required')
						: $('input[name=update_middle_name]').addClass('error-required')
					data.info.update_city.length >= 2
						? $('input[name=update_city]').removeClass('error-required')
						: $('input[name=update_city]').addClass('error-required')
					data.info.update_address_lpu.length >= 2
						? $('input[name=update_address_lpu]').removeClass('error-required')
						: $('input[name=update_address_lpu]').addClass('error-required')

					if (data.info.update_speciality.length >= 2) {
						$('input[name=update_speciality]').removeClass('error-required')
						$('input[name=update_speciality]').prev('.input-hidden').removeClass('error-required')
					} else {
						$('input[name=update_speciality]').addClass('error-required')
						$('input[name=update_speciality]').prev('.input-hidden').addClass('error-required')
					}
					data.info.update_phone.length >= 2
						? $('input[name=update_phone]').removeClass('error-required')
						: $('input[name=update_phone]').addClass('error-required')
					data.info.update_email.length >= 2
						? $('input[name=update_email]').removeClass('error-required')
						: $('input[name=update_email]').addClass('error-required')
					data.info.update_last_name.length >= 2
						? $('input[name=update_last_name]').removeClass('error-required')
						: $('input[name=update_last_name]').addClass('error-required')
					data.info.update_first_name.length >= 2
						? $('input[name=update_first_name]').removeClass('error-required')
						: $('input[name=update_first_name]').addClass('error-required')

					if (data.info.place_of_work === 'register_name_lpu') {
						if (data.info.update_type_institution.length >= 2) {
							$('input[name=update_type_institution]').removeClass('error-required')
							$('input[name=update_type_institution]').prev('.input-hidden').removeClass('error-required')
						} else {
							$('input[name=update_type_institution]').addClass('error-required')
							$('input[name=update_type_institution]').prev('.input-hidden').addClass('error-required')
						}
						data.info.update_name_institution.length >= 2
							? $('input[name=update_name_institution]').removeClass('error-required')
							: $('input[name=update_name_institution]').addClass('error-required')

						$('input[name=update_address_lpu]').removeClass('error-required')
					} else {
						data.info.update_address_lpu.length >= 2
							? $('input[name=update_address_lpu]').removeClass('error-required')
							: $('input[name=update_address_lpu]').addClass('error-required')

						$('input[name=update_name_institution]').removeClass('error-required')
						$('input[name=update_type_institution]').removeClass('error-required')
						$('input[name=update_type_institution]').prev('.input-hidden').removeClass('error-required')
					}

				}

				$('.send-btn').text('Сохранить')
			}
		})
		return false
	})

	$('#forgot_password').on('submit', function () {

		const action = 'ajax_forgot_password'
		const user_login = $('input[name=user_login]').val()
		const security = $('#forgot_security').val()

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajax_auth_object.ajaxurl,
			data: { action, user_login, security },
			beforeSend: function () {
				$('.send-btn').text('Загрузка...')
			},
			success: function (data) {
				if (data.loggedin) {
					$('input[name=user_login]').val('')
					$('.user-email').text(data.user_email)
					$("body").addClass("overhidden")
					$('.popup-forgot').fadeIn(300)
				} else {
					$('.error-message').text(data.message)
				}
				$('.send-btn').text('Отправить')
			}
		})
		return false
	})

	$('#reset_password').on('submit', function (event) {
		if (validateFormPassword()) { // если есть ошибки возвращает true
			event.preventDefault()
		} else {
			const action = 'ajax_reset_password'

			const pwd2 = $('input[name=pwd2]').val()
			const pwd3 = $('input[name=pwd3]').val()

			const get_login = window.location.href.split('&').pop()
			const get_user_key = window.location.href.split('?').pop().split('&')[0]

			const user_login = get_login.split('=').pop()
			const user_key = get_user_key.split('=').pop()

			const security = $('#reset_password_security').val()

			$.ajax({
				type: 'POST',
				url: ajax_auth_object.ajaxurl,
				data: { action, pwd2, pwd3, security, user_login, user_key },
				dataType: 'json',
				beforeSend: function () {
					$('.send-btn').text('Загрузка...')
				},
				success: function (data) {
					if (data.loggedin) {
						$('input[name=pwd2]').val('')
						$('input[name=pwd3]').val('')
						$("body").addClass("overhidden")
						$('.popup-reset-password').fadeIn(300)
					} else {
						$('.error-message').text(data.message)
					}

					$('.send-btn').text('Сохранить')
				}
			})
			return false
		}
	})

	$.getJSON(urlJson).then(data => {

		let city = data.map(el => `${el.CITY_TYPE} ${el.CITY} (${el.REGION} обл.)`)
		let cityFilter = [...new Set(city)]

		$('#city_id').bind('input', function () {

			const valThis = $(this).val()
			const length = $(this).val().length

			if (length > 0) {

				let rew = cityFilter.filter(el => el.indexOf(valThis) !== -1)
				$('.city_array').html(rew.map(el => `<div class="item">${el}</div>`))

				$('.city_array .item').each(function () {
					const text = $(this).text();
					const textL = text.toLowerCase();
					const position = textL.indexOf(valThis.toLowerCase());

					if (position !== -1) {
						const matches = text.substring(position, (valThis.length + position));
						const regex = new RegExp(matches, 'ig');
						const highlighted = text.replace(regex, `<mark>${matches}</mark>`);

						$(this).html(highlighted).show();
					} else {
						$(this).text(text);
						$(this).hide();
					}
				})
			}
		})

		$('#name_inst_id').bind('input', function () {

			const valCity = $('#city_id').val()
			const valThis = $(this).val().toLowerCase()
			const length = $(this).val().length

			if (length > 0) {
				let rew = data.filter(el => valCity !== '' ? el.NAME.toLowerCase().indexOf(valThis) !== -1 && valCity == `${el.CITY_TYPE} ${el.CITY} (${el.REGION} обл.)` : el.NAME.toLowerCase().indexOf(valThis) !== -1)

				$('.name_inst').html(rew.map(el => `<div class="item">${el.NAME}</div>`))

				$('.name_inst .item').each(function () {
					const text = $(this).text();
					const textL = text.toLowerCase();
					const position = textL.indexOf(valThis.toLowerCase());

					if (position !== -1) {
						const matches = text.substring(position, (valThis.length + position));
						const regex = new RegExp(matches, 'ig');
						const highlighted = text.replace(regex, `<mark>${matches}</mark>`);

						$(this).html(highlighted).show();
					} else {
						$(this).text(text);
						$(this).hide();
					}
				})
			}
		})

		$('#address_lpu_id').bind('input', function () {

			const valCity = $('#city_id').val()
			const valThis = $(this).val().toLowerCase()
			const length = $(this).val().length

			if (length > 0) {
				let rew = data.filter(el => valCity !== '' ? `${el.STREET_TYPE} ${el.STREET} ${el.HOUSE}, ${el.NAME}`.toLowerCase().indexOf(valThis) !== -1 && valCity == `${el.CITY_TYPE} ${el.CITY} (${el.REGION} обл.)` : `${el.STREET_TYPE} ${el.STREET} ${el.HOUSE}, ${el.NAME}`.toLowerCase().indexOf(valThis) !== -1)
				$('.register_address').addClass('active')
				$('.register_address').html(rew.map(el => `<div class="item">${el.STREET_TYPE} ${el.STREET} ${el.HOUSE}, ${el.NAME}</div>`))

				$('.register_address .item').each(function () {
					const text = $(this).text()
					const textL = text.toLowerCase()
					const position = textL.indexOf(valThis.toLowerCase())

					if (position !== -1) {
						const matches = text.substring(position, (valThis.length + position))
						const regex = new RegExp(matches, 'ig')
						const highlighted = text.replace(regex, `<mark>${matches}</mark>`)

						$(this).html(highlighted).show()
					} else {
						$(this).text(text)
						$(this).hide()
					}
				})
			} else {
				// $(this).val('')
				$('.register_address').removeClass('active')
				$('.label-error-address-lpu').removeClass('active')
			}

			if (Number($('.register_address .item').length) === 0) {
				$('.label-error-address-lpu').addClass('active')
				$('#address_lpu_id2').val(valThis)
			}

		})

		$('#address_lpu_id2').bind('input', function () {
			const length = $(this).val().length
			if (length == 0) {
				$('.label-error-address-lpu').removeClass('active')
			}

		})
	})

	$('.city_array').on('click', '.item', function () {
		$(this).parents('.register_address_hidden').find('input[type=text]').val($(this).text())
		$(this).parents('.register_address_hidden').find('.city_content span').text($(this).text())
		$(this).parents('.register_address_hidden').find('.city_array').removeClass('active')
	})

	$('.name_inst').on('click', '.item', function () {
		$(this).parents('.register_address_hidden').find('input[type=text]').val($(this).text())
		$(this).parent('.name_inst').removeClass('active')
		// $("body").find(".name_inst").removeClass('active')
	})

	$('.register_address').on('click', '.item', function () {
		$(this).parents('.register_name_lpu_hidden').find('input[type=text]').val($(this).text())
		$(this).parent('.register_address').removeClass('active')
	})

	$('#address_lpu_id2').on('focus', function () {
		$('#address_lpu_id').val('')
	})

	$('.city_content').on('click', function () {
		$(this).css('display', 'none')
		$(this).parents('.input_hidden').find('#city_id').css('display', 'block')
	})

	$('.city_array').on('click', '.item', function () {
		$(this).parents('.input_hidden').find('input[type=text]').val($(this).text())
		$(this).parents('.input_hidden').find('input[type=text]').css('display', 'none')
		$(this).parents('.input_hidden').find('.city_content span').text($(this).text())
		$(this).parents('.input_hidden').find('.city_content').css('display', 'flex')
		let height = $(this).parents('.input_hidden').find('.city_content span').height()
		$(this).parents('.input_hidden').find('.city_array').removeClass('active')
		let cnt = height / 19
		if (cnt > 1) {
			$(this).parents('.input_hidden').find('.city_content').css('height', '69px')
		} else {
			$(this).parents('.input_hidden').find('.city_content').css('height', '50px')
		}
		if (cnt >= 3) {
			$(this).parents('.input_hidden').find('.city_content').css('height', '69px')
			$(this).parents('.input_hidden').find('.city_content span').addClass('active')
		}
	})

	$('.lpu_content').on('click', function () {
		$(this).css('display', 'none')
		$(this).parents('.input_hidden').find('#address_lpu_id').css('display', 'block')
	})

	$('.register_address').on('click', '.item', function () {
		$('.label-error-address-lpu').removeClass('active')
		$(this).parents('.input_hidden').find('input[type=text]').val($(this).text())
		$(this).parents('.input_hidden').find('input[type=text]').css('display', 'none')
		$(this).parents('.input_hidden').find('.lpu_content span').text($(this).text())
		$(this).parents('.input_hidden').find('.lpu_content').css('display', 'flex')
		let height = $(this).parents('.input_hidden').find('.lpu_content span').height()
		$(this).parents('.input_hidden').find('.register_address').removeClass('active')
		let cnt = height / 19
		if (cnt > 1) {
			$(this).parents('.input_hidden').find('.lpu_content').css('height', '69px')
		} else {
			$(this).parents('.input_hidden').find('.lpu_content').css('height', '50px')
		}
		if (cnt >= 3) {
			$(this).parents('.input_hidden').find('.lpu_content').css('height', '69px')
			$(this).parents('.input_hidden').find('.lpu_content span').addClass('active')
		}
	})


	$('.inst_content').on('click', function () {
		$(this).css('display', 'none')
		$(this).parents('.input_hidden').find('#name_inst_id').css('display', 'block')
	})

	$('.name_inst').on('click', '.item', function () {

		$(this).parents('.input_hidden').find('input[type=text]').val($(this).text())
		$(this).parents('.input_hidden').find('input[type=text]').css('display', 'none')
		$(this).parents('.input_hidden').find('.inst_content span').text($(this).text())
		$(this).parents('.input_hidden').find('.inst_content').css('display', 'flex')
		let height = $(this).parents('.input_hidden').find('.inst_content span').height()
		$(this).parents('.input_hidden').find('.name_inst').removeClass('active')
		let cnt = height / 19
		if (cnt == 2) {
			$(this).parents('.input_hidden').find('.inst_content').css('height', '69px')
		} else if (cnt == 3) {
			$(this).parents('.input_hidden').find('.inst_content').css('height', '88px')
		} else {
			$(this).parents('.input_hidden').find('.inst_content').css('height', '50px')
		}
		if (cnt >= 4) {
			$(this).parents('.input_hidden').find('.inst_content').css('height', '88px')
			$(this).parents('.input_hidden').find('.inst_content span').addClass('active_inst')
		}

	})

	$('.edit_photo').on('click', function () {
		const srcIMG = $('.profile_photo_ajax').attr('src')
		const style = $('.profile_photo_ajax').attr('style')
		const turn = $('.profile_photo_ajax').data('turn')

		$('#user_photo_ajax').attr('src', srcIMG)
		$('#user_photo_ajax').attr('style', style)

		$('input[name=turn_photo]').val(turn)

		$("body").addClass("overhidden")
		$('.popup-photo').fadeIn(300)
	})

	$('.svg-question').on('click', function () {
		$('.text-info').toggleClass('active')
	})

	$('#checkrem').prop("checked", false)

	$('.delete-photo').on('click', function () {
		$(this).next('#checkrem').prop("checked", true)
		$('#update_photo_form').submit()
	})

	$('#update_photo_form').on('submit', function () {
		let rew = document.forms.ret
		let formData = new FormData(rew);
		formData.append('file', $("input[name=update_photo_input]")[0].files[0]);
		$.ajax({
			type: 'POST',
			dataType: 'json',
			contentType: false,
			processData: false,
			url: ajax_auth_object.ajaxurl,
			data: formData,
			beforeSend: function () {
				$('.save-photo').text('Загрузка...')
			},
			success: function (data) {
				console.log(data)
				if (data.status === 'ok') {
					if (data.removemyAvatar) {
						const file_dir = data.site_dir + '/wp-content/uploads/myAvatar/default.jpg'
						$('#user_photo_ajax').attr('src', file_dir)
						$('.profile_photo_ajax').attr('src', file_dir)
					}
					if (data.file_name) {
						const file_dir = data.site_dir + '/wp-content/uploads/myAvatar/' + data.file_name
						$('#user_photo_ajax').attr('src', file_dir)
						$('.profile_photo_ajax').attr('src', file_dir)
					}
					$('.profile_photo_ajax').css('transform', `rotate(${+data.turn}deg) scale(${+data.range / 100})`)
					$('#checkrem').prop("checked", false)
					$('.text-info').removeClass('active')
				} else {
					$('.text-info').addClass('active')
				}
				$('.save-photo').text('Да, сохранить')
			}
		})
		return false
	})

	// Загружать картинку через type=file в тег img
	$('#update_photo_input').on('change', function () {
		const fileReader = new FileReader();
		fileReader.onload = function () {
			$('#user_photo_ajax').attr('src', fileReader.result) // id img
		}
		fileReader.readAsDataURL($("input[name=update_photo_input]")[0].files[0])
	})

	$('.svg-turn').on('click', function () {
		let turn = $('input[name=turn_photo]').val()
		const scale = +$('input[name=range_slider_photo]').val() / 100
		const value = turn >= 270 ? 0 : Number($('input[name=turn_photo]').val()) + 90
		$('input[name=turn_photo]').val(+value)
		$('#user_photo_ajax').css('transform', `rotate(${+value}deg) scale(${scale})`)
	})

	function setRightValue() {
		let min = parseInt($("#input-right").attr('min')),
			max = parseInt($("#input-right").attr('max')),
			text = Math.max(parseInt($("#input-right").val())),
			percent = ((text - min) / (max - min)) * 100;

		const turn = $('input[name=turn_photo]').val()
		const scale = +text / 100
		$("#input-right").val(text);
		$(".slider > .thumb.right").css('right', (100 - percent) + "%");
		$(".slider > .range").css('right', (100 - percent) + "%")
		$('#user_photo_ajax').css('transform', `rotate(${+turn}deg) scale(${scale})`)
	}
	setRightValue()

	$("#input-right").bind("input", setRightValue)






})(jQuery)