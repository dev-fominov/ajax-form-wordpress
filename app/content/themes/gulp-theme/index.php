<?php get_header(); ?>

<h1>Hello World!!!</h1>

<?php

$user_ID = get_current_user_id();

if ($user_ID) {
	$user = get_user_by('id', $user_ID);
} else {
	$user_email = str_ireplace("%40", "@", $_GET['email']);
	$user = get_user_by('email', $user_email);
	$user_ID = $user->ID;
}

$user_security = $user->register_security;

print_r($user_security);
echo '<br>';
print_r($user_ID);
echo '<br>';
print_r($user->email_status);

if ($user_ID && $user->email_status !== 'active') {
	if (isset($_GET['email_status']) && isset($_GET['key']) && $_GET['email_status'] === 'active' && $_GET['key'] === $user_security) {
		update_user_meta($user_ID, 'email_status', $_GET['email_status']);
		echo '<div>Почту подтвердили, спасибо.</div>';
		print_r($user->email_status); ?>
		<script>
			if (typeof window.history.pushState == 'function') {
				window.history.pushState({}, "Hide", "<?php home_url(); ?>");
			}
		</script>
<?php
	} else {
		echo 'Не подтвердил почту';
	}
}

?>



<?php get_footer(); ?>