<?php

global $user_ID;

// если пользователь не авторизован, отправляем его на страницу входа
if (!$user_ID) {
	header('location:' . site_url() . '/log-in/');
	exit;
} else {
	$userdata = get_user_by('id', $user_ID);
}
?>

<?php get_header(); ?>

<div class="profile-section">
	<div class="wrapper">
		<div class="profile-title">Настройки аккаунта</div>
		<p class="profile-description">Представитель компании Хеель <span class="svg-ok"><svg width="9" height="8" viewBox="0 0 9 8" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M1.5 4L4.11111 6L8 1" stroke="white" stroke-width="2" stroke-linecap="round" />
				</svg></span></p>

		<form id="update_profile" method="POST">

			<?php wp_nonce_field('ajax-update-nonce', 'update_security'); ?>

			<div class="content-profile">

				<div class="form-block">
					<div class="block-title">
						<span class="form-block-title">Личные данные</span>
					</div>
					<div class="profile-top-content">
						<div class="user-photo">
							<?php
							$myAvatar = get_the_author_meta('myAvatar', $user_ID);
							echo !empty($myAvatar) ? '<div class="img_photo" ><img class="profile_photo_ajax" data-turn="' . $userdata->turn . '" data-range="' . $userdata->range . '" style="transform:rotate(' . $userdata->turn . 'deg) scale(' . $userdata->range / 100 . ')" src="' . get_site_url() . "/wp-content/uploads/myAvatar/" . $myAvatar . '"  /></div>' : '<div class="img_photo" ><img class="profile_photo_ajax" style="transform:rotate(' . $userdata->turn . 'deg) scale(' . $userdata->range / 100 . ')" src="' . get_site_url() . '/wp-content/uploads/myAvatar/default.jpg"  /></div>';
							echo '<span class="edit_photo">Редактировать фото</span>';
							?>
						</div>
						<div class="form-content">
							<label>
								<span>Фамилия</span>
								<input type="text" name="update_last_name" class="required" value="<?php echo $userdata->last_name; ?>">
							</label>
							<label>
								<span>Имя</span>
								<input type="text" name="update_first_name" class="required" value="<?php echo $userdata->first_name; ?>">
							</label>
							<label>
								<span>Отчество</span>
								<input type="text" name="update_middle_name" class="required" value="<?php echo $userdata->register_middle_name; ?>">
							</label>
							<label class="input_hidden">
								<span>Город</span>
								<div class="city_content"><span><?php echo $userdata->register_city; ?></span></div>
								<input type="text" name="update_city" id="city_id" class="required" placeholder="Начните вводить название города" value="<?php echo $userdata->register_city; ?>">
								<div class="city_array"></div>
							</label>
						</div>
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
								<label class="label-radio label-radio-profile">
									<input type="radio" name="place_of_work" value="register_name_lpu" <?php if ($userdata->place_of_work === 'register_name_lpu') {
																																												echo 'checked';
																																											} ?>>
									<span>По названию ЛПУ</span>
								</label>
								<label class="label-radio label-radio-profile">
									<input type="radio" name="place_of_work" value="register_address" <?php if ($userdata->place_of_work === 'register_address') {
																																											echo 'checked';
																																										} ?>>
									<span>По адресу</span>
								</label>
							</div>
						</div>

						<label class="register_name_lpu_hidden input_hidden">
							<span>Адрес ЛПУ</span>
							<div class="lpu_content"><span><?php echo $userdata->register_address_lpu; ?></span></div>
							<input type="text" name="update_address_lpu" id="address_lpu_id" class="required" placeholder="Начните вводить адрес ЛПУ" value="<?php echo $userdata->register_address_lpu; ?>">
							<div class="register_address"></div>
						</label>
						<label class="label-error-address-lpu">
							<span class="error-address-lpu">Вашего ЛПУ нет в выпадающем списке. Введите название своего ЛПУ в поле ниже</span>
							<input type="text" name="update_address_lpu2" id="address_lpu_id2" class="required" placeholder="Введите адрес ЛПУ" value="<?php echo $userdata->register_address_lpu2; ?>">
						</label>
						<label class="register_address_hidden select-hidden">
							<span>Тип учреждения</span>
							<div class="input-hidden"><?php echo $userdata->register_type_institution; ?></div>
							<input type="text" name="update_type_institution" id="type_inst_id" class="required" placeholder="Искать по всем типам" value="<?php echo $userdata->register_type_institution; ?>">
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
							<div class="inst_content"><span><?php echo $userdata->register_name_institution; ?></span></div>
							<input type="text" name="update_name_institution" id="name_inst_id" class="required" placeholder="Начните вводить название учреждения" value="<?php echo $userdata->register_name_institution; ?>">
							<div class="name_inst"></div>
						</label>
						<label class="register_speciality_hidden select-hidden">
							<span>Специальность</span>
							<div class="input-hidden"><?php echo $userdata->register_speciality; ?></div>
							<input type="text" name="update_speciality" class="required" placeholder="Не выбрана" value="<?php echo $userdata->register_speciality; ?>">
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
							<input type="email" class="required" name="update_email" value="<?php echo $userdata->user_email; ?>">
						</label>
						<label>
							<span>Старый пароль</span>
							<input type="password" name="pwd1" class="required">
						</label>
						<label>
							<span>Новый пароль</span>
							<input type="password" name="pwd2" class="required">
						</label>
						<label>
							<span>Новый пароль ещё раз</span>
							<input type="password" name="pwd3" class="required">
						</label>
						<span class="validate-password-style">Минимум 8 символов, должна быть хотя бы одна буква и хотя бы одна цифра</span>
						<label>
							<span class="label-tel">Номер телефона</span>
							<input type="tel" class="required" name="update_phone" value="<?php echo $userdata->register_phone; ?>">
						</label>
					</div>
				</div>

			</div>

			<p class="error-message"></p>

			<button class="send-btn send-btn-profile">Сохранить</button>

		</form>
	</div>
</div>



<?php get_footer(); ?>