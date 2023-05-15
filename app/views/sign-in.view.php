<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='utf-8'>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<title>FreeTube | Sign In</title>
		<link rel='stylesheet' type='text/css' href='<?php echo ROOT; ?>/assets/css/common.css'>
		<link rel='stylesheet' type='text/css' href='<?php echo ROOT; ?>/assets/css/sign-in-out.css'>
	</head>

	<body data-controller-name='<?php echo $controller_name ?>'>
		<header>
			<div id='logo'>
				<a href='<?php echo ROOT; ?>'>FreeTube</a>
			</div>

			<nav>
				<a href='<?php echo ROOT; ?>/sign-up'>Sign Up</a>
			</nav>
		</header>

		<main>
			<form method='post'>

				<p class='form-title'>Sign In</p>

				<?php if ( ! empty( $errors['alert'] ) ) {
						echo "<div class='form-alert'>" . $errors['alert'] . '</div>';
					} 
				?>

				<div class='form-field-wrapper'>
					<label for='email'>Email:</label>
					<input 
						type='email' 
						name='email' 
						placeholder='Email' 
						value='<?php echo $inputs['email']; ?>'>

					<?php if ( ! empty( $errors['email'] ) ) {
							echo "<div class='form-error'>" . $errors['email'] . '</div>';
						}
					?>
				</div>
				
				<div class='form-field-wrapper'>
					<label for='password'>Password:</label>
					<input 
						type='password' 
						name='password' 
						placeholder='Password' 
						value='<?php echo $inputs['password']; ?>'>

					<?php if ( ! empty( $errors['password'] ) ) {
							echo "<div class='form-error'>" . $errors['password'] . '</div>';
						}
					?>
				</div>

				<input class='submit-btn' type='submit' value='Sign In'>

				<p>Don't have an account? <a href='<?php echo ROOT ?>/sign-up'>Sign Up</a></p>
			</form>
		</main>

	</body>
</html>