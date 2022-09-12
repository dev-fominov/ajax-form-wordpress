<?php

get_header(); ?>

<div class="reset-section">
	<div class="wrapper">
		<div class="reset-title">Изменение пароля</div>
		<p class="reset-description">Пароль должен содержать не менее восьми знаков и включать буквы и цифры</p>

		<form id="reset_password" method="POST">

			<?php wp_nonce_field('ajax-reset-password-nonce', 'reset_password_security'); ?>

			<div class="form-block">
				<div class="form-content">
					<label>
						<span>Новый<br> пароль</span>
						<input type="password" name="pwd2" class="required">
					</label>
					<label>
						<span>Введите новый пароль ещё раз</span>
						<input type="password" name="pwd3" class="required">
					</label>
				</div>
			</div>

			<p class="error-message"></p>

			<button class="send-btn">Сохранить</button>

		</form>

	</div>
</div>



<?php

get_footer();
