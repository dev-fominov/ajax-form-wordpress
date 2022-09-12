<?php

add_filter('show_admin_bar', '__return_false'); // отключить верхнюю панель администратора

// Register Style And Scripts
function gulp_scripts()
{
	wp_enqueue_style('gulp-style', get_stylesheet_uri(), '1.1', true);
	wp_enqueue_style('gulp-main', get_template_directory_uri() . '/assets/main.min.css', '1.1', true);

	// при подключении slick.min.js будут проблемы с работой слайдеров
	wp_enqueue_script('gulp-maskedinput', get_template_directory_uri() . '/assets/js/jquery.maskedinput.min.js', ['jquery'], '1.1', true);
	wp_register_script('gulp-script', get_template_directory_uri() . '/assets/main.min.js', ['jquery'], '1.1', true);

	wp_enqueue_script('gulp-script');

	wp_localize_script('gulp-script', 'ajax_auth_object', array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'redirecturl' => home_url(),
		'loadingmessage' => __('Sending user info, please wait...')
	));
}
// Добавить скрипты и стили на сайт
add_action('wp_enqueue_scripts', 'gulp_scripts');


add_action('wp_ajax_log_in', 'log_in');
add_action('wp_ajax_nopriv_log_in', 'log_in');

function log_in()
{


	echo json_encode([
		'_POST' => $_POST,
	]);


	// wp_send_json($json_encode);
	die;
}

add_action('wp_ajax_ajax_register', 'ajax_register');
add_action('wp_ajax_nopriv_ajax_register', 'ajax_register');

add_action('wp_ajax_ajax_login', 'ajax_login');
add_action('wp_ajax_nopriv_ajax_login', 'ajax_login');

add_action('wp_ajax_ajax_update_profile', 'ajax_update_profile');
add_action('wp_ajax_nopriv_ajax_update_profile', 'ajax_update_profile');

add_action('wp_ajax_ajax_forgot_password', 'ajax_forgot_password');
add_action('wp_ajax_nopriv_ajax_forgot_password', 'ajax_forgot_password');

add_action('wp_ajax_ajax_reset_password', 'ajax_reset_password');
add_action('wp_ajax_nopriv_ajax_reset_password', 'ajax_reset_password');

function ajax_login()
{

	check_ajax_referer('ajax-login-nonce', 'security');
	
	if ($_POST['username'] && $_POST['password'] && $_POST['remember']) {
		auth_user_login($_POST['username'], $_POST['password'], $_POST['remember'], 'Авторизация', null);
	} else {
		echo json_encode(['loggedin' => false, 'message' => __('Неправильно указали e-mail или пароль')]);
	}

	die();
}

function ajax_register()
{

	check_ajax_referer('ajax-register-nonce', 'security');

	$info = [];
	$info['last_name'] = sanitize_text_field($_POST['register_surname']);
	$info['first_name']  = sanitize_user($_POST['register_name']);
	$info['nickname'] = $info['user_login'] = $info['user_nicename'] = stristr(sanitize_email($_POST['register_email']), '@', true) . mt_rand(1, 9999);
	$info['register_middle_name'] = sanitize_text_field($_POST['register_middle_name']);
	$info['register_city'] = sanitize_text_field($_POST['register_city']);
	$info['display_name'] = $_POST['register_surname'] . ' ' . $_POST['register_name'];

	$info['place_of_work'] = sanitize_text_field($_POST['place_of_work']);
	$info['register_address_lpu'] = sanitize_text_field($_POST['register_address_lpu']);
	$info['register_address_lpu2'] = sanitize_text_field($_POST['register_address_lpu2']);
	$info['register_type_institution'] = sanitize_text_field($_POST['register_type_institution']);
	$info['register_name_institution'] = sanitize_text_field($_POST['register_name_institution']);
	$info['register_speciality'] = sanitize_text_field($_POST['register_speciality']);

	$info['user_email'] = sanitize_email($_POST['register_email']);
	$info['user_pass'] = sanitize_text_field($_POST['register_password']);
	$info['register_phone'] = sanitize_text_field($_POST['register_phone']);

	$info['personal_data'] = sanitize_text_field($_POST['personal_data']);
	$info['notifications'] = sanitize_text_field($_POST['notifications']);
	$info['security'] = sanitize_text_field($_POST['security']);

	$info['email_status'] = sanitize_text_field($_POST['email_status']);

	// // Register the user
	if (
		empty($_POST['register_surname'])
		|| empty($_POST['register_name'])
		|| empty($_POST['register_middle_name'])
		|| empty($_POST['register_city'])

		|| empty($_POST['register_speciality'])

		|| empty($_POST['register_email'])
		|| empty($_POST['register_password'])
		|| empty($_POST['register_phone'])
	) {
		echo json_encode([
			'loggedin' => false,
			'message' => 'Найдены ошибки. Проверьте, всё ли верно заполнено в полях, подсвеченных красным',
			'info' => $info
		]);
	} else {
		if ((($_POST['place_of_work'] === 'register_address') && empty($_POST['register_type_institution']) && empty($_POST['register_name_institution']) && !empty($_POST['register_address_lpu'])) || (($_POST['place_of_work'] === 'register_name_lpu') && empty($_POST['register_address_lpu']) && !empty($_POST['register_type_institution']) && !empty($_POST['register_name_institution']))) {
			$user_register = wp_insert_user($info);
			$user = get_user_by('email', $info['user_email']);

			wp_new_user_notification($user->ID, null, 'both');

			if (is_wp_error($user_register)) {

				$error  = $user_register->get_error_codes();

				if (in_array('empty_user_login', $error))
					echo json_encode(['loggedin' => false, 'class' => 'error', 'info' => $info, 'message' => __($user_register->get_error_message('empty_user_login'))]);
				elseif (in_array('existing_user_login', $error))
					echo json_encode(['loggedin' => false, 'class' => 'error', 'info' => $info, 'message' => __($user_register->get_error_message('existing_user_login'))]);
				elseif (in_array('existing_user_email', $error))
					echo json_encode(['loggedin' => false, 'class' => 'error', 'info' => $info, 'message' => __($user_register->get_error_message('existing_user_email'))]);
			} else {
				auth_user_login($info['nickname'], $info['user_pass'], true, 'Регистрация', $info['user_email']);
			}
		} else {
			echo json_encode([
				'loggedin' => false,
				'message' => 'Найдены ошибки. Проверьте, всё ли верно заполнено в полях, подсвеченных красным',
				'info' => $info
			]);
		}
	}

	die;
}

function ajax_forgot_password()
{

	check_ajax_referer('ajax-forgot-nonce', 'security');

	global $wpdb;
	$user_login = $_POST['user_login'];

	if (empty($user_login)) {
		$error = 'Введите e-mail, указанный при регистрации';
	} else {
		if (is_email($user_login)) {
			if (email_exists($user_login)) {
				$get_by = 'email';
			} else {
				$error = 'Пользователь с таким e-mail адресом не зарегистрирован';
			}
		}
	}

	if (empty($error)) {
		$user = get_user_by($get_by, $user_login);
		if ($user_login) {

			$from = 'МОЖНО ВВЕСТИ СВОЙ АДРЕС'; // Set whatever you want like mail@yourdomain.com

			if (!(isset($from) && is_email($from))) {
				$sitename = strtolower($_SERVER['SERVER_NAME']);
				if (substr($sitename, 0, 4) == 'www.') {
					$sitename = substr($sitename, 4);
				}
				$from = 'admin@' . $sitename;
			}

			$to = $user->user_email;
			$subject = 'Ваш новый пароль';
			$sender = 'Для: ' . get_option('name') . ' <' . $from . '>' . "\r\n";

			$key = wp_generate_password(20, false);
			do_action('retrieve_password_key', $user_login, $key);

			if (empty($wp_hasher)) {
				require_once ABSPATH . 'wp-includes/class-phpass.php';
				$wp_hasher = new PasswordHash(8, true);
			}

			$hashed = time() . ':' . $wp_hasher->HashPassword($key);
			$wpdb->update($wpdb->users, ['user_activation_key' => $hashed], ['user_email' => $user_login]);

			$message = __('Кто-то запросил сброс пароля для следующей учетной записи:') . "\r\n\r\n";
			$message .= network_home_url('/') . "\r\n\r\n";
			$message .= sprintf(__('E-mail: %s'), $user_login) . "\r\n\r\n";
			$message .= __('Если это была ошибка, просто проигнорируйте это письмо, и ничего не произойдет.') . "\r\n\r\n";
			$message .= __('Чтобы сбросить пароль, перейдите по ссылке:') . "\r\n\r\n";
			$message .= '<a href="' . network_site_url("reset-password/?key=$key&email=$user_login") . '" target="_blank">Перейти</a>';

			$message = apply_filters('retrieve_password_message', $message, $key);

			$headers[] = 'MIME-Version: 1.0' . "\r\n";
			$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers[] = "X-Mailer: PHP \r\n";
			$headers[] = $sender;

			$mail = wp_mail($to, $subject, $message, $headers);
			if ($mail)
				$success = 'Проверьте свой адрес электронной почты на наличие нового пароля';
			else
				$error = 'Система не может отправить вам письмо, содержащее ваш новый пароль';
		} else {
			$error = 'Ой! Что-то пошло не так при обновлении вашей учетной записи';
		}
	}

	if (!empty($error))
		echo json_encode(array('loggedin' => false, 'message' => __($error)));

	if (!empty($success))
		echo json_encode(['loggedin' => true, 'user_email' => $user_login, 'status' => 'ok', 'message' => __($success)]);

	die;
}

function ajax_reset_password()
{

	$user_login = str_ireplace("%40", "@", $_POST['user_login']);

	if (email_exists($user_login)) {

		$user = get_user_by('email', $user_login);
		$user_ID = $user->ID;
		$new_password = $_POST['pwd2'];

		// сначала проверяем соответствие нового пароля и его подтверждения
		if ($new_password == $_POST['pwd3']) {

			// пароль из двух символов нам не нужен, минимум 8
			if (strlen($new_password) < 8) {
				echo json_encode(['loggedin' => false, 'status' => 'short', 'message' => 'Пароль должен содержать не менее восьми знаков и включать буквы и цифры']);
			} else {
				wp_set_password($new_password, $user_ID);

				$creds['user_login'] = $user_login;
				$creds['user_password'] = $new_password;
				$creds['remember'] = true;

				echo json_encode(['loggedin' => true, 'status' => 'ok', 'message' => 'Пароль успешно изменён']);
			}
		} else {
			// новый пароль и его подтверждение не соответствуют друг другу
			echo json_encode(['loggedin' => false, 'status' => 'mismatch', 'message' => 'Новый пароль и его подтверждение не соответствуют друг другу']);
		}
	} else {
		echo json_encode(['loggedin' => false, 'status' => 'mismatch', 'message' => 'Нет пользователя с такой почтой']);
	}

	die;
}

function ajax_update_profile()
{

	$info = [];
	$info['update_last_name'] = sanitize_text_field($_POST['update_last_name']);
	$info['update_first_name']  = sanitize_user($_POST['update_first_name']);
	$info['update_middle_name'] = sanitize_text_field($_POST['update_middle_name']);
	$info['update_city'] = sanitize_text_field($_POST['update_city']);

	$info['update_address_lpu'] = sanitize_text_field($_POST['update_address_lpu']);
	$info['update_type_institution'] = sanitize_text_field($_POST['update_type_institution']);
	$info['update_name_institution'] = sanitize_text_field($_POST['update_name_institution']);
	$info['update_speciality'] = sanitize_text_field($_POST['update_speciality']);

	$info['place_of_work'] = sanitize_text_field($_POST['place_of_work']);

	$info['update_email'] = sanitize_email($_POST['update_email']);
	$info['update_phone'] = sanitize_text_field($_POST['update_phone']);

	require_once(dirname(__FILE__) . '/../../../wp/wp-load.php');

	$user_ID = get_current_user_id();
	$user = get_user_by('id', $user_ID);

	// // сначала обработаем пароли, ведь если при сохранении пользователь ничего не указал ни в одном поле пароля, то пропускаем эту часть
	if ($_POST['pwd1'] || $_POST['pwd2'] || $_POST['pwd3']) {

		// при этом пользователь должен заполнить все поля
		if ($_POST['pwd1'] && $_POST['pwd2'] && $_POST['pwd3']) {

			// сначала проверяем соответствие нового пароля и его подтверждения
			if ($_POST['pwd2'] == $_POST['pwd3']) {

				// пароль из двух символов нам не нужен, минимум 8
				if (strlen($_POST['pwd2']) < 8) {
					echo json_encode(['loggedin' => false, 'status' => 'short', 'message' => 'Пароль из двух символов нам не нужен, минимум 8']);
				}

				// и самое главное - проверяем, правильно ли указан старый пароль
				if (wp_check_password($_POST['pwd1'], $user->data->user_pass, $user->ID)) {
					// если да, меняем на новый и заново авторизуем пользователя
					wp_set_password($_POST['pwd2'], $user_ID);

					$creds['user_login'] = $user->user_login;
					$creds['user_password'] = $_POST['pwd2'];
					$creds['remember'] = true;
					$user = wp_signon($creds, false);
					echo json_encode(['loggedin' => true, 'status' => 'ok', 'message' => 'Пароль успешно изменён']);
				} else {
					echo json_encode(['loggedin' => false, 'status' => 'wrong', 'message' => 'Неправильно указан старый пароль']);
				}
			} else {
				// новый пароль и его подтверждение не соответствуют друг другу
				echo json_encode(['loggedin' => false, 'status' => 'mismatch', 'message' => 'Новый пароль и его подтверждение не соответствуют друг другу']);
			}
		} else {
			echo json_encode(['loggedin' => false, 'status' => 'required', 'message' => 'Пользователь должен заполнить все поля пароля']);
		}
	}

	if (
		empty($_POST['update_last_name'])
		|| empty($_POST['update_first_name'])
		|| empty($_POST['update_middle_name'])
		|| empty($_POST['update_city'])

		|| empty($_POST['update_speciality'])

		|| empty($_POST['update_phone'])
		|| empty($_POST['update_email'])
	) {
		// не все поля заполнены - перенеправляем
		echo json_encode([
			'loggedin' => false,
			'status' => 'required',
			'message' => 'Найдены ошибки. Проверьте, всё ли верно заполнено в полях, подсвеченных красным',
			'info' => $info
		]);
	} else {

		// если пользователь указал новый емайл, а кто-то уже под ним зареган - отправляем на ошибку
		if (email_exists($_POST['update_email']) && $_POST['update_email'] != $user->user_email) {
			echo json_encode([
				'loggedin' => false,
				'status' => 'exist',
				'message' => 'Указали новый емайл, а кто-то уже под ним зареган'
			]);
		} else {

			if ((($_POST['place_of_work'] === 'register_address') && empty($_POST['update_type_institution']) && empty($_POST['update_name_institution']) && !empty($_POST['update_address_lpu'])) || (($_POST['place_of_work'] === 'register_name_lpu') && empty($_POST['update_address_lpu']) && !empty($_POST['update_type_institution']) && !empty($_POST['update_name_institution']))) {
				// 	// обновляем данные пользователя
				wp_update_user([
					'ID' => $user_ID,
					'user_email' => $_POST['update_email'],
					'first_name' => $_POST['update_first_name'],
					'last_name' => $_POST['update_last_name'],
					'display_name' => $_POST['update_first_name'] . ' ' . $_POST['update_last_name']
				]);

				update_user_meta($user_ID, 'register_middle_name', $_POST['update_middle_name']);
				update_user_meta($user_ID, 'register_city', $_POST['update_city']);
				update_user_meta($user_ID, 'place_of_work', $_POST['place_of_work']);
				update_user_meta($user_ID, 'register_address_lpu', $_POST['update_address_lpu']);
				update_user_meta($user_ID, 'register_address_lpu2', $_POST['update_address_lpu2']);
				update_user_meta($user_ID, 'register_type_institution', $_POST['update_type_institution']);
				update_user_meta($user_ID, 'register_name_institution', $_POST['update_name_institution']);
				update_user_meta($user_ID, 'register_speciality', $_POST['update_speciality']);
				update_user_meta($user_ID, 'register_phone', $_POST['update_phone']);

				echo json_encode(['loggedin' => true, 'status' => 'ok', 'message' => 'Данные успешно изменены']);
			} else {
				echo json_encode([
					'loggedin' => false,
					'message' => 'Найдены ошибки. Проверьте, всё ли верно заполнено в полях, подсвеченных красным',
					'info' => $info
				]);
			}
		}
	}

	die;
}

function auth_user_login($user_login, $password, $remember, $login, $user_email)
{
	$info = [];
	$info['user_login'] = $user_login;
	$info['user_password'] = $password;
	$info['remember'] = $remember;

	$user_signon = wp_signon($info, false);
	if (is_wp_error($user_signon)) {
		echo json_encode(['loggedin' => false, 'message' => __('Неправильно указали e-mail или пароль')]);
	} else {
		wp_set_current_user($user_signon->ID);
		echo json_encode(['loggedin' => true, 'user_email' => $user_email, 'message' => __($login . ' успешна, перенаправление...')]);
	}

	die();
}

// Сохранение полей пользователя
add_action('user_register', 'true_register_fields');
function true_register_fields($user_id)
{

	update_user_meta($user_id, 'register_middle_name', sanitize_text_field($_POST['register_middle_name']));
	update_user_meta($user_id, 'register_city', sanitize_text_field($_POST['register_city']));
	update_user_meta($user_id, 'place_of_work', sanitize_text_field($_POST['place_of_work']));
	update_user_meta($user_id, 'register_address_lpu', sanitize_text_field($_POST['register_address_lpu']));
	update_user_meta($user_id, 'register_address_lpu2', sanitize_text_field($_POST['register_address_lpu2']));
	update_user_meta($user_id, 'register_type_institution', sanitize_text_field($_POST['register_type_institution']));
	update_user_meta($user_id, 'register_name_institution', sanitize_text_field($_POST['register_name_institution']));
	update_user_meta($user_id, 'register_speciality', sanitize_text_field($_POST['register_speciality']));
	update_user_meta($user_id, 'register_phone', sanitize_text_field($_POST['register_phone']));

	update_user_meta($user_id, 'register_security', sanitize_text_field($_POST['security']));
	update_user_meta($user_id, 'email_status', sanitize_text_field($_POST['email_status']));

	// update_user_meta($user_id, 'email_status', sanitize_text_field($_POST['email_status']));
}

add_filter('wp_new_user_notification_email', 'hpl_user_notification_email', 10, 3);
/**
 * Изменяет содержимое письма, отправляемое при регистрации нового пользователя с определённой ролью.
 *
 * @param array   $email_data
 * @param WP_User $user
 * @param string  $blogname
 *
 * @return array
 */
function hpl_user_notification_email($email_data, $user)
{

	$message = "Подтвердите E-mail по ссылке ниже \r\n\r\n";
	$message .= '<a href="' . network_site_url("/?key=$user->register_security&email=$user->user_email&email_status=active") . '" target="_blank">Подтвердить почту</a>';
	// $message .= print_r($user);

	$email_data['subject'] = 'Регистрация нового пользователя';
	$email_data['message'] = $message;

	return $email_data;
}

// ПОЛЯ РЕГИСТРАЦИИ ПОКАЗАТЬ В АДМИНКЕ В ПРОФИЛЕ
// когда пользователь сам редактирует свой профиль
add_action('show_user_profile', 'true_show_profile_fields');
// когда чей-то профиль редактируется админом например
add_action('edit_user_profile', 'true_show_profile_fields');

// Добавить поля --------------
function true_show_profile_fields($user)
{
	// выводим заголовок для наших полей
	echo '<h3>Дополнительная информация</h3>';
	// поля в профиле находятся в разметке таблиц <table>
	echo '<table class="form-table">';

	// добавляем поле город
	$register_middle_name = get_the_author_meta('register_middle_name', $user->ID);
	$register_city = get_the_author_meta('register_city', $user->ID);
	$place_of_work = get_the_author_meta('place_of_work', $user->ID);
	$register_address_lpu = get_the_author_meta('register_address_lpu', $user->ID);
	$register_address_lpu2 = get_the_author_meta('register_address_lpu2', $user->ID);
	$register_type_institution = get_the_author_meta('register_type_institution', $user->ID);
	$register_name_institution = get_the_author_meta('register_name_institution', $user->ID);
	$register_speciality = get_the_author_meta('register_speciality', $user->ID);
	$register_phone = get_the_author_meta('register_phone', $user->ID);

	$userdata = get_user_by('id', $user->ID);
	$last_name = $userdata->last_name;
	$first_name = $userdata->first_name;

	echo '<h2>Личные данные</h3>';
	echo '<tr><th><label for="last_name">Фамилия</label></th><td><input type="text" name="last_name" id="last_name" value="' . esc_attr($last_name) . '" class="regular-text" /></td></tr>';
	echo '<tr><th><label for="city">Имя</label></th><td><input type="text" name="first_name" id="first_name" value="' . esc_attr($first_name) . '" class="regular-text" /></td></tr>';
	echo '<tr><th><label for="register_middle_name">Отчество</label></th><td><input type="text" name="register_middle_name" id="register_middle_name" value="' . esc_attr($register_middle_name) . '" class="regular-text" /></td></tr>';
	echo '<tr><th><label for="register_city">Город</label></th><td><input type="text" name="register_city" id="register_city" value="' . esc_attr($register_city) . '" class="regular-text" /></td></tr>';
	echo '<tr><th><label for="register_phone">Телефон</label></th><td><input type="text" name="register_phone" id="register_phone" value="' . esc_attr($register_phone) . '" class="regular-text" /></td></tr>';
	echo '</table>';
	echo '<table class="form-table">';
	echo '<h2>Место работы</h2>';
	echo '<tr><th><label for="gender">Пол</label></th>
 		<td><ul>
 			<li><label><input value="register_name_lpu" name="place_of_work"' . checked($place_of_work, 'register_name_lpu', false) . ' type="radio" />По названию ЛПУ</label></li>
 			<li><label><input value="register_address" name="place_of_work"' . checked($place_of_work, 'register_address', false) . ' type="radio" />По адресу</label></li>
 		</ul></td>
 	</tr>';
	echo '<tr><th><label for="register_address_lpu">Адрес ЛПУ</label></th><td><input type="text" name="register_address_lpu" id="register_address_lpu" value="' . esc_attr($register_address_lpu) . '" class="regular-text" /></td></tr>';
	echo '<tr><th><label for="register_address_lpu2">Адрес ЛПУ 2</label></th><td><input type="text" name="register_address_lpu2" id="register_address_lpu2" value="' . esc_attr($register_address_lpu2) . '" class="regular-text" /></td></tr>';
	echo '<tr><th><label for="register_type_institution">Тип учреждения</label></th><td><input type="text" name="register_type_institution" id="register_type_institution" value="' . esc_attr($register_type_institution) . '" class="regular-text" /></td></tr>';
	echo '<tr><th><label for="register_name_institution">Название учреждения</label></th><td><input type="text" name="register_name_institution" id="register_name_institution" value="' . esc_attr($register_name_institution) . '" class="regular-text" /></td></tr>';
	echo '<tr><th><label for="register_speciality">Специальность</label></th><td><input type="text" name="register_speciality" id="register_speciality" value="' . esc_attr($register_speciality) . '" class="regular-text" /></td></tr>';
	// echo '<tr><th><label for="my_file">my_file</label></th><td><input type="file" name="my_file" id="my_file" value="' . esc_attr($my_file) . '" class="regular-text" /></td></tr>';
	// echo '<input type="file" name="my_file" id="my_file">';
	echo '</table>';
}

// Сохранить поля ---------------------------
// когда пользователь сам редактирует свой профиль
add_action('personal_options_update', 'true_save_profile_fields');
// когда чей-то профиль редактируется админом например
add_action('edit_user_profile_update', 'true_save_profile_fields');
function true_save_profile_fields($user_id)
{
	update_user_meta($user_id, 'register_middle_name', sanitize_text_field($_POST['register_middle_name']));
	update_user_meta($user_id, 'register_city', sanitize_text_field($_POST['register_city']));
	update_user_meta($user_id, 'place_of_work', sanitize_text_field($_POST['place_of_work']));
	update_user_meta($user_id, 'register_address_lpu', sanitize_text_field($_POST['register_address_lpu']));
	update_user_meta($user_id, 'register_address_lpu2', sanitize_text_field($_POST['register_address_lpu2']));
	update_user_meta($user_id, 'register_type_institution', sanitize_text_field($_POST['register_type_institution']));
	update_user_meta($user_id, 'register_name_institution', sanitize_text_field($_POST['register_name_institution']));
	update_user_meta($user_id, 'register_speciality', sanitize_text_field($_POST['register_speciality']));
	update_user_meta($user_id, 'register_phone', sanitize_text_field($_POST['register_phone']));
}




// АВАТАР

// if (!function_exists('VAB_user_fields')) {
function VAB_user_fields($user)
{
	global $pagenow;
	if ($pagenow == 'profile.php' || $pagenow == 'user-edit.php') {
		wp_nonce_field('VAB_mode_ufields_nonce', 'VAB_ufields_nonce');
		$id = $user->ID;
		$myAvatar = get_the_author_meta('myAvatar', $id);
		$del_But = '<span style="margin-bottom:-7px!important;cursor:pointer;" id="VAB_remove"width="auto" height="33">Удалить</span>';
		$avka = !empty($myAvatar) ? '<img style="width:100px;height:100px;object-fit: cover;" src="' . get_site_url() . "/wp-content/uploads/myAvatar/" . $myAvatar . '" />' . $del_But . '<input id="checkrem" style="display:none;" type="checkbox" name="removemyAvatar">' : '';
		echo '<label for="myAvatar">' . __('<h2>Пользовательский аватар</h2>', 'VAB') . ' »» ' . __('Можно загрузить картинку в формате png и jpg.<br> Размеры не меньше 200×200px, объём файла не больше 5 МБ.<br><br>', 'VAB') . ' <input type="file" name="filename" id="myAvatar"/></label>' .
			$avka . '<script 
			type="text/javascript">jQuery(\'form\').attr(\'enctype\',\'multipart/form-data\');jQuery(\'#checkrem\').prop("checked",false);jQuery(document).on(\'click\',\'#VAB_remove\',function(){jQuery(this).prev(\'img\').remove();jQuery(this).next(\'#checkrem\').prop("checked",true);});</script>';
	}
}
// }
add_action('show_user_profile', 'VAB_user_fields');
add_action('edit_user_profile', 'VAB_user_fields');


// if (!function_exists('save_VAB_user_fields')) {
function save_VAB_user_fields($user_id)
{
	$nonce = filter_input(INPUT_POST, 'VAB_ufields_nonce', FILTER_SANITIZE_STRING);
	if (!$nonce) {
		return;
	} //проверяем наши nonce поля
	if (!wp_verify_nonce($nonce, 'VAB_mode_ufields_nonce')) {
		return;
	} //проверяем наши nonce поля
	$myAvatar = get_the_author_meta('myAvatar', $user_id); //проверяем данные в базе

	if (is_uploaded_file($_FILES["filename"]["tmp_name"])) { //Если файл загружен при помощи HTTP POST
		$inp = $_FILES['filename'];
		$FILES_name = $inp['name'];
		$FILES_tmp_name = $inp['tmp_name']; //собираем данные на файл
		$ext = substr($FILES_name, strpos($FILES_name, '.'), strlen($FILES_name) - 1); //получаем расширение файла
		if ($ext == ".jpg" || $ext == '.jpeg' || $ext == '.png') { //если расширение jpg или jpeg
			$DiR = ABSPATH . 'wp-content/uploads/myAvatar';
			if (!file_exists($DiR)) { //если директории, куда будем отправлять аватарки нет
				mkdir($DiR, 0777, true);
			} // создадим её
			move_uploaded_file($FILES_tmp_name, $DiR . "/" . $user_id . '_' . $FILES_name); //перемещаем загруженный файл в директорию
			update_user_meta($user_id, 'myAvatar', $user_id . '_' . $FILES_name); //сохраняем в базе информацию о загруженном файле
		} else { //если расширение не прошло валидацию
			$erR = '<div class="error"><p><strong>' . __('Ошибка', 'VAB') . '</strong>: ' . __('Выбран неверный формат изображения', 'VAB') . '</p></div>'; //формируем для вывода на экран текст ошибки
			set_transient('erRorUser', array('nonce' => $erR), 10);
			return;
		}
	}
	//и сохраняем в базе во временной опции на 10 секунд
	if (isset($_POST['removemyAvatar']) && isset($myAvatar)) { //если при нажатии на кнопку «Обновить профиль» скрытый чекбокс был отмечен и есть данные в базе
		if (file_exists(ABSPATH . 'wp-content/uploads/myAvatar/' . $myAvatar)) {
			unlink(ABSPATH . 'wp-content/uploads/myAvatar/' . $myAvatar);
		} //удаляем файл, при наличии
		delete_user_meta($user_id, 'myAvatar');
	} //удаляем мета данные из базы
}
// }
add_action('personal_options_update', 'save_VAB_user_fields');
add_action('edit_user_profile_update', 'save_VAB_user_fields');


add_action('wp_ajax_ajax_update_photo', 'ajax_update_photo');
add_action('wp_ajax_nopriv_ajax_update_photo', 'ajax_update_photo');

function ajax_update_photo()
{

	// check_ajax_referer('ajax-update-photo-nonce', 'update_photo_security');

	$nonce = filter_input(INPUT_POST, 'update_photo_security', FILTER_SANITIZE_STRING);
	if (!$nonce) {
		return;
	} //проверяем наши nonce поля
	if (!wp_verify_nonce($nonce, 'ajax-update-photo-nonce')) {
		return;
	} //проверяем наши nonce поля

	$user_id = $_POST['user_id'];
	// $myAvatar = get_the_author_meta('myAvatar', $user_id);
	if ($_POST['file'] !== 'undefined') {
		if (is_uploaded_file($_FILES["update_photo_input"]["tmp_name"])) { //Если файл загружен при помощи HTTP POST
			$inp = $_FILES['update_photo_input'];
			$FILES_name = $inp['name'];
			$FILES_size = $inp['size'];
			$FILES_tmp_name = $inp['tmp_name']; //собираем данные на файл
			$ext = substr($FILES_name, strpos($FILES_name, '.'), strlen($FILES_name) - 1); //получаем расширение файла
			if ($ext == ".jpg" || $ext == '.jpeg' || $ext == '.png') { //если расширение jpg или jpeg
				if((int)$FILES_size < 2000000 && 3300 < (int)$FILES_size) {
					$DiR = ABSPATH . 'wp-content/uploads/myAvatar';
					if (!file_exists($DiR)) { //если директории, куда будем отправлять аватарки нет
						mkdir($DiR, 0777, true);
					} // создадим её
					move_uploaded_file($FILES_tmp_name, $DiR . "/" . $user_id . '_' . $FILES_name); //перемещаем загруженный файл в директорию
					update_user_meta($user_id, 'myAvatar', $user_id . '_' . $FILES_name); //сохраняем в базе информацию о загруженном файле
					update_user_meta($user_id, 'range', $_POST['range_slider_photo']);
					update_user_meta($user_id, 'turn', $_POST['turn_photo']);
	
					echo json_encode([
						'status' => 'ok',
						'$inp' => $inp,
						'range' => $_POST['range_slider_photo'],
						'turn' => $_POST['turn_photo'],
						'turn' => $_POST['turn_photo'],
						'file_size' => $FILES_size,
						'removemyAvatar' => $_POST['removemyAvatar'],
						'file_name' => $user_id . '_' . $FILES_name,
						'site_dir' => $_POST['site_dir'],
						'_POST' => $_POST
					]);
				} else {
					echo json_encode([
						'status' => 'size',
						'message' => 'Больше 2Мб',
					]);
				}
				
			} else { //если расширение не прошло валидацию
				echo json_encode([
					'status' => 'format',
					'message' => 'Можно загрузить картинку в формате png, jpg или jpeg.',
				]);
			}
		}
	} else {

		update_user_meta($user_id, 'range', $_POST['range_slider_photo']);
		update_user_meta($user_id, 'turn', $_POST['turn_photo']);

		echo json_encode([
			'status' => 'ok',
			'range' => $_POST['range_slider_photo'],
			'turn' => $_POST['turn_photo'],
			'site_dir' => $_POST['site_dir'],
			'removemyAvatar' => $_POST['removemyAvatar'],
			'_POST' => $_POST
		]);
	}

	// if (isset($_POST['removemyAvatar']) && isset($myAvatar)) { //если при нажатии на кнопку «Обновить профиль» скрытый чекбокс был отмечен и есть данные в базе
	// 	if (file_exists(ABSPATH . 'wp-content/uploads/myAvatar/' . $myAvatar)) {
	// 		unlink(ABSPATH . 'wp-content/uploads/myAvatar/' . $myAvatar);
	// 	} //удаляем файл, при наличии
	// 	delete_user_meta($user_id, 'myAvatar');
	// } //удаляем мета данные из базы



	die();
}


function my_checkRole(){
	if( !( current_user_can( 'administrator' ) ) && !( defined('DOING_AJAX') && DOING_AJAX ) ){
			wp_redirect( site_url( '/' ) );
			exit;
	}
}

add_action( 'admin_init', 'my_checkRole' );