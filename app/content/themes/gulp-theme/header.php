<!doctype html>
<html lang="ru-RU">

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo wp_get_document_title(); ?></title>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>


	<div class="rew">
		<a href="/log-in">Регистрация</a>
		<a href="/profile">Профиль</a>
	</div>

	<style>
		.rew {
			background: #FFFFFF;
			box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.15);
			height: 111px;
		}
	</style>