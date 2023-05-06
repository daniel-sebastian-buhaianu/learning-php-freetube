<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<title>FreeTube | Sign Up</title>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/layout.css">
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/sign-in-up.css">
</head>
<body>
	<header>
		<h1 id="logo">FreeTube</h1>
		<nav>
			<p id="signIn">Sign In<p>
		</nav>
	</header>

	<main>

		<section id="form">
			<h1>Sign Up</h1>
			<form name='signUp' method='post'>
				<?php 
					if ($error['alert'] != '')
					{
						echo "<div class='form-alert'>" . $error['alert'] . "</div>";
					}
				?>
				<label for="email">Email</label>
				<input type='email' name='email' placeholder="Email" value="<?php echo $input['email']; ?>">
				<?php 
					if ($error['email'] != '')
					{
						echo "<div class='form-error'>" . $error['email'] . "</div>";
					}
				?>
				
				<label for="password">Password</label>
				<input type='password' name='password' placeholder="Password" value="<?php echo $input['password']; ?>">
				<?php 
					if ($error['password'] != '')
					{
						echo "<div class='form-error'>" . $error['password'] . "</div>";
					}
				?>

				<label for="confirmPassword">Confirm Password</label>
				<input type='password' name='confirmPassword' placeholder="Confirm Password" value="<?php echo $input['confirmPassword']; ?>">
				<?php 
					if ($error['confirmPassword'] != '')
					{
						echo "<div class='form-error'>" . $error['confirmPassword'] . "</div>";
					}
				?>

				<input id="signBtn" type='submit' name='signUp' value='Sign Up'>

				<p>Already have an account? <a href='<?php echo BASE_URL ?>signin.php'>Sign In</a></p>
			</form>
		</section>
		
	</main>

	<script type="module" src="<?php echo BASE_URL; ?>js/sign-up.js"></script>
</body>
</html>