<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register</title>
</head>
<body>
	<header>
		<a href="../index.html">Home</a> >
		<span>Register</span>
		<hr>
		<h1>Register</h1>
	</header>

	<main>
		<p>To create a new account, please fill in the form below:</p>
		<form action="" method="post">

			<?php 
				if (isset($error['alert']))
				{
					if ($error['alert'] != '') 
					{ 
						echo "<div class='alert'>" . $error['alert'] . "</div>"; 
					} 
				}
			?>


			<label for="email">email: *</label>
			<input 
				type="email" 
				name="email"
				value="<?php if (isset($input['email'])) { echo $input['email']; } ?>"
			>
			<div class="error"><?php if (isset($error['email'])) { echo $error['email']; } ?></div>
			
			<br><br>

			<label for="password">password: *</label>
			<input 
				type="password" 
				name="password"
				value="<?php if (isset($input['password'])) { echo $input['password']; } ?>"
			>
			<div class="error"><?php if (isset($error['password'])) { echo $error['password']; } ?></div>
			
			<br><br>

			<label for="confirm_password">confirm_password: *</label>
			<input 
				type="password" 
				name="confirm_password"
				value="<?php if (isset($input['confirm_password'])) { echo $input['confirm_password']; } ?>"
			>
			<div class="error"><?php if (isset($error['confirm_password'])) { echo $error['confirm_password']; } ?></div>
			
			<br><br>

			<p class="required">* required fields</p>

			<input type="submit" name="submit" value="register"><hr>
		</form>
		<p>If you already have an account, <a href="../php/login.php">please log in.</a></p>
	</main>
	
</body>
</html>