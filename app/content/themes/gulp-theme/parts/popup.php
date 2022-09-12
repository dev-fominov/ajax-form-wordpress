<?php global $user_ID; ?>

<!-- update profile -->
<div class="popup popup-update-profile">
	<div class="popup-dialog">
		<div class="popup-content">
			<div class="popup-close close-modal">
				<span class="top-line"></span>
				<span class="bottom-line"></span>
			</div>
			<div class="form-popup">
				<div class="title-popup">Изменения в настройках аккаунта<br> <b>успешно сохранены</b></div>
				<span class="btn-close close-modal">Ок</span>
			</div>
		</div>
	</div>
</div>

<!-- e-mail -->
<div class="popup popup-reset-password">
	<div class="popup-dialog">
		<div class="popup-content">
			<div class="popup-close close-modal">
				<span class="top-line"></span>
				<span class="bottom-line"></span>
			</div>
			<div class="form-popup">
				<div class="title-popup1">Ваш новый пароль успешно сохранен</div>
				<div class="title-popup2">Для входа на сайт используйте свою почту и новый пароль</div>
				<a href="/log-in" class="btn-close">Войти</a>
			</div>
		</div>
	</div>
</div>

<div class="popup popup-forgot">
	<div class="popup-dialog">
		<div class="popup-content">
			<div class="popup-close close-modal">
				<span class="top-line"></span>
				<span class="bottom-line"></span>
			</div>
			<div class="form-popup">
				<div class="title-popup1">Восстановление пароля</div>
				<div class="title-popup2">На почту <span class="user-email"></span> отправлено письмо. <br> Пожалуйста, пройдите по ссылке в письме и введите новый пароль.</div>
				<a href="/" class="btn-close">Ок</a>
			</div>
		</div>
	</div>
</div>

<div class="popup popup-register">
	<div class="popup-dialog">
		<div class="popup-content">
			<div class="popup-close close-modal">
				<span class="top-line"></span>
				<span class="bottom-line"></span>
			</div>
			<div class="form-popup">
				<div class="title-popup1">Подтвердите свою почту</div>
				<div class="title-popup2">На почту <span class="user-email"></span> отправлено письмо для подтверждения регистрации. <br> Пожалуйста, пройдите по ссылке в письме для завершения регистрации.</div>
				<a href="/doctors" class="btn-close">Ок</a>
			</div>
		</div>
	</div>
</div>

<div class="popup popup-photo">
	<div class="popup-dialog">
		<div class="popup-content">
			<div class="popup-close close-modal">
				<span class="top-line"></span>
				<span class="bottom-line"></span>
			</div>
			<div class="form-popup">
				<form id="update_photo_form" method="POST" name="ret">
					<?php wp_nonce_field('ajax-update-photo-nonce', 'update_photo_security'); ?>
					<div class="title-popup1">Редактирование фотографии аккаунта</div>
					<div class="edit-photo-box">
						<?php
						$myAvatar = get_the_author_meta('myAvatar', $user_ID);
						$turn = get_the_author_meta('turn', $user_ID);
						$range = get_the_author_meta('range', $user_ID);
						echo !empty($myAvatar) ? '<div class="img_photo"><img id="user_photo_ajax" style="transform:rotate(' . $turn . 'deg) scale(' . $range . ')" src="' . get_site_url() . "/wp-content/uploads/myAvatar/" . $myAvatar . '" /></div>' : '<div class="img_photo"><img id="user_photo_ajax" style="transform:rotate(' . $turn . 'deg) scale(' . $range . ')" src="' . get_site_url() . '/wp-content/uploads/myAvatar/default.jpg" /></div>';
						?>
						<div class="label-box">
							<label>
								<span>Размер</span>
								<div class="range-slider">
									<input type="range" name="range_slider_photo" class="input-submit" id="input-right" min="100" max="150" value="<?php echo $range ? $range : '125'; ?>" />
									<div class="slider-r">
										<div class="track"></div>
										<div class="range"></div>
										<div class="thumb right"></div>
									</div>
								</div>
							</label>
							<label>
								<span>Поворот</span>
								<input type="hidden" name="turn_photo" value="<?php echo $turn; ?>">
								<span class="svg-turn"><svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M3.07167 5C3.80935 3.72229 4.88601 2.67345 6.1826 1.96946C7.47919 1.26547 8.9452 0.93375 10.4186 1.01097C11.8919 1.08818 13.3152 1.57133 14.5311 2.40699C15.747 3.24266 16.7081 4.39828 17.3082 5.74611M1.23169 2.51537L1.9611 5.6749C2.08534 6.21303 2.62229 6.54856 3.16042 6.42433L6.31996 5.69492M16.9281 12.9999C16.1904 14.2776 15.1138 15.3264 13.8172 16.0304C12.5206 16.7344 11.0546 17.0661 9.58122 16.9889C8.10786 16.9117 6.68456 16.4286 5.46866 15.5929C4.25276 14.7572 3.29164 13.6016 2.69155 12.2538M18.7681 15.4845L18.0387 12.325C17.9144 11.7869 17.3775 11.4513 16.8394 11.5756L13.6798 12.305" stroke="white" stroke-width="1.5" stroke-linecap="round" />
									</svg></span>
							</label>
							<div class="div-label">
								<label>
									<span class="file">Выбрать другую фотографию</span>
									<input type="file" name="update_photo_input" id="update_photo_input" class="myImg">
								</label>
								<span class="svg-question"><svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M4.35938 9.44043H3.30469C3.31055 8.94238 3.36035 8.52051 3.4541 8.1748C3.54785 7.8291 3.7002 7.50977 3.91113 7.2168C4.12207 6.92383 4.40625 6.60156 4.76367 6.25C5.07422 5.93945 5.34961 5.65234 5.58984 5.38867C5.83008 5.11914 6.01758 4.82324 6.15234 4.50098C6.29297 4.17871 6.36328 3.7832 6.36328 3.31445C6.36328 2.85156 6.28125 2.44434 6.11719 2.09277C5.95312 1.74121 5.70703 1.46582 5.37891 1.2666C5.05078 1.06738 4.64062 0.967773 4.14844 0.967773C3.69727 0.967773 3.29297 1.05566 2.93555 1.23145C2.58398 1.40723 2.30566 1.66211 2.10059 1.99609C1.90137 2.32422 1.7959 2.72266 1.78418 3.19141H0.738281C0.75 2.52344 0.908203 1.95508 1.21289 1.48633C1.52344 1.01172 1.93359 0.651367 2.44336 0.405273C2.95898 0.15332 3.52734 0.0273438 4.14844 0.0273438C4.85156 0.0273438 5.44336 0.165039 5.92383 0.44043C6.41016 0.71582 6.7793 1.09961 7.03125 1.5918C7.28906 2.08398 7.41797 2.65527 7.41797 3.30566C7.41797 3.82715 7.33008 4.29883 7.1543 4.7207C6.97852 5.13672 6.73535 5.5293 6.4248 5.89844C6.11426 6.26758 5.75391 6.63965 5.34375 7.01465C4.96875 7.33691 4.71094 7.70605 4.57031 8.12207C4.42969 8.53223 4.35938 8.97168 4.35938 9.44043ZM3.16406 12.376C3.16406 12.1768 3.22852 12.0098 3.35742 11.875C3.48633 11.7344 3.66211 11.6641 3.88477 11.6641C4.10742 11.6641 4.2832 11.7344 4.41211 11.875C4.54688 12.0098 4.61426 12.1768 4.61426 12.376C4.61426 12.5693 4.54688 12.7363 4.41211 12.877C4.2832 13.0117 4.10742 13.0791 3.88477 13.0791C3.66211 13.0791 3.48633 13.0117 3.35742 12.877C3.22852 12.7363 3.16406 12.5693 3.16406 12.376Z" fill="#6AAD41" />
									</svg></span>
							</div>
							<div class="text-info">Можно загрузить картинку в формате png <br> и jpg. Размеры не меньше 200×200px, объём <br>файла не больше 5 МБ.</div>
						</div>
					</div>
					<div class="btn-box">
						<button class="save-photo">Да, сохранить</button>
						<span class="no-save-photo close-modal">Не сохранять</span>
						<span class="delete-photo" id="photo_remove">Удалить</span>
						<input type="checkbox" name="removemyAvatar" id="checkrem" style="display:none;">
					</div>
					<input type="hidden" name="user_id" value="<?php echo $user_ID; ?>">
					<input type="hidden" name="action" value="ajax_update_photo">
					<input type="hidden" name="site_dir" value="<?php echo get_site_url(); ?>">
					
				</form>
			</div>
		</div>
	</div>
</div>