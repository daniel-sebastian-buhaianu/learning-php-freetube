<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='utf-8'>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<title>FreeTube | Sign Up</title>
		<link rel='stylesheet' type='text/css' href='<?php echo ROOT; ?>/assets/css/common.css'>
		<link rel='stylesheet' type='text/css' href='<?php echo ROOT; ?>/assets/css/sign-in-out.css'>
	</head>

	<body data-controller-name='<?php echo $controller_name ?>'>
		<header>
			<div id='logo'>
				<a href='<?php echo ROOT; ?>'>FreeTube</a>
			</div>

			<nav>
				<a href='<?php echo ROOT; ?>/sign-in'>Sign In</a>
			</nav>
		</header>

		<main>
			<form method='post'>

				<p class='form-title'>Sign Up</p>

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

				<div class='form-field-wrapper'>
					<label for='re-type-password'>Re-type Password:</label>
					<input 
						type='password' 
						name='re-type-password' 
						placeholder='Password' 
						value='<?php echo $inputs['re-type-password']; ?>'>

					<?php if ( ! empty( $errors['re-type-password'] ) ) {
							echo "<div class='form-error'>" . $errors['re-type-password'] . '</div>';
						}
					?>
				</div>

				<input class='submit-btn' type='submit' value='Sign Up'>

				<p>Already got an account? <a href='<?php echo ROOT ?>/sign-in'>Sign In</a></p>
			</form>
		</main>

	</body>
</html>